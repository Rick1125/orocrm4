<?php

namespace FM\PlatformBundle\Controller;

use FM\PlatformBundle\Entity\Contract;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ContractController
 *
 * @Route("/contract")
 * @package FM\PlatformBundle\Controller
 */
class ContractController extends Controller
{
    /**
     * @Route("/", name="fm_contract_index")
     * @AclAncestor("fm_contract_view")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="fm_contract_view", requirements={"id"="\d+"})
     * @Acl(
     *      id="fm_contract_view",
     *      type="entity",
     *      class="FMPlatformBundle:Contract",
     *      permission="VIEW"
     * )
     * @Template()
     * @param Contract $contract
     * @return array
     */
    public function viewAction(Contract $contract)
    {
        return ['entity' => $contract];
    }

    /**
     * @Route("/create", name="fm_contract_create")
     * @Acl(
     *      id="fm_contract_create",
     *      type="entity",
     *      class="FMPlatformBundle:Contract",
     *      permission="CREATE"
     * )
     * @Template("FMPlatformBundle:Contract:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new contract());
    }

    /**
     * @Route("/update/{id}", name="fm_contract_update", requirements={"id"="\d+"})
     * @Acl(
     *      id="fm_contract_update",
     *      type="entity",
     *      class="FMPlatformBundle:Contract",
     *      permission="EDIT"
     * )
     * @Template("FMPlatformBundle:Contract:update.html.twig")
     * @param contract $entity
     * @return array
     */
    public function updateAction(contract $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Contract $entity
     * @return array
     */
    protected function update(Contract $entity)
    {
        return $this->get('oro_form.update_handler')->update(
            $entity,
            $this->get('fm.form.contract'),
            'Success! contract created/updated!',
            null,
            'fm_form_handler',
            null
        );
    }

    /**
     * @Route("/widget/info/{id}", name="fm_contract_widget_info", requirements={"id"="\d+"})
     * @AclAncestor("fm_contract_view")
     * @Template("FMPlatformBundle:Contract/widget:info.html.twig")
     * @param Contract $contract
     * @return array
     */
    public function infoAction(Contract $contract)
    {
        return ['contract' => $contract];
    }
}
