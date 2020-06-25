<?php


namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\ConversationRepository;
use App\Repository\DiseaseRepository;
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


class BotmanController extends AbstractController
{
    /**
     * @Route("/botman", name="botman")
     * @return Response
     */
    public function index(): Response
    {

        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/botman/chat", name="botman_chat")
     * @param Request                $request
     * @param EntityManagerInterface $entityManager
     * @param ConversationRepository $conversationRepository
     * @param DiseaseRepository $diseaseRepository
     * @return Response
     */
    public function chat(
        Request $request,
        EntityManagerInterface $entityManager,

        ConversationRepository $conversationRepository,
        DiseaseRepository $diseaseRepository
    ): Response {
        $conversation = new Conversation();
        $message = new Message();
        $diseases = $diseaseRepository->findAll();
        $form = $this->createForm(MessageType::class,$message);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
        }else {
            $conversation = new Conversation();
            $conversation->setMessage($data->getMessage());
            $conversation->setPostAt(new DateTime());
            $entityManager->persist($conversation);
            $entityManager->flush();
            $conversation2 = new Conversation();
            $conversation2->setMessage('Sorry ! I didn\'t understand your request!');
            $conversation2->setPostAt(new DateTime());
            $entityManager->persist($conversation2);
            $entityManager->flush();
        }
        return $this->render('home/chat.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}

