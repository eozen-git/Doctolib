<?php


namespace App\Controller;

use App\Service\OnboardingConversation;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
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
    public function chat(): Response
    {
        $config = [
            'facebook' => [
                'token' => 'YOUR-FACEBOOK-PAGE-TOKEN-HERE',
                'app_secret' => 'YOUR-FACEBOOK-APP-SECRET-HERE',
                'verification'=>'MY_SECRET_VERIFICATION_TOKEN',
            ]
        ];

// Load the driver(s) you want to use
        DriverManager::loadDriver(FacebookDriver::class);

// Create an instance

        $adapter = new FilesystemAdapter();
        $botman = BotManFactory::create($config, new SymfonyCache($adapter));
        $botman->hears('Hello', function($bot) {
            $bot->startConversation(new OnboardingConversation);
            $bot->run();
        });
        return $this->render('home/chat.html.twig');
    }
}

