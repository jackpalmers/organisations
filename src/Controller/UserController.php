<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class UserController extends AbstractController
{

    /**
     * @Route("/user", name="user")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();

        return $this->render('user/home.html.twig', [
            'controller_name' => 'UserController',
            'tachesUsers' => $users
        ]);
    }

    /**
     * @Route("/user/new", name="user_create")
     * @Route("/user/{id}/edit", name="user_edit")
     */
    public function form(User $user = null, Request $request, ObjectManager $manager)
    {
        if (!$user)
            $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username')
            ->add('password')
            ->add('email')
            ->add('isActive')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('$user_show', [
                'id' => $user->getId()
            ]);
        }

        return $this->render('user/create.html.twig', [
            'formUser' => $form->createView(),
            'editMode' => $user->getId() !== null
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_show")
     */
    public function show(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }

}
