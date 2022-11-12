<?php

namespace App\Controller\Marchand;

use App\Entity\User;
use App\Form\MarchandRegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{

    /**
     * @Route("/marchand/connexion", name="marchand.login", methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('marchands/auth.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
    /**
     * Formulaire d'inscription utilisateur
     * @Route("/marchand/inscription", name="marchand.register", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function register(Request $request, EntityManagerInterface $manager): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_MARCHAND']);

        $form = $this->createForm(MarchandRegisterType::class, $user);

        $form->handleRequest($request);

        // dd($form->getData());
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre compte a été créé avec succès!'
            );

            return $this->redirectToRoute('marchand.login');
        }
        return $this->renderForm('marchands/register.html.twig', ['form' => $form]);
    }

    /**
     * @Route("marchand/logout", name="marchand_logout", methods={"POST"})
     */
    public function logout()
    {
        $this->get('session')->start();
        $this->get('session')->invalidate();

        return $this->redirectToRoute('marchand.login');
    }
}
