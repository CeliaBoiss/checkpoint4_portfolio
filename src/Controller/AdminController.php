<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\WorkingPartner;
use App\Entity\Project;
use App\Repository\WorkingPartnerRepository;
use App\Repository\ProjectRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */

    public function index(
        ProjectRepository $projectRepository,
        WorkingPartnerRepository $workingPartnerRepository
    ): Response {
        $projects = $projectRepository->findAll();
        $workingPartners = $workingPartnerRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'projects' => $projects,
            'workingPartners' => $workingPartners
        ]);
    }
}
