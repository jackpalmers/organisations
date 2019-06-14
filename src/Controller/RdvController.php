<?php

namespace App\Controller;

use App\Form\RdvType;
use App\Entity\Rdv;
use App\Repository\RdvRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RdvController extends AbstractController
{
    /**
    * @Route("/rdvAVenir", name="rdvAVenir")
    */
    public function showRdvAVenir(RdvRepository $repo, Request $request, PaginatorInterface $paginator) // ne contient que les rdv qui ne sont pas encore passés en terme de date pour chaque utilisateur
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $dateNow = new \DateTime(date("Y-m-d H:i:s"));

        $rdvsAVenir = $repo->findRdvAVenirOrderByDateDesc($dateNow, $idUserLog);

        // la variable $pagination contient les rendez-vous à venir
        $pagination = $paginator->paginate(
            $rdvsAVenir,
            $request->query->getInt('page', '1'), 10
        );

        return $this->render('rdv/rdvAVenir.html.twig', [
            'controller_name' => 'RdvController',
            'rdvsAVenir' => $pagination
        ]);
    }

    /**
     * @Route("/rdvPasse", name="rdvPasse")
     */
    public function showRdvDejaPasse(RdvRepository $repo, Request $request, PaginatorInterface $paginator)
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $dateNow = new \DateTime(date("Y-m-d H:i:s"));

        // on récupère les rdv ayant pour idUser celui de l'utilisateur connecté
        $rdvsPasse = $repo->findRdvPasseOrderByDateDesc($dateNow, $idUserLog);

        // la variable $pagination contient les rendez-vous passés
        $pagination = $paginator->paginate(
            $rdvsPasse,
            $request->query->getInt('page', '1'), 10
        );

        return $this->render('rdv/rdvPasse.html.twig', [
            'rdvsPasse' => $pagination
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

        if($rdv->getId() != null) // Regarder pourquoi le test de l'id à null fonctionne alors que le test (!$fichesBug) ne fonctionne pas pour afficher le select en editMode
            $editForm = true;
        else
            $editForm = false;

        $form = $this->createForm(RdvType::class, $rdv, ['edit' => $editForm]); // , ['taskAlreadyCreated' => $editForm]

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$rdv->getId())
                $rdv->setCreatedAt(new \DateTime());

            $idUserLog = $this->getUser(); // On ne récupère pas l'id, on veut récupérer l'object user
            $rdv->setUserId($idUserLog); // On passe l'object user pour pouvoir créer une tâche avec l'id du user connecté

            $manager->persist($rdv);
            $manager->flush();

            try
            {
                $dateNow = new \DateTime(date("Y-m-d H:i:s"));
                $dateRdv = $rdv->getDate();

                if ($dateRdv >= $dateNow)
                    return $this->redirectToRoute('rdvAVenir');
                else if ($dateRdv < $dateNow)
                    return $this->redirectToRoute('rdvPasse');
            }
            catch (\Exception $dateRdv)
            {
                throw new \Exception('Format de date invalide : '.$dateRdv);
            }
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