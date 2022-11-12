<?php
namespace App\Controller\Admin;


use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("admin/transactions", name="admin_transactions", methods={"GET"})
     *
     * @return void
     */
    public function index(TransactionRepository $transRepo): Response
    {
        $transactions = $transRepo->findAll();
        return $this->render('admin/transactions/index.html.twig', compact('transactions'));
    }
}
