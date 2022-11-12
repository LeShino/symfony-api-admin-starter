<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Repository\ApiRepository;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarchandAPIController extends AbstractController
{
    private UserRepository $userRepository;
    private ApiRepository $apiRepository;

    public function __construct(ApiRepository $apiRepository, UserRepository $userRepository)
    {
        $this->apiRepository = $apiRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * @Route("/marchands/test/api", name="clients", methods={"GET"})
     */
    public function clients(): JsonResponse
    {
        $api = $this->apiRepository->findOneBy(array('name' => 'Liste Marchand'));

        if ($api->getStatus() == "Active") {
            return $this->success([
                'clients' => array_map(function (User $client) {
                    return $client->toArray();
                }, $this->userRepository->findBy(array('isMarchand' => true)))
            ]);
        } else {
            return  $this->error($api->getStatus(), 404);
        }
    }

    public function success(array $data = null, $message = 'success', int $codeHttp = 200): JsonResponse
    {
        return new JsonResponse([
            'status' => 1,
            'message' => $message,
            'data' => $data
        ], $codeHttp);
    }
    public function error(string $message, $code): JsonResponse
    {
        return new JsonResponse([
            'status' => 1,
            'message' => $message ?? 'error',
        ], $code ?? 500);
    }
}
