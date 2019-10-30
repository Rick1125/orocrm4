<?php

namespace FM\Bundle\ResourceBundle\Controller;

use FM\Bundle\ResourceBundle\Entity\Resource;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ResourceController
 *
 * @Route("/resource")
 * @package FM\ResourceBundle\Controller
 */
class ResourceController extends AbstractController
{
    /**
     * @Route("/", name="fm_resource_index")
     * @AclAncestor("fm_resource_view")
     * @Template()
     */
    public function indexAction()
    {
        return [
            'entity_class' => Resource::class
        ];
    }

    /**
     * @Route("/view/{id}", name="fm_resource_view", requirements={"id"="\d+"})
     * @AclAncestor("fm_resource_view")
     * @Template()
     * @param Resource $resource
     * @return array
     */
    public function viewAction(Resource $resource)
    {
        return ['entity' => $resource];
    }

    /**
     * @Route("/create", name="fm_resource_create")
     * @AclAncestor("fm_resource_create")
     * @Template("FMResourceBundle:Resource:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new Resource());
    }

    /**
     * @Route("/update/{id}", name="fm_resource_update", requirements={"id"="\d+"})
     * @AclAncestor("fm_resource_update")
     * @Template("FMResourceBundle:Resource:update.html.twig")
     * @param Resource $entity
     * @return array
     */
    public function updateAction(Resource $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Resource $entity
     * @return array
     */
    protected function update(Resource $entity)
    {
        return $this->get('oro_form.update_handler')->update(
            $entity,
            $this->get('fm.form.resource'),
            'Success! Resource created/updated!',
            null,
            'fm_form_handler',
            null
        );
    }

    /**
     * @Route("/widget/info/{id}", name="fm_resource_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("fm_resource_view")
     * @Template("FMResourceBundle:Resource/widget:info.html.twig")
     * @param Resource $resource
     * @return array
     */
    public function infoAction(Resource $resource)
    {
        return ['resource' => $resource];
    }
}
