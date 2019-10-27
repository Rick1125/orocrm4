<?php

namespace FM\PlatformBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;


class StatusType extends AbstractType
{
    const NAME = 'fm_status';

    /**
     * @return string
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
        return self::NAME;
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'choices'     => ['enabled' => 'Enabled', 'disabled' => 'Disabled'],
                'multiple'    => false,
                'expanded'    => false,
                'empty_value' => 'Choose a status',
                'translatable_options' => false
            )
        );
    }
}
