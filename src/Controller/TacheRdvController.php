<?php

namespace App\Controller;

use App\Repository\TacheRdvRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query\AST\WhereClause;
use function PHPSTORM_META\type;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TacheRdv;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TacheRdvController extends AbstractController
{
    /**
    * @Route("/tacheRdv", name="tacheRdv")
    */
    public function index(TacheRdvRepository $repo) // ne contient que les rdv qui ne sont pas encore passés en terme de date
    {
        $dateNow = date('d/m/Y');
        $tachesRdv = $repo->findby(array(), array('date' => 'asc'));

        return $this->render('tacheRdv/home.html.twig', [
            'controller_name' => 'TacheRdvController',
            'tachesRdv' => $tachesRdv,
            'dateNow' => $dateNow
        ]);
    }

    /**
     * @Route("/tacheRdvPasse", name="tacheRdvPasse")
     */
    public function rdvDejaPasse(TacheRdvRepository $repo)
    {
        $dateNow = date('d/m/Y');
        $tachesRdv = $repo->findBy(array(), array('date' => 'asc'));

        return $this->render('tacheRdv/rdvPasse.html.twig', [
//            'controller_name' => 'TacheRdvController',
            'tachesRdv' => $tachesRdv,
            'dateNow' => $dateNow
        ]);
    }

    /**
     * @Route("/tacheRdv/new", name="tacheRdv_create")
     * @Route("/tacheRdv/{id}/edit", name="tacheRdv_edit")
     */
    public function form(TacheRdv $tacheRdv = null, Request $request, ObjectManager $manager)
    {
        if (!$tacheRdv)
            $tacheRdv = new TacheRdv();

        $form = $this->createFormBuilder($tacheRdv)
                     ->add('type')
//                     ->add('type', TextareaType::class) -> Changer le champs à la main au lieu de laisser symfony comparer avec les propriétés de la classe
                     ->add('date', DateType::class)
                     ->add('heure')
                     ->add('lieu')
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$tacheRdv->getId())
                $tacheRdv->setCreatedAt(new \DateTime());

            $manager->persist($tacheRdv);
            $manager->flush();

            return $this->redirectToRoute('tacheRdv_show', [
                'id' => $tacheRdv->getId()
            ]);
        }

        return $this->render('tacheRdv/create.html.twig', [
            'formTacheRdv' => $form->createView(),
            'editMode' => $tacheRdv->getId() !== null
        ]);
    }

    /**
     * @Route("/tacheRdv/{id}", name="tacheRdv_show")
     */
    public function show(TacheRdv $tacheRdv)
    {
        return $this->render('tacheRdv/show.html.twig', [
            'tacheRdv' => $tacheRdv
        ]);
    }

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

        return $this->redirectToRoute('tacheRdv');
    }
}