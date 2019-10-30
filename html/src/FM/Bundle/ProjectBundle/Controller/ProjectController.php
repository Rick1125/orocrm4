<?php

namespace FM\Bundle\ProjectBundle\Controller;

use FM\Bundle\ProjectBundle\Entity\Project;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProjectController
 *
 * @Route("/project")
 * @package FM\ProjectBundle\Controller
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="fm_project_index")
     * @AclAncestor("fm_project_view")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="fm_project_view", requirements={"id"="\d+"})
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
     * @Route("/create", name="fm_project_create")
     * @AclAncestor("fm_project_create")
     * @Template("FMProjectBundle:Project:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new Project());
    }

    /**
     * @Route("/update/{id}", name="fm_project_update", requirements={"id"="\d+"})
     * @AclAncestor("fm_project_update")
     * @Template("FMProjectBundle:Project:update.html.twig")
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
     * @Route("/widget/info/{id}", name="fm_project_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("fm_project_view")
     * @Template("FMProjectBundle:Project/widget:info.html.twig")
     * @param project $project
     * @return array
     */
    public function infoAction(Project $project)
    {
        return ['project' => $project];
    }
}
