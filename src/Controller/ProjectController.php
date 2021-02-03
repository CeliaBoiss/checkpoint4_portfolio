<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjectRepository;
use App\Entity\Project;

class ProjectController extends AbstractController
{
    /**
     * @Route("/projets", name="project_index")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findBy([], ['startDate' => 'DESC']);

        return $this->render('projects/index.html.twig', ['projects' => $projects]);
    }

    /**
     * @Route("/projects/{id}", name="project_show", methods={"GET"})
     */
    public function show(Project $project): Response
    {
        return $this->render('projects/seeOneProject.html.twig', [
            'project' => $project,
        ]);
    }
}
