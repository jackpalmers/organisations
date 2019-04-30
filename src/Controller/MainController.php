<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TacheRdvRepository;
use App\Repository\TacheDevRepository;
use App\Repository\TacheSportRepository;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function index(TacheRdvRepository $repoTacheRdv, TacheDevRepository $repoTacheDev, TacheSportRepository $repoTacheSport)
    {
        // on récupère l'id de l'utilisateur connecté
        $idUserLog = $this->getUser()->getId();

        $tachesRdv = $repoTacheRdv->findBy(array('userId' => $idUserLog), array('createdAt' => 'desc'), 3);

        $tacheDev = $repoTacheDev->findBy(array(), array('id' => 'asc'), 3);

        $tacheSport = $repoTacheSport->findBy(array(), array('id' => 'asc'), 3);

        return $this->render('accueil.html.twig', [
            'controller_name' => 'TacheRdvController',
            'tachesRdv' => $tachesRdv,
            'tachesDev' => $tacheDev,
            'tachesSport' => $tacheSport
        ]);
    }
}
