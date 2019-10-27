<?php

namespace FM\PlatformBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\EntityIdentifierType;
use Oro\Bundle\FormBundle\Form\Type\OroDateType;
use Oro\Bundle\FormBundle\Form\Type\OroMoneyType;
use Oro\Bundle\FormBundle\Form\Type\OroPercentType;
use Oro\Bundle\FormBundle\Form\Type\OroResizeableRichTextType;
use Oro\Bundle\UserBundle\Form\Type\OrganizationUserAclSelectType;
use FM\PlatformBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
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
            ->add('budget', OroMoneyType::class, ['required' => true, 'label' => 'Total Budget'])
            ->add('quote', OroMoneyType::class, ['required' => true, 'label' => 'Quote'])
            ->add('profitRate', OroPercentType::class, ['required' => false, 'label' => 'Profit Rate']) //需要权限才能view和update
            ->add('launchedAt', OroDateType::class, ['required' => true, 'label' => 'Launched At'])
            ->add('expiredAt', OroDateType::class, ['required' => true, 'label' => 'Expired At'])
            ->add('description', OroResizeableRichTextType::class, ['required' => false, 'label' => 'Description'])
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
            'appendResources',
            EntityIdentifierType::class,
            array(
                'class'    => 'FMPlatformBundle:Resource',
                'required' => false,
                'mapped'   => false,
                'multiple' => true,
            )
        );
        $builder->add(
            'removeResources',
            EntityIdentifierType::class,
            array(
                'class'    => 'FMPlatformBundle:Resource',
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
                'data_class'           => Project::class,
                'intention'            => 'project',
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
        return 'fm_project';
    }
}
