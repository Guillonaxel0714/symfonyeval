<?php

namespace App\Form;

use App\Entity\Paniers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('quantite' , TextType::class, [
            'label' => false,
            'attr' => ["placeholder" => "Quantité souhaitez"]
    ])
    ->add('submit',SubmitType::class, [
        'attr'=> ["class" => 'btn btn-primary']
    ])
            // ->add('date_ajout')
            // ->add('etat')
            // ->add('produit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paniers::class,
        ]);
    }
}
