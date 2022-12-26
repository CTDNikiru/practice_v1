<?php

namespace App\Services;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(int $id){
        $entity = $this->productRepository->find($id);
        if(!isset($entity)){
            throw new \Exception("Сущность не найдена", 400);
        }
        return $entity->toArray();
    }

    public function create(array $data){
        $entity = new Product();
        $entity->setName($data["name"]);
        $entity->setPrice($data["price"]);
        $entity->setAmount($data["amount"]);
        $entity->setStorageId($data["storageId"]);
        $this->productRepository->save($entity, true);
        return true;
    }

    public function update(array $data){
        $id = $data["id"];
        $entity = $this->productRepository->find($id);
        if(!isset($entity)){
            throw new \Exception("Сущность не найдена", 400);
        }
        $entity->setName($data["name"] ?? $entity->getName());
        $entity->setPrice($data["price"] ?? $entity->getPrice());
        $entity->setAmount($data["amount"] ?? $entity->getAmount());
        $entity->setStorageId($data["storageId"] ?? $entity->getStorageId());
        $this->productRepository->save($entity, true);
        return true;
    }

    public function delete(int $id){
        $entity = $this->productRepository->find($id);
        if(!isset($entity)){
            throw new \Exception("Сущность не найдена", 400);
        }
        $this->productRepository->remove($entity, true);
        return true;
    }

    public function list(){
        $products = $this->productRepository->findAll();
        $result = [];
        foreach ($products as $product){
            $result[] = $product->toArray();
        }
        return $result;
    }

}