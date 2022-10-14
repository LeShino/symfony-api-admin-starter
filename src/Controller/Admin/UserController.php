<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserProfilType;
use App\Form\UserPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/utilisateurs", name="app_admin_user")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(UserRepository $users): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     *
     * @Route("/admin/creation-utilisateur", name="app_admin_user_add", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Utilisateur enregistré avec succès!'
            );

            return $this->redirectToRoute('app_admin_user');
        }
        return $this->renderForm('admin/user/add.html.twig', ['form' => $form]);
    }


    /**
     * @Route("/admin/connexion", name="security.login", methods={"GET", "POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('admin/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /**
     * Déconnexion
     * @Route("/deconnexion", name="security.logout")
     *@IsGranted("ROLE_USER")
     * @return void
     */
    public function logout()
    {
    }


    /**
     * MODIFIER PROFIL UTILISATEUR/ MODIFIER MOT DE PASSE
     *@Route("/admin/utilisateur/{id}/profil", name="app_admin_user_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     *@IsGranted("ROLE_ADMIN")
     * @param User $User
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     */
    public function editProfil(User $utilisateur, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {

        $form = $this->createForm(EditUserProfilType::class, $utilisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setUpdatedAt(new \DateTimeImmutable);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Profil utilisateur mise à jour avec succès!'
            );
            return $this->redirectToRoute('app_admin_user');
        }

        $editPwdForm = $this->createForm(UserPasswordType::class, $utilisateur);

        $editPwdForm->handleRequest($request);
        if ($editPwdForm->isSubmitted() && $editPwdForm->isValid()) {
            if ($hasher->isPasswordValid($utilisateur, $editPwdForm->getData()->getPlainPassword())) {
                //IL faut modifier une colonne dans la table pour que l'Event PreUpdate s'active 
                $utilisateur->setUpdatedAt(new \DateTimeImmutable);

                $utilisateur->setPlainPassword(
                    $editPwdForm->getData()->getNewPassword()
                );

                $manager->persist($utilisateur);
                $manager->flush();

                $this->addFlash(
                    'success',
                    'Mot de passe modifié avec succès!'
                );

                return $this->redirectToRoute('app_admin_user');
            } else {
                $this->addFlash(
                    'error',
                    'Ancien mot de passe incorrect.'
                );
            }
        }

        return $this->renderForm('admin/user/edit.html.twig', ['form' => $form, 'editPwdForm' => $editPwdForm]);
    }


    /**
     * SUPPRIMER UN UTILISATEUR
     * @Route("/admin/utilisateur/{id}/suppression", name="app_admin_user_delete", methods={"GET"}, requirements={"id"="\d+"})
     *@IsGranted("ROLE_ADMIN")
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(User $user, EntityManagerInterface $manager): Response
    {
        if (!$user) {
            $this->addFlash(
                'error',
                'Utilisateur non trouvé!'
            );
            return $this->redirectToRoute('app_admin_user');
        }

        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Utilisateur supprimé avec succès!'
        );

        return $this->redirectToRoute('app_admin_user');
    }
}
