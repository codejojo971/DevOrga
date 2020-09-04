<?php

namespace App\Controller;

use App\Form\EventCreateType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function eventCreate( EventRepository $event, Request $request, EntityManagerInterface $entityManager)
    {
        $form= $this->createForm(EventCreateType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $events = $form->getData();

            $entityManager->persist($events);
            $entityManager->flush();
        }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'événements créés',
            'eventCreate' => $form->createView(),
        ]);
    }

    /**
     * 
     *
     * @Route("admin/event", name="event")
     */
    public function eventInvolted()
    {
       return $this->render('admin/event.html.twig',[
        'title' => 'Tes participations',
       ]);
       
    }

}
