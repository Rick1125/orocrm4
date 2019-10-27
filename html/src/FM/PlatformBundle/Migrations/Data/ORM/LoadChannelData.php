<?php

namespace FM\PlatformBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use FM\PlatformBundle\Entity\Channel;
use FM\PlatformBundle\Entity\Platform;

class LoadChannelData extends AbstractFixture
{

    public function load(ObjectManager $manager)
    {
        $channels = [
            "鼓山", "楼氏", "蜂群", "牙仙", "大禹", "创客", "锐拓"
        ];

        foreach ($channels as $name) {
            $channel = new Channel();
            $channel
                ->setName($name)
            ;
            $manager->persist($channel);
        }

        $platforms = [
            'WeChat' => '.*',
            '新浪微博' => 'weibo.com',
            '抖音' => 'www.douyin.com',
            'B站' => 'www.bilibili.com',
        ];

        foreach ($platforms as $name => $rule) {
            $p = new Platform();
            $manager->persist($p->setName($name)->setMatchRule($rule));
        }

        $manager->flush();
    }
}
