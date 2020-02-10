<?php

namespace App\Form;

use App\Entity\Travaux;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TravauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('ville')
            ->add('description')
            ->add('pictureFile', VichFileType::class, [
                'required' =>false,
                'label' =>'Votre image'
            ])
            ->add('createdAt', DateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Travaux::class,
            'translation_domain' => 'forms',
        ]);
    }
}
