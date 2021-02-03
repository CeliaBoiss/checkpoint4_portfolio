<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\CustomerRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(
        ProjectRepository $projectRepository,
        SkillRepository $skillRepository,
        CustomerRepository $customerRepository
    ): Response {
        $projects = $projectRepository->findBy([], ['startDate' => 'DESC'], 3);

        $languages = $skillRepository->findBy(['type' => 'language']);
        $technos = $skillRepository->findBy(['type' => 'techno']);
        $softSkills = $skillRepository->findBy(['type' => 'soft']);

        $customers = $customerRepository->findAll();

        return $this->render('index.html.twig', [
            'projects' => $projects,
            'languages' => $languages,
            'technos' => $technos,
            'softSkills' => $softSkills,
            'customers' => $customers,
        ]);
    }
}
