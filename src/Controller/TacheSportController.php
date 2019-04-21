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
        $tachesSport = $repo->findAll();

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
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($tacheSport);
            $manager->flush();

            return $this->redirectToRoute('tacheSport_show', [
                'id' => $tacheSport->getId()
            ]);
        }

        return $this->render('tacheSport/create.html.twig', [
            'formTacheSport' => $form->createView(),
            'editMode' => $tacheSport->getId() !== null
        ]);
    }

    /**
     * @Route("/tacheSport/{id}", name="tacheSport_show")
     */
    public function show(TacheSport $tacheSport)
    {
        return $this->render('tacheSport/show.html.twig', [
            'tacheSport' => $tacheSport
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
