<?php

namespace App\Controller;

use App\Entity\TacheDev;
use App\Repository\TacheDevRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class TacheDevController extends AbstractController
{
    /**
     * @Route("/tacheDev", name="tacheDev")
     */
    public function index(TacheDevRepository $repo)
    {
        $tachesDev = $repo->findAll();

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

        $form = $this->createFormBuilder($tacheDev)
            ->add('projectName')
            ->add('description', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($tacheDev);
            $manager->flush();

            return $this->redirectToRoute('tacheDev_show', [
                'id' => $tacheDev->getId()
            ]);
        }

        return $this->render('tacheDev/create.html.twig', [
            'formTacheDev' => $form->createView(),
            'editMode' => $tacheDev->getId() !== null
        ]);
    }

    /**
     * @Route("/tacheDev/{id}", name="tacheDev_show")
     */
    public function show(TacheDev $tacheDev)
    {
        return $this->render('tacheDev/show.html.twig', [
            'tacheDev' => $tacheDev
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
