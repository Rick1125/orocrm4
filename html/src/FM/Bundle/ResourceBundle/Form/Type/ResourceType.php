<?php

namespace FM\Bundle\ResourceBundle\Form\Type;

use Oro\Bundle\FormBundle\Form\Type\OroMoneyType;
use Oro\Bundle\FormBundle\Form\Type\OroPercentType;
use Oro\Bundle\FormBundle\Form\Type\OroRichTextType;
use Oro\Bundle\TranslationBundle\Form\Type\TranslatableEntityType;
use FM\Bundle\ResourceBundle\Entity\Resource;
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
            ->add('contactName', TextType::class, ['required' => false, 'label' => 'Contact Name'])
            ->add('follower', TextType::class, ['required' => false, 'label' => 'Followers(Ten-Thousand)'])
            ->add('quoteDirect', OroMoneyType::class, ['required' => false, 'label' => 'Quote Direct', 'empty_data' => 0])
            ->add('quoteRepost', OroMoneyType::class, ['required' => false, 'label' => 'Quote Repost', 'empty_data' => 0])
            ->add('costDirect', OroMoneyType::class, ['required' => false, 'label' => 'Cost Direct', 'empty_data' => 0])
            ->add('costRepost', OroMoneyType::class, [ 'required' => false, 'label' => 'Cost Repost', 'empty_data' => 0])
            ->add('discount', OroPercentType::class, ['required' => false, 'label' => 'Discount', 'empty_data' => 1])
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
                'class'    => 'FMResourceBundle:Platform',
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
                'class'    => 'FMResourceBundle:Channel',
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
