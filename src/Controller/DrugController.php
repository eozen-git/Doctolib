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
     * @var DrugRepository
     */
    private $getDrugRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(DrugRepository $drugRepository, EntityManagerInterface $em)
    {
        $this->getDrugRepository = $drugRepository;
        $this->em = $em;
    }

    /**
     * @Route("/drugs/index", name="drugs_index")
     * @param EntityManagerInterface $entityManager
     * @param DrugRepository $drugRepository
     * @return Response
     * @throws \Exception
     */
    public function index(
        EntityManagerInterface $entityManager,
        DrugRepository $drugRepository
    ): Response
    {
        $drugs = $drugRepository->findAll();
        $medicines = [];
        foreach ($drugs as $drug) {
            $medicines[] = $drug->getName();
        }
        $conversation = new Conversation();
        $medicines = implode(", ", $medicines);
        $conversation->setMessage("The available medicines are " . $medicines . '.');
        $conversation->setPostAt(new DateTime());
        $entityManager->persist($conversation);
        $entityManager->flush();

        return $this->redirectToRoute('botman_chat');
    }

    /**
     * @Route("/drugs/therapy", name="drugs_therapy")
     * @param string $medic
     * @return String
     */
    public function therapy(
        string $medic
    ): string
    {
        return (string) $this->getDrugRepository->findOneBy(['name' => $medic])->getDescription();
    }
}
