<?php

namespace App\Controller\Marchand;

use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_MARCHAND")
 */
class MarchandController extends AbstractController

{
    /**
     * @Route("marchand/dashboard", name="marchand_dashboard", methods={"GET"})
     *
     * @return void
     */
    public function dashboard(): Response
    {
        return $this->render('marchands/dashboard.html.twig');
    }

    /**
     * @Route("marchand/credentials", name="marchand_credentials", methods={"GET"})
     * @return void
     */
    public function apiKey(): Response
    {
        return $this->render('marchands/credentials.html.twig');
    }
    /**
     * @Route("generate/credentials", name="generate_credentials", methods={"POST"})
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
}
