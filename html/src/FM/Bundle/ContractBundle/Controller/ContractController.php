<?php

namespace FM\Bundle\ContractBundle\Controller;

use FM\Bundle\ContractBundle\Entity\Contract;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContractController
 *
 * @package FM\Bundle\ContractBundle\Controller
 */
class ContractController extends AbstractController
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
     * @AclAncestor("fm_contract_view")
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
     * @AclAncestor("fm_contract_create")
     * @Template("FMContractBundle:Contract:update.html.twig")
     */
    public function createAction()
    {
        return $this->update(new contract());
    }

    /**
     * @Route("/update/{id}", name="fm_contract_update", requirements={"id"="\d+"})
     * @AclAncestor("fm_contract_update")
     * @Template("FMContractBundle:Contract:update.html.twig")
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
     * @Template("FMContractBundle:Contract/widget:info.html.twig")
     * @param Contract $contract
     * @return array
     */
    public function infoAction(Contract $contract)
    {
        return ['contract' => $contract];
    }
}
