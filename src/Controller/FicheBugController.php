<?php

namespace App\Controller;

use App\Entity\FicheBug;
use App\Form\FicheBugType;
use App\Repository\FicheBugRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

// AbstractController => Controller
class FicheBugController extends Controller
{
    /**
     * @Route("/ficheBug", name="ficheBug")
     */
    public function showFicheBug(FicheBugRepository $repo, Request $request)
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $fichesBug = $repo->findFicheBugByUser($idUserLog);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $fichesBug,
            $request->query->getInt('page', '1'), 10
        );

        return $this->render('ficheBug/home.html.twig', [
            'controller_name' => 'FicheBugController',
            'fichesBug' => $fichesBug,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/ficheBug/new", name="ficheBug_create")
     * @Route("/ficheBug/{id}/edit", name="ficheBug_edit")
     * @param FicheBugController|null $ficheBug
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function form(FicheBug $ficheBug = null, Request $request, ObjectManager $manager)
    {
        if (!$ficheBug)
            $ficheBug = new FicheBug();

        if($ficheBug->getId() != null) // Regarder pourquoi le test de l'id à null fonctionne alors que le test (!$fichesBug) ne fonctionne pas pour afficher le select en editMode
            $editForm = true;
        else
            $editForm = false;

        $form = $this->createForm(FicheBugType::class, $ficheBug, ['taskAlreadyCreated' => $editForm]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if($ficheBug->getId() == null)
                $ficheBug->setEtat(0); // on met l'état de la fiche de bug à 0 (en cours) lors de sa création

            $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user
            $ficheBug->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une tâche avec l'id du user connecté

            $manager->persist($ficheBug);
            $manager->flush();

            return $this->redirectToRoute('ficheBug');
        }

        return $this->render('ficheBug/create.html.twig', [
            'formFicheBug' => $form->createView(),
            'editMode' => $ficheBug->getId() !== null,
        ]);
    }

    /**
     * @Route("/ficheBug/{id}/delete", name="ficheBug_delete")
     */
    public function deleteFicheBug(FicheBugRepository $repo, FicheBug $ficheBug, ObjectManager $manager)
    {
        $ficheADelete = $repo->find($ficheBug->getId());

        $manager->remove($ficheADelete);
        $manager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('ficheBug');
    }
}
