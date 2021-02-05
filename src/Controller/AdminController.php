<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\WorkingPartner;
use App\Entity\Project;
use App\Entity\Skill;
use App\Repository\WorkingPartnerRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */

    public function index(
        ProjectRepository $projectRepository,
        WorkingPartnerRepository $workingPartnerRepository,
        SkillRepository $skillRepository
    ): Response {
        $projects = $projectRepository->findAll();
        $workingPartners = $workingPartnerRepository->findAll();
        $skills = $skillRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'projects' => $projects,
            'workingPartners' => $workingPartners,
            'skills' => $skills
        ]);
    }
}
