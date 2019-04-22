<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TacheRdvRepository;
use App\Repository\TacheDevRepository;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function index(TacheRdvRepository $repoTacheRdv, TacheDevRepository $repoTacheDev)
    {
        $tachesRdv = $repoTacheRdv->findBy(array(), array('createdAt' => 'desc'), 3);

        $tacheDev = $repoTacheDev->findBy(array(), array('id' => 'asc'), 3);

        return $this->render('accueil.html.twig', [
            'controller_name' => 'TacheRdvController',
            'tachesRdv' => $tachesRdv,
            'tachesDev' => $tacheDev
        ]);
    }
}
