<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

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
    public function form(User $user = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        if (!$user)
            $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur', 'attr' => ['placeholder' => 'Nom d\'utilisateur']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe', 'attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['label' => 'Répéter le mot de passe', 'attr' => ['placeholder' => 'Répéter le mot de passe']]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email', 'attr' => ['placeholder' => 'Adresse email']
            ])
            ->add('isActive')
//            ->add('termsAccepted', CheckboxType::class, array(
//                'mapped' => false,
//                'constraints' => new IsTrue(),
//                ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user_show', [
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
