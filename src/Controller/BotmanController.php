<?php


namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Service\OnboardingConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
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
     * @return Response
     */
    public function chat(Request $request): Response
    {
        $conversation = [];
        $message = new Message();
        $form = $this->createForm(MessageType::class,$message);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $conversation = $data['message'];
            if ($data['message'] === 'hello') {
                $conversation = 'Salut Doc';
            }
        }
        return $this->render('home/chat.html.twig', [
            'form' => $form->createView(),
            'conversation' => $conversation
        ]);
    }
}

