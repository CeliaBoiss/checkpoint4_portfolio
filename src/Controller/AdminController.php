<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ProjectRepository;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProjectType;
use App\Service\FileManager;
use App\Entity\Photo;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     * @IsGranted("ROLE_ADMIN")
     */

    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();

        return $this->render('admin/index.html.twig', ['projects' => $projects]);
    }

    /**
     * @Route("/admin/project/add", name="admin_project_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addProject(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $project = new Project();
        $projectForm = $this->createForm(ProjectType::class, $project);
        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            $photoFile1 = $projectForm->get('photoFile1')->getData();
            $photoFile2 = $projectForm->get('photoFile2')->getData();
            $photoFile3 = $projectForm->get('photoFile3')->getData();

            $entityManager->persist($project);
            $entityManager->flush();

            if ($photoFile1 != null) {
                $results = $fileManager->saveFile(
                    $project->getTitle(),
                    $photoFile1,
                    $this->getParameter('upload_directory')
                );
    
                $photo1 = new Photo();
                $photo1->setPhoto($results['fileName']);
                $photo1->setProject($project);
                $project->addPhoto($photo1);
                $entityManager->persist($photo1);
            }

            if ($photoFile2 != null) {
                $results = $fileManager->saveFile(
                    $project->getTitle(),
                    $photoFile2,
                    $this->getParameter('upload_directory')
                );
    
                $photo2 = new Photo();
                $photo2->setPhoto($results['fileName']);
                $photo2->setProject($project);
                $project->addPhoto($photo2);
                $entityManager->persist($photo2);
            }

            if ($photoFile3 != null) {
                $results = $fileManager->saveFile(
                    $project->getTitle(),
                    $photoFile3,
                    $this->getParameter('upload_directory')
                );
    
                $photo3 = new Photo();
                $photo3->setPhoto($results['fileName']);
                $photo3->setProject($project);
                $project->addPhoto($photo3);
                $entityManager->persist($photo3);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/addProject.html.twig', ['form' => $projectForm->createView()]);
    }

    /**
     * @Route("/admin/project/{id}", name="admin_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function projectShow(Project $project): Response
    {
        return $this->render('admin/showProject.html.twig', ['project' => $project]);
    }

    /**
     * @Route("/admin/project/{id}/delete", name="admin_project_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteProject(
        Project $project,
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $photos = $project->getPhotos();

            foreach ($photos as $photo) {
                $fileManager->deleteFile($photo->getPhoto(), $this->getParameter('upload_directory'));
            }
            
            $entityManager->remove($project);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/admin/project/{id}/edit", name="admin_project_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editProject(
        Request $request,
        Project $project,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile1 = $form->get('photoFile1')->getData();
            $photoFile2 = $form->get('photoFile2')->getData();
            $photoFile3 = $form->get('photoFile3')->getData();

            if ($photoFile1 != null) {
                if($project->getPhotos()[0] != null) {
                    $fileManager->deleteFile($project->getPhotos()[0], $this->getParameter('upload_directory'));
                }

                $results = $fileManager->saveFile(
                    $project->getTitle(),
                    $photoFile1,
                    $this->getParameter('upload_directory')
                );

                $photo1 = new Photo();
                $photo1->setPhoto($results['fileName']);
                $photo1->setProject($project);
                $project->addPhoto($photo1);
                $entityManager->persist($photo1);
            }

            if ($photoFile2 != null) {
                if($project->getPhotos()[1] != null) {
                    $fileManager->deleteFile($project->getPhotos()[1], $this->getParameter('upload_directory'));
                }

                $results = $fileManager->saveFile(
                    $project->getTitle(),
                    $photoFile2,
                    $this->getParameter('upload_directory')
                );

                $photo2 = new Photo();
                $photo2->setPhoto($results['fileName']);
                $photo2->setProject($project);
                $project->addPhoto($photo2);
                $entityManager->persist($photo2);
            }

            if ($photoFile3 != null) {
                if($project->getPhotos()[2] != null) {
                    $fileManager->deleteFile($project->getPhotos()[2], $this->getParameter('upload_directory'));
                }

                $results = $fileManager->saveFile(
                    $project->getTitle(),
                    $photoFile3,
                    $this->getParameter('upload_directory')
                );

                $photo3 = new Photo();
                $photo3->setPhoto($results['fileName']);
                $photo3->setProject($project);
                $project->addPhoto($photo3);
                $entityManager->persist($photo3);
            }

            $entityManager->flush();

            return $this->redirect('/admin/project/' . $project->getId());
        }

        return $this->render('admin/editProject.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }
}
