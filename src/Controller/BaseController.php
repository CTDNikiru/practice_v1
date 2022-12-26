<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    public function response(array $params = []): JsonResponse
    {
        return $this->json($params);
    }

    public function responseWithError(Exception $e): JsonResponse
    {
        return $this->json(["status" => "error", 'error' => ['code'=>$e->getCode(), 'message' => $e->getMessage()]]);
    }

    public function responseWithErrorDescribed($message, int $code): JsonResponse
    {
        return $this->json(["status" => "error", 'error' =>['code'=>$code, 'message' => $message]]);
    }
}