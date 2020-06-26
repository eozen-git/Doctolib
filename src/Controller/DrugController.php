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

class DrugController extends AbstractController
{
    /**
     * @Route("/drugs/index", name="drugs_index")
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
            MoleculeRepository $moleculeRepository,
            DrugRepository $drugRepository,
            DiseaseRepository $diseaseRepository
        ): Response
        {
            $drugs = $drugRepository->findAll();
            $medicines = [];
            foreach ($drugs as $drug) {
                $medicines[] = ':' . $drug->getName();
            }
            $conversation = new Conversation();
            $medicines = implode("", $medicines);
            $conversation->setMessage("The available medicines are" . $medicines);
            $conversation->setPostAt(new DateTime());
            $entityManager->persist($conversation);
            $entityManager->flush();

            return $this->redirectToRoute('botman_chat');
        }
}
