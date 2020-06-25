<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\ConversationRepository;
use App\Repository\DiseaseRepository;
use App\Repository\DrugRepository;
use App\Repository\MoleculeRepository;
use App\Service\OnboardingConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
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
        MoleculeRepository $moleculeRepository,
        DrugRepository $drugRepository,
        DiseaseRepository $diseaseRepository
    ): Response
    {
        $conversation = new Conversation();
        $message = new Message();
        $diseases = $diseaseRepository->findAll();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        $data = $form->getData();
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