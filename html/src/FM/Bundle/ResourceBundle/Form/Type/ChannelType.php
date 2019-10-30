<?php

namespace FM\Bundle\ResourceBundle\Form\Type;

use FM\Bundle\ResourceBundle\Entity\Channel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChannelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->buildPlainFields($builder, $options);
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
            ->add('person', CheckboxType::class, ['required' => false, 'label' => 'Personal KOL'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'           => Channel::class,
                'intention'            => 'channel',
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
        return 'fm_channel';
    }
}
