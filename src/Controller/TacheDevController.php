<?php

namespace App\Controller;

use App\Entity\TacheDev;
use App\Form\TacheDevType;
use App\Repository\TacheDevRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TacheDevController extends AbstractController
{
    /**
     * @Route("/tacheDev", name="tacheDev")
     */
    public function index(TacheDevRepository $repo)
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $tachesDev = $repo->findTacheDevByUser($idUserLog);


        return $this->render('tacheDev/home.html.twig', [
            'controller_name' => 'TacheDevController',
            'tachesDev' => $tachesDev
        ]);
    }

    /**
     * @Route("/tacheDev/new", name="tacheDev_create")
     * @Route("/tacheDev/{id}/edit", name="tacheDev_edit")
     */
    public function form(TacheDev $tacheDev = null, Request $request, ObjectManager $manager)
    {
        if (!$tacheDev)
            $tacheDev = new TacheDev();

        $form = $this->createForm(TacheDevType::class, $tacheDev);

        if($tacheDev->getId() != null) // Regarder pourquoi le test de l'id à null fonctionne alors que le test (!$tachesDev) ne fonctionne pas pour afficher le select en editMode
        {
           $form->add('etat',  ChoiceType::class, [
               'choices' => [
                   'En cours' => 0,
                   'Terminée' => 1,
                   'Fermée' => 2
               ]
           ]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
//            if(!$tacheDev)
            if($tacheDev->getId() == null)
                $tacheDev->setEtat(0); // on met l'état de la fiche de bug à 0 (en cours) lors de sa création

            $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user
            $tacheDev->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une tâche avec l'id du user connecté

            $manager->persist($tacheDev);
            $manager->flush();

            return $this->redirectToRoute('tacheDev');
        }

        return $this->render('tacheDev/create.html.twig', [
            'formTacheDev' => $form->createView(),
            'editMode' => $tacheDev->getId() !== null,
        ]);
    }

    /**
     * @Route("/tacheDev/{id}/delete", name="tacheDev_delete")
     */
    public function deleteTacheDev(TacheDevRepository $repo, TacheDev $tacheDev, ObjectManager $manager)
    {
        $tache = $repo->find($tacheDev->getId());

        $manager->remove($tache);
        $manager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('tacheDev');
    }
}
