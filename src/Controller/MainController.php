<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RdvRepository;
use App\Repository\FicheBugRepository;
use App\Repository\TacheSportRepository;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function index(RdvRepository $repoRdv, FicheBugRepository $repoFicheBug, TacheSportRepository $repoTacheSport)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // on récupère l'utilisateur connecté
//        if ($this->getUser())
            $user = $this->getUser();
//        else
//            return $this->redirectToRoute('security_login');
        $rdvs = $repoRdv->findBy(array('userId' => $user->getId()), array('createdAt' => 'desc'), 3);

        $fichesBug = $repoFicheBug->findBy(array('userId' => $user->getId()), array('id' => 'asc'), 3);

        $tachesSport = $repoTacheSport->findBy(array('userId' => $user->getId()), array('id' => 'asc'), 3);

        if ($user->getId())
        {
            return $this->render('accueil.html.twig', [
                'controller_name' => 'MainController',
                'rdvs' => $rdvs,
                'fichesBug' => $fichesBug,
                'tachesSport' => $tachesSport
            ]);
        }
    }
}
