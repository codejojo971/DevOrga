<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'constraints' => [
                    new NotBlank(['message'=>'Email manquant']),
                    new Length([
                        'max'   => 50,
                        'maxMessage' => 'L\'adresse email ne peut contenir plus de {{ limit }} caractères.'
                    ]),
                    new Email(['message' => 'Cette adresse n\'est pas une adresse email valide.'])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type'=> PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Mot de passe manquant.']),
                    new Length([
                        'min' =>6,
                        'minMessage' => 'Le mot de passe doit contenir ',
                        'max' => 4096,
                    ]),
                ],
            ])    
        ;   
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => User::class,
        ]);
    }
}
