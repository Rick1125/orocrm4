<?php

namespace FM\PlatformBundle\Datagrid\Extension\MassAction;

use Doctrine\ORM\EntityManager;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FM\PlatformBundle\Constant\Status;
use FM\PlatformBundle\Entity\Resource;
use InvalidArgumentException as InvalidArgumentExceptionAlias;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use Symfony\Contracts\Translation\TranslatorInterface;

use Oro\Bundle\SecurityBundle\ORM\Walker\AclHelper;

use Oro\Bundle\DataGridBundle\Datasource\ResultRecord;
use Oro\Bundle\DataGridBundle\Extension\MassAction\MassActionResponse;
use Oro\Bundle\DataGridBundle\Extension\MassAction\MassActionHandlerArgs;
use Oro\Bundle\DataGridBundle\Extension\MassAction\MassActionHandlerInterface;

class ResourceHandler implements MassActionHandlerInterface
{
    const FLUSH_BATCH_SIZE = 100;

    /** @var AclHelper */
    protected $aclHelper;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var string */
    protected $successMessage;

    /** @var string */
    protected $errorMessage;

    /**
     * @param AclHelper             $aclHelper
     * @param TokenStorageInterface $tokenStorage
     * @param TranslatorInterface   $translator
     * @param string                $successMessage
     * @param string                $errorMessage
     */
    public function __construct(
        AclHelper $aclHelper,
        TokenStorageInterface $tokenStorage,
        TranslatorInterface $translator,
        $successMessage,
        $errorMessage
    ) {
        $this->aclHelper      = $aclHelper;
        $this->tokenStorage   = $tokenStorage;
        $this->translator     = $translator;
        $this->successMessage = $successMessage;
        $this->errorMessage   = $errorMessage;
    }

    /**
     * @throws OptimisticLockException
     * @throws InvalidArgumentExceptionAlias
     * @throws ORMException
     * {@inheritdoc}
     */
    public function handle(MassActionHandlerArgs $args)
    {
        $token = $this->tokenStorage->getToken();
        $count = 0;
        if ($token) {
            set_time_limit(0);
            $results = $args->getResults();
            $query   = $results->getSource();
            $this->aclHelper->apply($query, 'EDIT');
            $em = $results->getSource()->getEntityManager();

            $processedEntities = [];
            foreach ($results as $result) {
                if ($this->processResource($result)) {
                    $count++;
                }
                $processedEntities[] = $result->getRootEntity();
                if ($count % self::FLUSH_BATCH_SIZE === 0) {
                    $this->finishBatch($em, $processedEntities);
                    $processedEntities = [];
                }
            }

            $this->finishBatch($em, $processedEntities);
        }

        return $count > 0
            ? new MassActionResponse(true, $this->translator->trans($this->successMessage, ['%count%' => $count]))
            : new MassActionResponse(false, $this->translator->trans($this->errorMessage, ['%count%' => $count]));
    }

    /**
     * @param ResultRecord $result
     *
     * @return bool
     */
    protected function processResource(ResultRecord $result)
    {
        $resource = $result->getRootEntity();
        if (!$resource instanceof Resource) {
            return false;//unexpected result record
        }
        if ($resource->getStatus() === Status::IN_PROGRESS) {
            return false;//do not count not affected records
        }
//        $resource->setStatus(Status::IN_PROGRESS);

        return true;
    }

    /**
     * @param EntityManager $em
     * @param []Resource $processedEntities
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    protected function finishBatch(EntityManager $em, $processedEntities)
    {
        foreach ($processedEntities as $entity) {
            $em->flush($entity);
            $em->detach($entity);
        }
    }
}
