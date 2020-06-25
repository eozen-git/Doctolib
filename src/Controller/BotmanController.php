<?php


namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\ConversationRepository;
use App\Service\OnboardingConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
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
     * @param Request $request
     * @param ConversationRepository $conversationRepository
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function chat(Request $request, ConversationRepository $conversationRepository, EntityManagerInterface $entityManager): Response
    {
        $conversation = new Conversation();
        $conversations = $conversationRepository->findAll();
        $message = new Message();
        $form = $this->createForm(MessageType::class,$message);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            $conversation->setMessage($data->getMessage());
            $conversation->setPostAt(new \DateTime());
            $entityManager->persist($conversation);
            $entityManager->flush();
            if ($data->getMessage() === 'hello') {
                $conversation2 = new Conversation();
                $conversation2->setMessage('Salut mon chou');
                $conversation2->setPostAt(new \DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            }
        }
        return $this->render('home/chat.html.twig', [
            'form' => $form->createView(),
            'conversation' => $conversations
        ]);
    }
}

