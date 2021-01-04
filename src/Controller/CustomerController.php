<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Representation\Entities;
use App\Repository\CustomerRepository;
use App\Repository\CompanyRepository;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class CustomerController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/companies/{companyId}/customers", name="list_customers", requirements={"companyId"="\d+"})
     * @Rest\QueryParam(
     *      name="page",
     *      requirements="\d+",
     *      default="1",
     *      description="The page number."
     * )
     * @Rest\QueryParam(
     *      name="limit",
     *      requirements="\d+",
     *      default="10",
     *      description="Limit of items per page."
     * )
     * @Rest\QueryParam(
     *      name="order",
     *      requirements="asc|desc",
     *      default="asc",
     *      description="Sort order (asc or desc)"
     * )
     * @Rest\View(statusCode=200)
     */
    public function listAction(ParamFetcherInterface $paramFetcher, CustomerRepository $customerRepository, $companyId)
    {
        $pager = $customerRepository->search(
            $paramFetcher->get('page'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('order'),
            $companyId
        );
        return new Entities($pager);
    }

    /**
     * @Rest\Get(
     *      path="/companies/{companyId}/customers/{id}",
     *      name="show_customer",
     *      requirements={"companyId"="\d+", "id"="\d+"}
     * )
     * @Rest\View(statusCode=200)
     */
    public function showAction(CustomerRepository $customerRepository, $companyId, $id)
    {
        $customer = $customerRepository->findOneBy(['company' => $companyId, 'id' => $id]);
        return $customer;
    }

    /**
     * @Rest\Delete(
     *      path="/companies/{companyId}/customers/{id}",
     *      name="delete_customer",
     *      requirements={"companyId"="\d+", "id"="\d+"}
     * )
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(CustomerRepository $customerRepository, $companyId, $id)
    {
        $customer = $customerRepository->findOneBy(['company' => $companyId,'id' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();
    }

    /**
     * @Rest\Post(
     *      path="/companies/{id}/customers",
     *      name="create_customer",
     *      requirements={"id"="\d+"}
     * )
     * @Rest\View(statusCode=201)
     * @ParamConverter("customer", converter="fos_rest.request_body")
     */
    public function createAction(
        Customer $customer, CompanyRepository $companyRepository, $id,
        ConstraintViolationListInterface $validationErrors
    )
    {
        if (count($validationErrors) > 0) {
            return $this->view($validationErrors, 404);
        } else {
            $company = $companyRepository->findOneBy(['id' => $id]);
            
            if ($company) {
                $customer->setCompany($company);

                try {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($customer);
                    $em->flush();

                    return $customer;
                } catch (\Exception $e) {
                    return $this->view('Erreur bdd', 400);
                }
            } else {
                return $this->view('client inconnu', 404);
            }
        }
    }
}
