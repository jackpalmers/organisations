<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UserManageType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if($this->getUser() == null)
        {
            $user = new User();
            $form = $this->createForm(RegistrationType::class, $user);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid())
            {
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $user->setIsActive(1);

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('security_login');
            }

            return $this->render('security/registration.html.twig', [
                'form' => $form->createView()
            ]);
        }
        // Si l'utilisateur est authentifié, on l'empêche d'accéder à la page d'inscription
        else
            return $this->redirectToRoute('accueil');

    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        if($this->getUser() == null)
        {
            return $this->render('security/login.html.twig', [
                'error' => $error
            ]);
        }
        // Si l'utilisateurt est authentifié, on l'empêche de retourner au formulaire de connexion
        else
            return $this->redirectToRoute('accueil');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/parametrage", name="user_manage")
     */
    public function userManage(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, UserRepository $repo)
    {
        $userLog = $this->getUser();
        $user = $repo->getUserById($userLog->getId());

        $form = $this->createForm(UserManageType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('security/userManage.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
