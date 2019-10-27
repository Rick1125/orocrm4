<?php

namespace FM\PlatformBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroMoneyType;
use Oro\Bundle\FormBundle\Form\Type\OroPercentType;
use Oro\Bundle\FormBundle\Form\Type\OroRichTextType;
use Oro\Bundle\TranslationBundle\Form\Type\TranslatableEntityType;
use FM\PlatformBundle\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
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
            ->add('link', TextType::class, ['required' => true, 'label' => 'Link'])
            ->add('nickname', TextType::class, ['required' => false, 'label' => 'Contact Name'])
            ->add('follower', TextType::class, ['required' => false, 'label' => 'Followers(Ten-Thousand)'])
            ->add('quoteDirect', OroMoneyType::class, ['required' => false, 'label' => 'Quote Direct'])
            ->add('quoteRepost', OroMoneyType::class, ['required' => false, 'label' => 'Quote Repost'])
            ->add('costDirect', OroMoneyType::class, ['required' => false, 'label' => 'Cost Direct'])
            ->add('costRepost', OroMoneyType::class, [ 'required' => false, 'label' => 'Cost Repost'])
            ->add('discount', OroPercentType::class, ['required' => false, 'label' => 'Discount'])
            ->add('memo', OroRichTextType::class, ['required' => false, 'label' => 'Resource Memo'])
        ;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function buildRelationFields(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'platform',
            TranslatableEntityType::class,
            [
                'class'    => 'FMPlatformBundle:Platform',
                'choice_label' => 'name',
                'required' => true,
                'multiple' => false,
                'expanded' => false
            ]
        );
        $builder->add(
            'channel',
            TranslatableEntityType::class,
            [
                'class'    => 'FMPlatformBundle:Channel',
                'choice_label' => 'name',
                'required' => true,
                'multiple' => false,
                'expanded' => false
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'           => Resource::class,
                'intention'            => 'role',
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
        return 'fm_resource';
    }
}
