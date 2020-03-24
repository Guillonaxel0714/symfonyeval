<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom' , TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Nom de l'article"]
        ])
        ->add('photo', FileType::class, [
            'data_class' => null
    ])
            ->add('quantite' , TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Quantité souhaitez"]

        ])
            ->add('prix' , TextType::class, [
                'label' => false,
                'attr' => ["placeholder" => "Prix souhaitez"]
        ])
            ->add('submit',SubmitType::class, [
                'attr'=> ["class" => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
