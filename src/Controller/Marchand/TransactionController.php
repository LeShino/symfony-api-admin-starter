<?php

namespace App\Controller\Marchand;

use App\Repository\TransactionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_MARCHAND")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("marchand/transactions", name="marchand_transactions", methods={"GET"})
     *
     * @return void
     */
    public function index(TransactionRepository $transRepo): Response
    {
        $transactions = $transRepo->findBy(['tuser' => $this->getUser()]);
        return $this->render('marchands/transactions/index.html.twig', compact('transactions'));
    }
}
