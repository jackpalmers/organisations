<?php

namespace App\Controller;

use App\Repository\ActiviteSportiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\ActiviteSportive;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

// AbstractController => Controller
class ActiviteSportiveController extends Controller
{
    /**
     * @Route("/activiteSportive", name="activiteSportive")
     */
    public function showActiviteSportive(ActiviteSportiveRepository $repo, Request $request)
    {
        $idUserLog = $this->getUser()->getId();

        $activitesSportive = $repo->findActiviteSportiveByUser($idUserLog);

        $paginator = $this->get('knp_paginator');
        // la variable $pagination contient les rendez-vous à venir
        $pagination = $paginator->paginate(
            $activitesSportive,
            $request->query->getInt('page', '1'), 10
        );

        return $this->render('activiteSportive/home.html.twig', [
            'controller_name' => 'ActiviteSportiveController',
            'activitesSportive' => $pagination
        ]);
    }

    /**
     * @Route("/activiteSportive/new", name="activiteSportive_create")
     * @Route("/activiteSportive/{id}/edit", name="activiteSportive_edit")
     */
    public function form(ActiviteSportive $activiteSportive = null, Request $request, ObjectManager $manager)
    {
        if (!$activiteSportive)
            $activiteSportive = new ActiviteSportive();

        $form = $this->createFormBuilder($activiteSportive)
            ->add('NomSport')
            ->add('Duree')
            ->add('Nombre')
            ->add('DateSeance')
            ->getForm();

        $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $activiteSportive->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une activité sportive avec l'id du user connecté

            $manager->persist($activiteSportive);
            $manager->flush();

            return $this->redirectToRoute('activiteSportive');
        }

        return $this->render('activiteSportive/create.html.twig', [
            'formActiviteSportive' => $form->createView(),
            'editMode' => $activiteSportive->getId() !== null
        ]);
    }

    /**
     * @Route("/activiteSportive/{id}/delete", name="activiteSportive_delete")
     */
    public function deleteActiviteSportive(ActiviteSportiveRepository $repo, ActiviteSportive $activiteSportive, ObjectManager $manager)
    {
        $activiteSportiveASupprimer = $repo->find($activiteSportive->getId());

        $manager->remove($activiteSportiveASupprimer);
        $manager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('activiteSportive');
    }
}
