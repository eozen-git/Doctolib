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
use App\Controller\DrugController;

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
     * @param EntityManagerInterface $entityManager
     * @param MoleculeRepository $moleculeRepository
     * @param DrugRepository $drugRepository
     * @param DiseaseRepository $diseaseRepository
     * @param \App\Controller\DrugController $drugController
     * @return Response
     * @throws \Exception
     */
    public function chat(
        Request $request,
        EntityManagerInterface $entityManager,
        MoleculeRepository $moleculeRepository,
        DrugRepository $drugRepository,
        DiseaseRepository $diseaseRepository,
        DrugController $drugController
    ): Response
    {
        $conversation = new Conversation();
        $message = new Message();
        $diseases = $diseaseRepository->findAll();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            if (strtolower($data->getMessage()) === 'home') {
                $conversation->setMessage($data->getMessage());
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
            } elseif (strtolower($data->getMessage()) === 'diseases') {
                $illness = [];
                foreach ($diseases as $disease) {
                    $illness[] = $disease->getName();
                }
                $conversation = new Conversation();
                $conversation->setMessage($data->getMessage());
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $illness = implode(", ", $illness);
                $conversation2->setMessage("The diseases you can choose from are " . $illness . '.');
                $conversation2->setPostAt(new DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            } elseif (strtolower($data->getMessage()) === 'breast cancer') {
                $conversation = new Conversation();
                $conversation->setMessage($data->getMessage());
                $disease = $diseaseRepository->findOneBy(['name' => 'Breast Cancer']);
                $diseases = $disease->getDrugs();
                $illness = [];
                foreach ($diseases as $disease) {
                    $illness[] = $disease->getName() . ":";
                }
                $illness = implode("", $illness);
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $conversation2->setMessage("The diseases you can choose from are:" . $illness);
                $conversation2->setPostAt(new DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            } elseif (strtolower($data->getMessage()) === 'prostate cancer') {
                $conversation = new Conversation();
                $conversation->setMessage($data->getMessage());
                $disease = $diseaseRepository->findOneBy(['name' => 'Prostate Cancer']);
                $diseases = $disease->getDrugs();
                $illness = [];
                foreach ($diseases as $disease) {
                    $illness[] = $disease->getName() . ":";
                }
                $illness = implode("", $illness);
                $conversation->setPostAt(new DateTime());
                $entityManager->persist($conversation);
                $entityManager->flush();
                $conversation2 = new Conversation();
                $conversation2->setMessage("The diseases you can choose from are:" . $illness);
                $conversation2->setPostAt(new DateTime());
                $entityManager->persist($conversation2);
                $entityManager->flush();
            } else {
                $medoc = explode(" ", strtolower(trim($data->getMessage())));
                $medic = [];
                foreach ($medoc as $word) {
                    $medic[] = ucfirst($word);
                }
                $medic = implode(" ", $medic);
                $molecules = $moleculeRepository->findAll();
                $drugs = $drugRepository->findAll();
                $drugsName = [];
                $moleculesName = [];
                foreach ($drugs as $drug) {
                    $drugsName[] = $drug->getName();
                }
                foreach ($molecules as $molecule) {
                    $moleculesName[] = $molecule->getName();
                }
                if (in_array($medic, $moleculesName)) {
                    $conversation = new Conversation();
                    $conversation->setMessage($data->getMessage());
                    $molecule = $moleculeRepository->findOneBy(['name' => $medic]);
                    $id = $molecule->getId();
                    $medocs = $drugRepository->findBy(['molecule' => $id]);
                    $medics = [];
                    foreach ($medocs as $medoc) {
                        $medics[] = $medoc->getName();
                    }
                    $medics = implode(", ", $medics);
                    $conversation->setPostAt(new DateTime());
                    $entityManager->persist($conversation);
                    $entityManager->flush();
                    $conversation2 = new Conversation();
                    $conversation2->setMessage('The medicines with active molecule ' . $medic . ' are : ' . $medics . '.');
                    $conversation2->setPostAt(new DateTime());
                    $entityManager->persist($conversation2);
                    $entityManager->flush();
                } elseif (in_array($medic, $drugsName)) {
                    $conversation = new Conversation();
                    $conversation->setMessage($data->getMessage());
                    $conversation->setPostAt(new DateTime());
                    $drug = $drugRepository->findOneBy(['name' => $medic]);
                    $molecules = $drug->getMolecule();
                    $mols = $molecules->getName();
                    $price = $drug->getPrice();
                    $refundRate = $drug->getRefundRate();
                    $entityManager->persist($conversation);
                    $entityManager->flush();
                    $conversation2 = new Conversation();
                    $conversation2->setMessage('The active molecule of ' . $medic . ' is:' . $mols .
                        '-Its price is:' . $price .
                        '€-Its refund rate is of:' . $refundRate .
                        '%-' . $drugController->therapy($medic));
                    $conversation2->setPostAt(new DateTime());
                    $entityManager->persist($conversation2);
                    $entityManager->flush();
                } else {
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
            }
        }
        return $this->render('home/chat.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
