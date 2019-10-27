<?php

namespace FM\PlatformBundle\Controller;

use FM\PlatformBundle\Entity\Platform;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PlatformController
 *
 * @Route("/platform")
 * @package FM\PlatformBundle\Controller
 */
class PlatformController extends Controller
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
     * @Acl(
     *      id="fm_platform_create",
     *      type="entity",
     *      class="FMPlatformBundle:Platform",
     *      permission="CREATE"
     * )
     * @Template("FMPlatformBundle:Platform:update.html.twig")
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
