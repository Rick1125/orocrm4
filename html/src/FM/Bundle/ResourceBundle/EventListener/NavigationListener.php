<?php

namespace FM\Bundle\ResourceBundle\EventListener;

use Doctrine\ORM\EntityRepository;
use FM\Bundle\ResourceBundle\Entity\Platform;
use Knp\Menu\ItemInterface;

use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Oro\Bundle\EntityConfigBundle\Provider\ConfigProvider;
use Oro\Bundle\FeatureToggleBundle\Checker\FeatureChecker;
use Oro\Bundle\NavigationBundle\Event\ConfigureMenuEvent;
use Oro\Bundle\NavigationBundle\Utils\MenuUpdateUtils;
use Oro\Bundle\SecurityBundle\Authentication\TokenAccessorInterface;
use Oro\Bundle\SecurityBundle\ORM\Walker\AclHelper;

class NavigationListener
{
    /** @var DoctrineHelper */
    protected $doctrineHelper;

    /** @var ConfigProvider */
    protected $entityConfigProvider;

    /** @var TokenAccessorInterface */
    protected $tokenAccessor;

    /** @var AclHelper */
    protected $aclHelper;

    /** @var FeatureChecker */
    protected $featureChecker;

    /**
     * @param DoctrineHelper         $doctrineHelper
     * @param ConfigProvider         $entityConfigProvider
     * @param TokenAccessorInterface $tokenAccessor
     * @param AclHelper              $aclHelper
     */
    public function __construct(
        DoctrineHelper $doctrineHelper,
        ConfigProvider $entityConfigProvider,
        TokenAccessorInterface $tokenAccessor,
        AclHelper $aclHelper
    ) {
        $this->doctrineHelper = $doctrineHelper;
        $this->entityConfigProvider = $entityConfigProvider;
        $this->tokenAccessor = $tokenAccessor;
        $this->aclHelper = $aclHelper;
    }

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onNavigationConfigure(ConfigureMenuEvent $event)
    {
        if (!$this->tokenAccessor->hasUser()) {
            return;
        }

        $projectsMenuItem = MenuUpdateUtils::findMenuItem($event->getMenu(), 'fm_project_tab');
        if (!$projectsMenuItem || !$projectsMenuItem->isDisplayed()) {
            return;
        }

        /** @var EntityRepository $repo */
        $repo = $this->doctrineHelper->getEntityRepositoryForClass(Platform::class);
        $platforms = $repo->findAll();
        if (!$platforms) {
            return;
        }

        $this->buildPlatformMenu($projectsMenuItem, $platforms);
        $this->addDivider($projectsMenuItem);
    }

    /**
     * Build report menu
     *
     * @param ItemInterface $projectsItem
     * @param array         $platforms
     *  key => entity label
     *  value => array of reports id's and label's
     */
    protected function buildPlatformMenu(ItemInterface $projectsItem, $platforms)
    {
        foreach ($platforms as $platform) {
            $projectsItem
                ->addChild(
                    $platform->getName(),
                    [
                        'label'           => $platform->getName(),
                        'route'           => 'fm_project_index',
                        'extras'          => ['position' => $platform->getId()]
//                            'routeParameters' => [
//                                'id' => $reportId
//                            ]
                    ]
                );
        }
    }

    /**
     * Adds a divider to the given menu
     *
     * @param ItemInterface $menu
     */
    protected function addDivider(ItemInterface $menu)
    {
        $menu->addChild('divider-' . rand(1, 99999))
            ->setLabel('')
            ->setExtra('divider', true)
            ->setExtra('position', 15); // after manage report, we have 10 there
    }
}
