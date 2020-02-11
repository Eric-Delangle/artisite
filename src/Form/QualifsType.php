<?php

namespace App\Form;

use App\Entity\Qualifs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class QualifsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('ecole')
            ->add('createdAt', BirthdayType::class, [
                'label' => 'Obtenue le'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Qualifs::class,
            'translation_domain' => 'forms',
        ]);
    }
}
