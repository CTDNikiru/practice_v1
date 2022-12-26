<?php

namespace App\Controller;

use App\Requests\Products\ProductCreateRequest;
use App\Requests\Products\ProductUpdateRequest;
use App\Services\ProductService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends BaseController
{
    private ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/product/test",
     *     methods = "GET")
     */
    public function test()
    {
        return $this->response(["status" => "OK"]);
    }

    /**
     * @Route("/product/index/{id}",
     *     methods = "GET")
     */
    public function index(int $id)
    {
        try {
            $result = $this->service->index($id);
            return $this->response($result);
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @Route("/product/list",
     *     methods = "GET")
     */
    public function list()
    {
        try {
            $result = $this->service->list();
            return $this->response($result);
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @Route("/product/delete/{id}",
     *     methods = "DELETE")
     */
    public function delete(int $id)
    {
        try {
            $result = $this->service->delete($id);
            return $this->response(["status" => $result ? "OK" : "error"]);
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @Route("/product/create",
     *     methods = "POST")
     */
    public function create(ProductCreateRequest $request)
    {
        try {
            $result = $this->service->create($request->toArray());
            return $this->response(["status" => $result ? "OK" : "error"]);
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }

    /**
     * @Route("/product/update",
     *     methods = "PUT")
     */
    public function update(ProductUpdateRequest $request)
    {
        try {
            $result = $this->service->update($request->toArray());
            return $this->response(["status" => $result ? "OK" : "error"]);
        } catch (\Exception $e) {
            return $this->responseWithError($e);
        }
    }
}
