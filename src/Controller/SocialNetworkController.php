<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SocialNetworkRepository;
use App\Entity\SocialNetwork;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SocialNetworkType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Service\FileManager;

class SocialNetworkController extends AbstractController
{
    public function getSocialNetworks(SocialNetworkRepository $socialNetworkRepository): Response {
        $socialNetworks = $socialNetworkRepository->findAll();

        return $this->render('_socialNetworks.html.twig', ['socialNetworks' => $socialNetworks]);
    }

    /**
     * @Route("/admin/socialNetwork/add", name="admin_social_network_add", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function addSocialNetwork(
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $socialNetwork = new SocialNetwork();
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logoFile')->getData();

            $resultsLogo = $fileManager->saveFile(
                $socialNetwork->getName() . '-logo',
                $logoFile,
                $this->getParameter('upload_directory')
            );

            $socialNetwork->setLogo($resultsLogo['fileName']);
            $entityManager->persist($socialNetwork);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/socialNetwork/addSocialNetwork.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/admin/socialNetwork/{id}", name="admin_social_network_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function socialNetworkShow(SocialNetwork $socialNetwork): Response
    {
        return $this->render('admin/socialNetwork/showSocialNetwork.html.twig', ['socialNetwork' => $socialNetwork]);
    }

    /**
     * @Route("/socialNetwork/{id}/delete", name="admin_social_network_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteSocialNetwork(
        SocialNetwork $socialNetwork,
        Request $request,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$socialNetwork->getId(), $request->request->get('_token'))) {            
            $fileManager->deleteFile($socialNetwork->getLogo(), $this->getParameter('upload_directory'));
            
            $entityManager->remove($socialNetwork);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/socialNetwork/{id}/edit", name="admin_social_network_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editSocialNetwork(
        Request $request,
        SocialNetwork $socialNetwork,
        EntityManagerInterface $entityManager,
        FileManager $fileManager
    ): Response {
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logoFile')->getData();

            if ($logoFile != null) {
                $fileManager->deleteFile($socialNetwork->getLogo(), $this->getParameter('upload_directory'));

                $resultsLogo = $fileManager->saveFile(
                    $socialNetwork->getName() . '-logo',
                    $logoFile,
                    $this->getParameter('upload_directory')
                );

                $socialNetwork->setLogo($resultsLogo['fileName']);
            }

            $entityManager->flush();

            return $this->redirect('/admin/socialNetwork/' . $socialNetwork->getId());
        }

        return $this->render('admin/socialNetwork/editSocialNetwork.html.twig', [
            'socialNetwork' => $socialNetwork,
            'form' => $form->createView(),
        ]);
    }
}
