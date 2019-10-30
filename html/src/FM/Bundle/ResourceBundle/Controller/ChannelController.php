<?php

namespace FM\Bundle\ResourceBundle\Controller;

use FM\Bundle\ResourceBundle\Entity\Channel;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ChannelController
 *
 * @Route("/chgroup")
 * @package FM\ResourceBundle\Controller
 */
class ChannelController extends AbstractController
{
    /**
     * @Route("/", name="fm_channel_index")
     * @AclAncestor("fm_resource_view")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/create", name="fm_channel_create")
     * @Acl(
     *      id="fm_channel_create",
     *      type="entity",
     *      class="FMResourceBundle:Channel",
     *      permission="CREATE"
     * )
     * @Template("FMResourceBundle:Channel:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new Channel());
    }

    /**
     * @param Channel $entity
     * @return array
     */
    protected function update(Channel $entity)
    {
        return $this->get('oro_form.update_handler')->update(
            $entity,
            $this->get('fm.form.channel'),
            'Success! Channel created/updated!',
            null,
            'fm_form_handler',
            null
        );
    }
}
