<?php

namespace App\Controller;

use App\Repository\TacheSportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\TacheSport;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class TacheSportController extends AbstractController
{
    /**
     * @Route("/tacheSport", name="tacheSport")
     */
    public function index(TacheSportRepository $repo)
    {
        $idUserLog = $this->getUser()->getId();

        $tachesSport = $repo->findActiviteSportiveByUser($idUserLog);

        return $this->render('tacheSport/home.html.twig', [
            'controller_name' => 'TacheSportController',
            'tachesSport' => $tachesSport
        ]);
    }

    /**
     * @Route("/tacheSport/new", name="tacheSport_create")
     * @Route("/tacheSport/{id}/edit", name="tacheSport_edit")
     */
    public function form(TacheSport $tacheSport = null, Request $request, ObjectManager $manager)
    {
        if (!$tacheSport)
            $tacheSport= new TacheSport();

        $form = $this->createFormBuilder($tacheSport)
            ->add('NomSport')
            ->add('Duree')
            ->add('Nombre')
            ->add('DateSeance')
            ->getForm();

        $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $tacheSport->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une tâche avec l'id du user connecté

            $manager->persist($tacheSport);
            $manager->flush();

            return $this->redirectToRoute('tacheSport');
        }

        return $this->render('tacheSport/create.html.twig', [
            'formTacheSport' => $form->createView(),
            'editMode' => $tacheSport->getId() !== null
        ]);
    }

    /**
     * @Route("/tacheSport/{id}/delete", name="tacheSport_delete")
     */
    public function deleteTacheSport(TacheSportRepository $repo, TacheSport $tacheSport, ObjectManager $manager)
    {
        $tache = $repo->find($tacheSport->getId());

        $manager->remove($tache);
        $manager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('tacheSport');
    }
}
