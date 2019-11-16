<?php

namespace FM\Bundle\ProjectBundle\Form\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use FM\Bundle\ProjectBundle\Entity\Project;
use Oro\Bundle\FormBundle\Form\Handler\RequestHandlerTrait;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ProjectHandler
{
    use RequestHandlerTrait;

    /**
     * @var FormInterface
     */
    protected $form;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @param FormInterface $form
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $manager
     */
    public function __construct(FormInterface $form, RequestStack $requestStack, EntityManagerInterface $manager)
    {
        $this->form    = $form;
        $this->requestStack = $requestStack;
        $this->manager = $manager;
    }

    /**
     * Process form
     *
     * @param Project $entity
     *
     * @return bool True on successful processing, false otherwise
     * @throws \Exception
     */
    public function process(Project $entity)
    {
        $this->form->setData($entity);

        $request = $this->requestStack->getCurrentRequest();
        if (in_array($request->getMethod(), ['POST', 'PUT'], true)) {
            $this->submitPostPutRequest($this->form, $request);

            if ($this->form->isValid()) {
                $appendResources = $this->form->get('appendResources')->getData();
                $removeResources = $this->form->get('removeResources')->getData();
                $this->onSuccess($entity, $appendResources, $removeResources);

                return true;
            }
        }

        return false;
    }

    /**
     * "Success" form handler
     *
     * @param Project $entity
     * @param array $appendResources
     * @param array $removeResources
     * @throws \Exception
     */
    protected function onSuccess(Project $entity, array $appendResources, array $removeResources)
    {
        $this->appendResources($entity, $appendResources);
        $this->removeResources($entity, $removeResources);

        $this->manager->persist($entity);
        $this->setUpdatedAt($entity);

        $this->manager->flush();
    }

    /**
     * Set updated at to current DateTime when related entities updated
     * TODO: consider refactoring of this feature to make it applicable to all entities
     *
     * @param Project $entity
     * @throws \Exception
     */
    protected function setUpdatedAt(Project $entity)
    {
        /** @var UnitOfWork $uow */
        $uow = $this->manager->getUnitOfWork();
        $uow->computeChangeSets();

        $isEntityChanged   = count($uow->getEntityChangeSet($entity)) > 0;
        $isRelationChanged = count($uow->getScheduledEntityUpdates()) > 0 ||
            count($uow->getScheduledCollectionUpdates()) > 0 ||
            count($uow->getScheduledCollectionDeletions()) > 0;

        if (false === $isEntityChanged && $isRelationChanged) {
            $entity->setUpdatedAt(new \DateTime('now', new \DateTimeZone('UTC')));
            $this->manager->persist($entity);
        }
    }

    /**
     * Append resources to project
     *
     * @param Project $project
     * @param Resource[] $resources
     */
    protected function appendResources(Project $project, array $resources)
    {
        foreach ($resources as $resource) {
            $project->addResource($resource);
        }
    }

    /**
     * Remove contacts from account
     *
     * @param Project $project
     * @param Resource[] $resources
     */
    protected function removeResources(Project $project, array $resources)
    {
        foreach ($resources as $resource) {
            $project->removeResource($resource);
        }
    }
}
