<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2017/11/28
 * Time: 14:32
 */
namespace FM\PlatformBundle\ImportExport\Strategy;

use FM\PlatformBundle\Entity\Channel;
use FM\PlatformBundle\Entity\Platform;
use FM\PlatformBundle\Entity\Resource;
use Oro\Bundle\ImportExportBundle\Strategy\Import\ConfigurableAddOrReplaceStrategy;
use Oro\Bundle\OrganizationBundle\Entity\BusinessUnit;

class AddBuStrategy extends ConfigurableAddOrReplaceStrategy
{
    /**
     * @param $id
     * @return null|object
     */
    public function getBusinessUnit($id)
    {
        $id = $id?:1;
        $em = $this->databaseHelper;
        return $em->findOneBy(BusinessUnit::class, ['id' => $id]);
    }

    /**
     * @param $link
     * @return null|Platform
     */
    public function getPlatform($link)
    {
        $em = $this->doctrineHelper->getEntityManager(Platform::class);
        $qb = $em->createQueryBuilder();
        $qb
            ->from("FMPlatformBundle:Platform", 'p')
            ->select('p')
        ;
        $platforms = $qb->getQuery()->getResult();

        $u = parse_url($link);
        if (isset($u['host'])) {
            foreach ($platforms as $platform) {
                if ($u["host"] == $platform->getMatchRule()) {
                    return $platform;
                }
            }
        } else {
            foreach ($platforms as $platform) {
                if (1 === preg_match('#'.$platform->getMatchRule().'#', $link)) {
                    return $platform;
                }
            }
        }

        return null;
    }

    /**
     * @param Resource $entity
     */
    public function upsertChannel(Resource $entity)
    {
        $repo = $this->databaseHelper;
        $em = $this->doctrineHelper->getEntityManager(Channel::class);
        $channel = $repo->findOneBy(Channel::class, ['name' => $entity->getChannelName()]);
        if (!$channel) {
            $channel = new Channel();
            $channel->setName($entity->getChannelName())->setPerson($entity->isPerson());
            $channel->addResource($entity);
            $em->persist($channel);
        } else {
            $channel->addResource($entity);
        }
//        $entity->setChannel($channel);
    }
}
