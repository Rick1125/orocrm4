<?php

namespace FM\PlatformBundle\Controller;

use FM\PlatformBundle\Entity\Project;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ProjectController
 *
 * @BaseRoute("/project")
 * @package FM\PlatformBundle\Controller
 */
class ProjectController extends AbstractController
{
    /**
     * @BaseRoute("/", name="fm_project_index")
     * @AclAncestor("fm_project_view")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @BaseRoute("/view/{id}", name="fm_project_view", requirements={"id"="\d+"})
     * @AclAncestor("fm_project_view")
     * @Template()
     * @param Project $project
     * @return array
     */
    public function viewAction(Project $project)
    {
        return ['entity' => $project];
    }

    /**
     * @BaseRoute("/create", name="fm_project_create")
     * @AclAncestor("fm_project_create")
     * @Template("FMPlatformBundle:Project:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new Project());
    }

    /**
     * @BaseRoute("/update/{id}", name="fm_project_update", requirements={"id"="\d+"})
     * @AclAncestor("fm_project_update")
     * @Template("FMPlatformBundle:Project:update.html.twig")
     * @param project $entity
     * @return array
     */
    public function updateAction(Project $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Project $entity
     * @return array
     */
    protected function update(Project $entity)
    {
        return $this->get('oro_form.update_handler')->update(
            $entity,
            $this->get('fm.form.project'),
            'Success! Project created/updated!',
            null,
            'fm_form_handler',
            null
        );
    }

    /**
     * @BaseRoute("/widget/info/{id}", name="fm_project_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("fm_project_view")
     * @Template("FMPlatformBundle:Project/widget:info.html.twig")
     * @param project $project
     * @return array
     */
    public function infoAction(Project $project)
    {
        return ['project' => $project];
    }
}
