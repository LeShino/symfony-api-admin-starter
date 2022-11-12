<?php
namespace App\Controller\Admin;


use App\Repository\ReversementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class ReversementController extends AbstractController
{
    /**
     * @Route("admin/reversements", name="admin_reversements", methods={"GET"})
     *
     * @return void
     */
    public function index(ReversementRepository $reversementRepo): Response
    {
        $reversements = $reversementRepo->findAll();
        return $this->render('admin/reversements/index.html.twig', compact('reversements'));
    }
}
