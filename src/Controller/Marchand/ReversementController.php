<?php

namespace App\Controller\Marchand;

use App\Repository\ReversementRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_MARCHAND")
 */
class ReversementController extends AbstractController
{
    /**
     * @Route("marchand/reversements", name="marchand_reversements", methods={"GET"})
     *
     * @return void
     */
    public function index(ReversementRepository $reversementRepo): Response
    {
        $reversements = $reversementRepo->findBy(['marchand' => $this->getUser()]);
        return $this->render('marchands/reversements/index.html.twig', compact('reversements'));
    }
}
