<?php

namespace FM\Bundle\ContractBundle\Form\Type;

use FM\Bundle\ResourceBundle\Form\Type\StatusType;
use Oro\Bundle\FormBundle\Form\Type\EntityIdentifierType;
use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Oro\Bundle\FormBundle\Form\Type\OroMoneyType;
use Oro\Bundle\FormBundle\Form\Type\OroResizeableRichTextType;
use Oro\Bundle\UserBundle\Form\Type\OrganizationUserAclSelectType;
use FM\Bundle\ContractBundle\Entity\Contract;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildPlainFields($builder, $options);
        $this->buildRelationFields($builder, $options);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    protected function buildPlainFields(FormBuilderInterface $builder, array $options)
    {
        // basic plain fields
        $builder
            ->add('name', TextType::class, ['required' => true, 'label' => 'Name'])
            ->add('status', StatusType::class, ['required' => true, 'label' => 'Status'])
            ->add('amount', OroMoneyType::class, ['required' => true, 'label' => 'Total Amount'])
            ->add('description', OroResizeableRichTextType::class, ['required' => true, 'label' => 'Description'])
            ->add('launchedAt', OroDateType::class, ['required' => true, 'label' => 'Launched At'])
            ->add('expiredAt', OroDateType::class, ['required' => true, 'label' => 'Expired At'])
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function buildRelationFields(FormBuilderInterface $builder, array $options)
    {
        // assigned to (user)
        $builder->add(
            'assignedTo',
            OrganizationUserAclSelectType::class,
            ['required' => true, 'label' => 'Assigned To']
        );
        $builder->add(
            'appendProjects',
            EntityIdentifierType::class,
            array(
                'class'    => 'FMResourceBundle:Project',
                'required' => false,
                'mapped'   => false,
                'multiple' => true,
            )
        );
        $builder->add(
            'removeProjects',
            EntityIdentifierType::class,
            array(
                'class'    => 'FMResourceBundle:Project',
                'required' => false,
                'mapped'   => false,
                'multiple' => true,
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'           => Contract::class,
                'intention'            => 'contract',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fm_contract';
    }
}
