<?php

namespace FM\Bundle\ResourceBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use FM\Bundle\ResourceBundle\Entity\Channel;

class LoadChannelData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $channels = [
            "鼓山" => 0, "楼氏" => 0, "蜂群" => 0, "牙仙" => 0, "大禹" => 0, "创客" => 0, "锐拓" => 0
        ];

        foreach ($channels as $name => $personal) {
            $channel = new Channel();
            $channel
                ->setName($name)
                ->setPerson($personal)
            ;
            $manager->persist($channel);
        }

        $manager->flush();
    }
}
