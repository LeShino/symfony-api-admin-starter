<?php
namespace App\Controller;


use App\Repository\ApiRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="app_admin_admin")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->render('admin/admin/dashboard.html.twig');
        } else {
            return $this->redirectToRoute('marchand_dashboard');
        }
    }

    /**
     * @Route("/apis/index", name="api_index", methods={"GET"})
     */
    public function api_index(ApiRepository $apis): Response
    {
        return $this->render('admin/api/index.html.twig', [
            'apis' => $apis->findAll(),
        ]);
    }
}
