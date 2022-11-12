<?php

namespace App\Controller\Admin;

use Symfony\Component\Uid\Uuid;
use App\Repository\UserRepository;
use WouterJ\EloquentBundle\Facade\Db;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class MarchandController extends AbstractController

{
    /**
     * @Route("admin/dashboard", name="marchand_dashboard", methods={"GET"})
     *
     * @return void
     */
    public function dashboard(): Response
    {
        return $this->render('marchands/dashboard.html.twig');
    }

    /**
     * @Route("admin/credentials", name="marchand_credentials", methods={"GET"})
     * @return void
     */
    public function apiKey(): Response
    {
        return $this->render('marchands/credentials.html.twig');
    }
    /**
     * @Route("admin/credentials", name="generate_credentials", methods={"POST"})
     * @return void
     */
    public function generate(EntityManagerInterface $manager): Response
    {

        $user = $this->getUser();

        $namespace = Uuid::v4();
        $uuid = Uuid::v3($namespace, $user->getEmail());

        $user->setClientId($user->getCLientId() + 1);
        $user->setClientSecret($uuid);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Vos clés ont été régénérer avec succès!'
        );

        return $this->redirectToRoute('marchand_credentials');
    }

    /**
     * @Route("admin/marchands", name="marchand_index", methods={"GET"})
     * @return void
     */
    public function index(UserRepository $userRepo): Response
    {
        $marchands = $userRepo->findBy(array('isMarchand' => true));

        return $this->render('admin/marchands/index.html.twig', compact('marchands'));
    }
}
