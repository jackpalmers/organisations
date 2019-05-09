<?php

namespace App\Controller;

use App\Repository\TacheRdvRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TacheRdv;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TacheRdvController extends AbstractController
{
    /**
    * @Route("/tacheRdvAVenir", name="tacheRdvAVenir", requirements={"page"="\d+"})
    */
    public function showRdvAVenir(TacheRdvRepository $repo) // ne contient que les rdv qui ne sont pas encore passés en terme de date pour chaque utilisateur
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $dateNow = new \DateTime('@'.strtotime('now'));

        $tachesRdv = $repo->findTacheRdvAVenirOrderByDateDesc($dateNow, $idUserLog);

        return $this->render('tacheRdv/rdvAVenir.html.twig', [
            'controller_name' => 'TacheRdvController',
            'tachesRdv' => $tachesRdv
        ]);
    }

    /**
     * @Route("/tacheRdvPasse", name="tacheRdvPasse")
     */
    public function showRdvDejaPasse(TacheRdvRepository $repo)
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $dateNow = new \DateTime('@'.strtotime('now'));

        // on récupère les taches ayant pour idUser celui de l'utilisateur connecté
        $tachesRdv = $repo->findTacheRdvPasseOrderByDateDesc($dateNow, $idUserLog);

        return $this->render('tacheRdv/rdvPasse.html.twig', [
            'tachesRdv' => $tachesRdv,
        ]);
    }

    /**
     * @Route("/tacheRdv/new", name="tacheRdv_create", requirements={"page"="\d+"})
     * @Route("/tacheRdv/{id<\d+>}/edit", name="tacheRdv_edit")
     */
    // "<\d+>" permet de gérer les cas de string passés dans l'url à la place de l'id
    public function form(TacheRdvRepository $repo, TacheRdv $tacheRdv = null, Request $request, ObjectManager $manager)
    {
        if (!$tacheRdv)
            $tacheRdv = new TacheRdv();

        // on test si l'id de la tâche passé en get existe en base
        $idTache = $request->get('id');
        $tacheExist = $repo->isTacheRdvExistById($idTache);

        // si la tâche n'existe pas et que nous ne sommes pas en création de tâche (getRequestUri renvoie l'url actuelle)
        if (empty($tacheExist) && $request->getRequestUri() != '/tacheRdv/new')
            throw new \Exception('Page introuvable (Tâche non existante en base)');

        // si ma tâche existe et que l'utilisateur de la tâche est l'utilisateur connecté
        if ($tacheExist && $tacheRdv->getUserId() != $this->getUser())
        {
            throw new \Exception('Page introuvable (Tâche lié à un autre utilisateur)');
        }

        $form = $this->createFormBuilder($tacheRdv)
                     ->add('type')
                     ->add('date', DateType::class)
                     ->add('heure')
                     ->add('lieu')
                     ->getForm();

        $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$tacheRdv->getId())
                $tacheRdv->setCreatedAt(new \DateTime());

            $tacheRdv->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une tâche avec l'id du user connecté

            $manager->persist($tacheRdv);
            $manager->flush();
            $manager->refresh();

            return $this->redirectToRoute('tacheRdvAVenir');
//            return $this->redirectToRoute('tacheRdv_show', [
//                'id' => $tacheRdv->getId()
//            ]);
        }

        return $this->render('tacheRdv/create.html.twig', [
            'formTacheRdv' => $form->createView(),
            'editMode' => $tacheRdv->getId() !== null
//            'userId' => $tacheRdv->getUserId()
        ]);
    }

    // Plus utilisé (à voir à l'avenir)
//    /**
//     * @Route("/tacheRdv/{id}", name="tacheRdv_show")
//     */
//    public function show(TacheRdv $tacheRdv)
//    {
//        return $this->render('tacheRdv/show.html.twig', [
//            'tacheRdv' => $tacheRdv
//        ]);
//    }

    /**
     * @Route("/tacheRdv/{id}/delete", name="tacheRdv_delete")
     */
    public function deleteTacheRdv(TacheRdvRepository $repo, TacheRdv $tacheRdv, ObjectManager $manager)
    {
        $tache = $repo->find($tacheRdv->getId());

        $manager->remove($tache);
        $manager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('tacheRdvAVenir');
    }
}