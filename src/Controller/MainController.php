<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TacheRdvRepository;
use App\Repository\FicheBugRepository;
use App\Repository\TacheSportRepository;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function index(TacheRdvRepository $repoTacheRdv, FicheBugRepository $repoFicheBug, TacheSportRepository $repoTacheSport)
    {
        // on récupère l'id de l'utilisateur connecté
        if ($this->getUser())
            $idUserLog = $this->getUser()->getId();
        else
            return $this->redirectToRoute('security_login');

        $tachesRdv = $repoTacheRdv->findBy(array('userId' => $idUserLog), array('createdAt' => 'desc'), 3);

        $fichesBug = $repoFicheBug->findBy(array('userId' => $idUserLog), array('id' => 'asc'), 3);

        $tachesSport = $repoTacheSport->findBy(array('userId' => $idUserLog), array('id' => 'asc'), 3);

        if ($idUserLog)
        {
            return $this->render('accueil.html.twig', [
                'controller_name' => 'TacheRdvController',
                'tachesRdv' => $tachesRdv,
                'fichesBug' => $fichesBug,
                'tachesSport' => $tachesSport
            ]);
        }
    }
}
