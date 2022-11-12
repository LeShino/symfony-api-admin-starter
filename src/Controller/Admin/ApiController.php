<?php

namespace App\Controller\Admin;

use App\Entity\Api;
use App\Form\ApiType;
use App\Form\EditApiType;
use App\Repository\ApiRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
 
    /**
     *
     * @Route("/admin/creation-api", name="app_admin_api_add", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function new(Request $request, EntityManagerInterface $manager)
    {
        $api = new Api();
        $form = $this->createForm(ApiType::class, $api);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $api = $form->getData();

            $manager->persist($api);
            $manager->flush();

            $this->addFlash(
                'success',
                'API enregistré avec succès!'
            );

            return $this->redirectToRoute('api_index');
        }
        return $this->renderForm('admin/api/add.html.twig', ['form' => $form]);
    }

    /**
     * MODIFIER API
     *@Route("/admin/apis/{id}/", name="app_admin_api_edit", methods={"GET", "POST"}, requirements={"id"="\d+"})
     *@IsGranted("ROLE_ADMIN")
     * @param Api $api
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function editApi(Api $api, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(EditApiType::class, $api);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $api = $form->getData();

            $manager->persist($api);
            $manager->flush();

            $this->addFlash(
                'success',
                'API mise à jour avec succès!'
            );
            return $this->redirectToRoute('api_index');
        }


        return $this->renderForm('admin/api/edit.html.twig', ['form' => $form]);
    }


    /**
     * SUPPRIMER UNE API
     * @Route("/admin/apis/{id}/suppression", name="app_admin_api_delete", methods={"GET"}, requirements={"id"="\d+"})
     *@IsGranted("ROLE_ADMIN")
     * @param Api $api
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Api $api, EntityManagerInterface $manager): Response
    {
        if (!$api) {
            $this->addFlash(
                'error',
                'API non trouvé!'
            );
            return $this->redirectToRoute('api_index');
        }

        $manager->remove($api);
        $manager->flush();

        $this->addFlash(
            'success',
            'API supprimé avec succès!'
        );

        return $this->redirectToRoute('api_index');
    }
}
