<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2017/11/27
 * Time: 15:28
 */
namespace FM\PlatformBundle\ImportExport\Processor;

use FM\PlatformBundle\Entity\Resource;
use Oro\Bundle\ImportExportBundle\Processor\ImportProcessor;

class FillBuProcessor extends ImportProcessor
{
    public function process($item)
    {
        /** @var Resource $entity */
        $entity = parent::process($item);

        if ($entity) {
            $buId = $this->context->getOption('owner');
            $businessUnit = $this->strategy->getBusinessUnit($buId);
            $platform = $this->strategy->getPlatform($entity->getLink());
            if ($platform) {
                $entity->setPlatform($platform);
            }
            $this->strategy->upsertChannel($entity);
            $entity->setOwner($businessUnit);
            $entity->setLinkHash(md5($entity->getLink()));
            if ($entity->getQuoteDirect() <= 0 && $entity->getDiscount() > 0) {
                $entity->setQuoteDirect($entity->getCostDirect() * $entity->getDiscount() * Resource::QUOTE_INDEX);
            }
            if ($entity->getQuoteRepost() <= 0 && $entity->getDiscount() > 0) {
                $entity->setQuoteRepost($entity->getCostRepost() * $entity->getDiscount() * Resource::QUOTE_INDEX);
            }
            $entity->setUpdatedAt(new \DateTime('now'));
//            $entity->setCreatedBy($user);
        }

        return $entity;
    }
}
