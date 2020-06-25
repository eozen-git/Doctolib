<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
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


class DiseaseController extends AbstractController
{
    /**
     * @Route("/disease/index", name="disease_index")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param MoleculeRepository $moleculeRepository
     * @param DrugRepository $drugRepository
     * @param DiseaseRepository $diseaseRepository
     * @return Response
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        DiseaseRepository $diseaseRepository
    ): Response
    {
        $diseases = $diseaseRepository->findAll();
        $illness = [];
        foreach ($diseases as $disease) {
            $illness[] = $disease->getName();
        }
        $conversation = new Conversation();
        $illness = implode(", ", $illness);
        $conversation->setMessage("The diseases you can choose from are " . $illness . '.');
        $conversation->setPostAt(new DateTime());
        $entityManager->persist($conversation);
        $entityManager->flush();

        return $this->redirectToRoute('botman_chat');
    }
}