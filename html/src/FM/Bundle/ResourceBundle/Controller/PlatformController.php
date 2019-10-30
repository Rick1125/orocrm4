<?php

namespace FM\Bundle\ResourceBundle\Controller;

use FM\Bundle\ResourceBundle\Entity\Platform;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PlatformController
 *
 * @Route("/platform")
 * @package FM\ResourceBundle\Controller
 */
class PlatformController extends AbstractController
{
    /**
     * @Route("/", name="fm_platform_index")
     * @AclAncestor("fm_resource_view")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/create", name="fm_platform_create")
     * @AclAncestor("fm_resource_create")
     * @Template("FMResourceBundle:Platform:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new Platform());
    }

    /**
     * @param Platform $entity
     * @return array
     */
    protected function update(Platform $entity)
    {
        return $this->get('oro_form.update_handler')->update(
            $entity,
            $this->get('fm.form.platform'),
            'Success! platform created/updated!',
            null,
            'fm_form_handler',
            null
        );
    }
}
