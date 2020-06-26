<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Drug;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\DiseaseRepository;
use App\Repository\DrugRepository;
use App\Repository\MoleculeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
    /**
     * @var DiseaseRepository
     */
    private $getDiseaseRepository;

    public function __construct(DrugRepository $drugRepository, DiseaseRepository $diseaseRepository, EntityManagerInterface $em)
    {
        $this->getDrugRepository = $drugRepository;
        $this->getDiseaseRepository = $diseaseRepository;
        $this->em = $em;
    }

    /**
     * @Route("/drugs/index", name="drugs_index")
     * @param EntityManagerInterface $entityManager
     * @param DrugRepository $drugRepository
     * @return Response
     * @throws Exception
     */
    public function index(
        EntityManagerInterface $entityManager,
        DrugRepository $drugRepository
    ): Response
    {
        $drugs = $drugRepository->findAll();
        $medicines = [];
        foreach ($drugs as $drug) {
            $medicines[] = $drug->getName() . ":";
        }
        $conversation = new Conversation();
        $medicines = implode("", $medicines);
        $conversation->setMessage("The available medicines are:" . $medicines);
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
        return (string)$this->getDrugRepository->findOneBy(['name' => $medic])->getDescription();
    }

    /**
     * @Route("/drugs/meds/{disease}", name="drugs_meds")
     * @param string $disease
     * @return Response
     * @throws Exception
     */
    public function meds(
        string $disease
    ): Response
    {
        $drugs = $this->getDiseaseRepository->findOneBy(['name' => $disease])->getDrugs();
        $medicines = [];
        foreach ($drugs as $drug) {
            $medicines[] = $drug->getName() . ":";
        }
        $conversation = new Conversation();
        $medicines = implode("", $medicines);
        $conversation->setMessage("The medicines for " . $disease . " are:" . $medicines);
        $conversation->setPostAt(new DateTime());
        $this->em->persist($conversation);
        $this->em->flush();

        return $this->redirectToRoute('botman_chat');
    }

    /**
     * @Route("/drugs/generics/{medic}", name="drugs_generics")
     * @param string $medic
     * @return array
     */
    public function generics(
        string $medic
    ): Response
    {
        $drug = $this->getDrugRepository->findOneBy(['name' => $medic]);
        $molecule = $drug->getMolecule();
        $drugs = $molecule->getDrugs();

        $medicines = [];
        foreach ($drugs as $drug) {
            $medicines[] = $drug->getName() . ":";
        }
        $conversation = new Conversation();
        $medicines = implode("", $medicines);
        $conversation->setMessage("The generics for " . $medic . " are:" . $medicines);
        $conversation->setPostAt(new DateTime());
        $this->em->persist($conversation);
        $this->em->flush();

        return $this->redirectToRoute('botman_chat');
    }

/**
 * @Route("/drugs/show/{id}", name="drugs_show")
 * @param Drug $drug
 * @return Response
 */
public
function show(Drug $drug): Response
{
    $molecule = $drug->getMolecule();
    return $this->render('drugs/show.html.twig', [
        'drug' => $drug,
        'molecule' => $molecule

    ]);
}
}
