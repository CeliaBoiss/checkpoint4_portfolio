<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

class CustomerController extends AbstractController
{
    /**
     * @Route("/admin/customer/add", name="admin_customer_add", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function customerAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/customer/addCustomer.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/customer/{id}", name="admin_customer_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function customerShow(Customer $customer): Response
    {
        return $this->render('admin/customer/showCustomer.html.twig', [
            'customer' => $customer,
        ]);
    }

    /**
     * @Route("/customer/{id}/edit", name="admin_customer_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function editCustomer(
        Request $request,
        Customer $customer, 
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirect('/admin/customer/' . $customer->getId());
        }

        return $this->render('admin/customer/editCustomer.html.twig', [
            'customer' => $customer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/customer/{id}", name="admin_customer_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteCustomer(
        Request $request,
        Customer $customer,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$customer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($customer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
