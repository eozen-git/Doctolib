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
     * @return Response
     */
    public function chat(
        Request $request,
        EntityManagerInterface $entityManager,
        ConversationRepository $conversationRepository
    ): Response
    {
        $conversation = new Conversation();
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
//            $conv = $conversationRepository->findAll();
//            $convs = [];
//            foreach ($conv as $msg) {
//                $convs[] = $msg->getMessage();
//            }
            $data = $form->getData();

            if (($data->getMessage() === strtolower('Bonjour'))) {
                $conversation->setMessage($data->getMessage());
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $conversation2->setMessage('Bonjour Docteur, que voulez vous ?');
                $conversation2->setPostAt(new DateTime);
                $entityManager->persist($conversation2);
                $entityManager->flush();
            }
            if (($data->getMessage() === strtolower('Maladies'))) {
                $conversation->setMessage($data->getMessage());
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $conversation2->setMessage('Cancer du sein ou cancer de la prostate?');
                $conversation2->setPostAt(new DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            }
            if (($data->getMessage() === strtolower('Cancer du sein'))) {
                $conversation->setMessage($data->getMessage());
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $conversation2->setMessage('');
                $conversation2->setPostAt(new DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            }
            if (($data->getMessage() === strtolower('Cancer de la prostate'))) {
                $conversation->setMessage($data->getMessage());
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $conversation2->setMessage('');
                $conversation2->setPostAt(new DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            }
        }
        return $this->render('home/chat.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}

