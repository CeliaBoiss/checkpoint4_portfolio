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
use App\Entity\Customer;
use App\Repository\WorkingPartnerRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\CustomerRepository;
use App\Repository\SocialNetworkRepository;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */

    public function index(
        ProjectRepository $projectRepository,
        WorkingPartnerRepository $workingPartnerRepository,
        SkillRepository $skillRepository,
        CustomerRepository $customerRepository,
        SocialNetworkRepository $socialNetworkRepository
    ): Response {
        $projects = $projectRepository->findAll();
        $workingPartners = $workingPartnerRepository->findAll();
        $skills = $skillRepository->findAll();
        $customers = $customerRepository->findAll();
        $socialNetworks = $socialNetworkRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'projects' => $projects,
            'workingPartners' => $workingPartners,
            'skills' => $skills,
            'customers' => $customers,
            'socialNetworks' => $socialNetworks
        ]);
    }
}
