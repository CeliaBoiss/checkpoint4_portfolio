<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

class SkillController extends AbstractController
{
    /**
     * @Route("/admin/skill/add", name="admin_skill_add", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function skillAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($skill);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/skill/addSkill.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/skill/{id}", name="admin_skill_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function skillShow(Skill $skill): Response
    {
        return $this->render('admin/skill/showSkill.html.twig', [
            'skill' => $skill,
        ]);
    }

    /**
     * @Route("/skill/{id}/edit", name="admin_skill_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editSkill(
        Request $request,
        Skill $skill, 
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect('/admin/skill/' . $skill->getId());
        }

        return $this->render('admin/skill/editSkill.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/skill/{id}", name="admin_skill_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteSkill(
        Request $request,
        Skill $skill,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {
            $entityManager->remove($skill);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
