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
        if ($this->getUser())
            $idUserLog = $this->getUser()->getId();
        else
            return $this->redirectToRoute('security_login');

        $tachesRdv = $repoTacheRdv->findBy(array('userId' => $idUserLog), array('createdAt' => 'desc'), 3);

        $tacheDev = $repoTacheDev->findBy(array('userId' => $idUserLog), array('id' => 'asc'), 3);

        $tacheSport = $repoTacheSport->findBy(array('userId' => $idUserLog), array('id' => 'asc'), 3);

        if ($idUserLog)
        {
            return $this->render('accueil.html.twig', [
                'controller_name' => 'TacheRdvController',
                'tachesRdv' => $tachesRdv,
                'tachesDev' => $tacheDev,
                'tachesSport' => $tacheSport
            ]);
        }
    }
}
