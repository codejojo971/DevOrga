<?php

namespace App\Form;

use App\Entity\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class EventCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[ 
              'constraints'=> [
                  new NotBlank(['message' => 'Veuillez remplir ce champ.']),
                  new Length([
                      'max' => 50,
                      'maxMessage' => 'Le nom ne peut contenir plus de 50 caractères.'
                  ])
              ] 
            ])
            ->add('descritption', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Votre commentaire ne doit pas dépasser les 255 caractères.'
                    ])
                ]
            ])
            ->add('lieu', TextType::class,[
                'constraints'=>[
                    new NotBlank(['message' => 'Veuillez remplir ce champs'])
                ]    
            ])
            ->add('date' ,DateType::class,[
                'constraints' => [
                    new NotBlank(['message' => 'Date de sortie manquante']),
                    new Range([
                        'max' => new \DateTime(),
                        'maxMessage' => 'La date ne peut être que future.'
                    ])
                ]  
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
