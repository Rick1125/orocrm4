<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2017/11/27
 * Time: 12:39
 */
namespace FM\PlatformBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;

/**
 * @RouteResource("project")
 * @NamePrefix("fm_api_")
 */
class ProjectController extends RestController
{
    /**
     * Delete Project
     *
     * @param int $id Resource id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Acl(
     *      id="fm_project_delete",
     *      type="entity",
     *      class="FMPlatformBundle:Project",
     *      permission="DELETE"
     * )
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->get('fm.api.manager');
    }

    /**
     * {@inheritdoc}
     */
    public function getFormHandler()
    {
        throw new \BadMethodCallException('FormHandler is not available.');
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        throw new \BadMethodCallException('FormHandler is not available.');
    }
}
