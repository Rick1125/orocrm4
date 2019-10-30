<?php

namespace FM\Bundle\ResourceBundle\Migrations\Data\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

use FM\Bundle\ResourceBundle\Entity\Platform;

class LoadPlatformData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $platforms = [
            'WeChat' => '.*',
            '新浪微博' => 'weibo.com',
            '抖音' => 'www.douyin.com',
            'B站' => 'www.bilibili.com',
            '快手' => 'm.kuaishou.com',
            '今日头条' => 'www.toutiao.com',
            'QQ空间' => 'user.qzone.qq.com',
            '小红书' => 'www.xiaohongshu.com',
            '秒拍' => 'miaopai.com',
            '知乎' => 'www.zhihu.com',
            '抖音V' => 'v.douyin.com',
        ];

        foreach ($platforms as $name => $rule) {
            $p = new Platform();
            $p->setName($name)->setMatchRule($rule);
            $manager->persist($p);
        }

        $manager->flush();
    }
}
