<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Drug;
use App\Entity\Message;
use App\Entity\Molecule;
use App\Form\MessageType;
use App\Repository\DiseaseRepository;
use App\Repository\DrugRepository;
use App\Repository\MoleculeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoleculeController extends AbstractController
{

    /**
     * @Route("/molecule/show/{id}", name="molecule_show")
     * @param Molecule $molecule
     * @return Response
     */
    public function show(Molecule $molecule): Response
    {
        $drugs = $molecule->getDrugs();
        return $this->render('molecule/show.html.twig', [
            'drugs' => $drugs,
            'molecule' => $molecule

        ]);
    }
}
