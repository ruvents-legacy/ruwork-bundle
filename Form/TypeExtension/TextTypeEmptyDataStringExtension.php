<?php

namespace Ruvents\RuworkBundle\Form\TypeExtension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextTypeEmptyDataStringExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'empty_data' => '',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return TextType::class;
    }
}
