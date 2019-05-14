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
        // on récupère l'id de l'utilisateur connecté
        if ($this->getUser())
            $idUserLog = $this->getUser()->getId();
        else
            return $this->redirectToRoute('security_login');

        $rdvs = $repoRdv->findBy(array('userId' => $idUserLog), array('createdAt' => 'desc'), 3);

        $fichesBug = $repoFicheBug->findBy(array('userId' => $idUserLog), array('id' => 'asc'), 3);

        $tachesSport = $repoTacheSport->findBy(array('userId' => $idUserLog), array('id' => 'asc'), 3);

        if ($idUserLog)
        {
            return $this->render('accueil.html.twig', [
                'controller_name' => 'RdvController',
                'rdvs' => $rdvs,
                'fichesBug' => $fichesBug,
                'tachesSport' => $tachesSport
            ]);
        }
    }
}
