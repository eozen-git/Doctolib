<?php


namespace App\Controller;

use App\Entity\Conversation;
use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/conversation", name="api_conversation_")
 */
class ApiConversationController extends AbstractController
{

    /**
     * @Route("/", name="index", methods="GET")
     * @param ConversationRepository $conversationRepository
     * @return Response
     */
    public function index(ConversationRepository $conversationRepository): Response
    {
        return $this->json($conversationRepository->findAll());
    }

}
