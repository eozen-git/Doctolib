<?php


namespace App\Controller;

use App\Entity\Disease;
use App\Repository\DiseaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/doctolib", name="api_doctolib_")
 */
class ApiDoctolibController extends AbstractController
{

    /**
     * @Route("/", name="index", methods="GET")
     * @param DiseaseRepository $diseaseRepository
     * @return Response
     */
    public function index(DiseaseRepository $diseaseRepository): Response
    {
        return $this->json($diseaseRepository->findAll());
    }

    /**
     * @Route("/{id}", name="show", methods="GET")
     * @param Disease $disease
     * @return Response
     */
    public function show(Disease $disease, SerializerInterface $serializer): Response
    {
        $json = $serializer->serialize(
            $disease,
            'json',[
            'circular_reference_handler' => function ($disease) {
        return $disease->getId();
    }
]);

        return $this->json($json,200);
    }

}
