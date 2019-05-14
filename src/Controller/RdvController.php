<?php

namespace App\Controller;

use App\Form\RdvType;
use App\Repository\RdvRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Rdv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RdvController extends AbstractController
{
    /**
    * @Route("/rdvAVenir", name="rdvAVenir", requirements={"page"="\d+"})
    */
    public function showRdvAVenir(RdvRepository $repo) // ne contient que les rdv qui ne sont pas encore passés en terme de date pour chaque utilisateur
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $dateNow = new \DateTime('@'.strtotime('now'));

        $rdvs = $repo->findRdvAVenirOrderByDateDesc($dateNow, $idUserLog);

        return $this->render('rdv/rdvAVenir.html.twig', [
            'controller_name' => 'RdvController',
            'rdvs' => $rdvs
        ]);
    }

    /**
     * @Route("/rdvPasse", name="trdvPasse")
     */
    public function showRdvDejaPasse(RdvRepository $repo)
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $dateNow = new \DateTime('@'.strtotime('now'));

        // on récupère les rdv ayant pour idUser celui de l'utilisateur connecté
        $rdvs = $repo->findRdvPasseOrderByDateDesc($dateNow, $idUserLog);

        return $this->render('rdv/rdvPasse.html.twig', [
            'rdvs' => $rdvs,
        ]);
    }

    /**
     * @Route("/rdv/new", name="rdv_create")
     * @Route("/rdv/{id<\d+>}/edit", name="rdv_edit")
     * @throws \Exception
     */
    // "<\d+>" permet de gérer les cas de string passés dans l'url à la place de l'id
    public function form(RdvRepository $repo, Rdv $rdv = null, Request $request, ObjectManager $manager)
    {
        if (!$rdv)
            $rdv = new Rdv();

        // on test si l'id du rdv passé en get existe en base
        $idRdv = $request->get('id');
        $rdvExist = $repo->isRdvExistById($idRdv);

        // si le rdv n'existe pas et que nous ne sommes pas en création (getRequestUri renvoie l'url actuelle)
        if (empty($rdvExist) && $request->getRequestUri() != '/rdv/new')
            throw new \Exception('Page introuvable (Rendez-vous non existante en base)');

        // si mon rdv existe et que l'utilisateur du rdv est l'utilisateur connecté
        if ($rdvExist && $rdv->getUserId() != $this->getUser())
            throw new \Exception('Page introuvable (Rendez-vous lié à un autre utilisateur)');

        $form = $this->createForm(RdvType::class, $rdv); // , ['taskAlreadyCreated' => $editForm]

        $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$rdv->getId())
                $rdv->setCreatedAt(new \DateTime());

            $rdv->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une tâche avec l'id du user connecté

            $manager->persist($rdv);
            $manager->flush();

            return $this->redirectToRoute('rdvAVenir');
        }

        return $this->render('rdv/create.html.twig', [
            'formRdv' => $form->createView(),
            'editMode' => $rdv->getId() !== null
        ]);
    }

    /**
     * @Route("/rdv/{id}/delete", name="rdv_delete")
     */
    public function deleteRdv(RdvRepository $repo, Rdv $rdv, ObjectManager $manager)
    {
        $rdvASupprimer = $repo->find($rdv->getId());

        $manager->remove($rdvASupprimer);
        $manager->flush();

        $response = new Response();
        $response->send();

        return $this->redirectToRoute('rdvAVenir');
    }
}