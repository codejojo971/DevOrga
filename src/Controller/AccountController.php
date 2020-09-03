<?php

namespace App\Controller;

use App\Form\UserPasswordFormType;
use App\Form\UserProfileFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $profileForm = $this->createForm(UserProfileFormType::class, $this->getUser());
        $profileForm->handleRequest($request);

        if($profileForm->isSubmitted() && $profileForm->isValid())
        {
            $entityManager->flush();
            $this->addFlash('success','Vos informations ont été mises à jour .');
        }

        $passwordForm= $this->createForm(UserPasswordFormType::class);
        $passwordForm->handleRequest($request);

        if($passwordForm->isSubmitted() && $passwordForm->isValid())
        {
            $password = $passwordForm->get('password')->getData();
            $hash= $encoder->encodePassword($this->getUser(), $password);

            $this->getUser()->setPassword($hash);
            
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe à été mis à jour.');
        }
        return $this->render('account/profile.html.twig', [
            'profile_form' => $profileForm->createView(),
            'password_form' =>$passwordForm->createView(),
        ]);
    }
}
