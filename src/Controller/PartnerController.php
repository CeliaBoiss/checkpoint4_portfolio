<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WorkingPartnerRepository;
use App\Entity\WorkingPartner;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\WorkingPartnerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PartnerController extends AbstractController
{
    /**
     * @Route("/admin/partner/add", name="admin_partner_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addWorkingPartner(Request $request, EntityManagerInterface $entityManager): Response
    {
        $partner = new WorkingPartner();
        $form = $this->createForm(WorkingPartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/workingPartner/addPartner.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/partner/{id}", name="admin_partner_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function partnerShow(WorkingPartner $workingPartner): Response
    {
        return $this->render('admin/workingPartner/showPartner.html.twig', ['workingPartner' => $workingPartner]);
    }

    /**
     * @Route("/partner/{id}/delete", name="admin_partner_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteWorkingPartner(
        WorkingPartner $workingPartner,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$workingPartner->getId(), $request->request->get('_token'))) {            
            $entityManager->remove($workingPartner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/partner/{id}/edit", name="admin_partner_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editWorkingPartner(
        Request $request,
        WorkingPartner $workingPartner,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(WorkingPartnerType::class, $workingPartner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect('/admin/partner/' . $workingPartner->getId());
        }

        return $this->render('admin/workingPartner/editPartner.html.twig', [
            'workingPartner' => $workingPartner,
            'form' => $form->createView(),
        ]);
    }
}
