<?php

namespace App\Requests\Products;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class ProductUpdateRequest extends \App\Requests\BaseRequest
{
    public ?int $id;
    public ?string $name;
    public ?int $amount;
    public ?float $price;
    public ?int $storageId;

    public function validate(): void
    {
        $query = $this->getRequest()->toArray();

        $errorsEntity = $this->validator->validate(
            $query,
            new Collection([
                "id" => new Assert\Required([new Assert\Type("int"), new Assert\NotBlank()]),
                "name" => new Assert\Optional([new Assert\Type("string"), new Assert\NotBlank()]),
                "amount" => new Assert\Optional([new Assert\Type("int"), new Assert\NotBlank()]),
                "price" => new Assert\Optional([new Assert\Type("float"), new Assert\NotBlank()]),
                "storageId" => new Assert\Optional([new Assert\Type("int"), new Assert\NotBlank()]),
            ])
        );

        if ($errorsEntity->count() > 0) {
            $this->sendValidationErrors($errorsEntity);
        }
    }

    public function toArray(){
        return [
            "id" => $this->id,
            "name" => $this->name ?? null,
            "amount" => $this->amount ?? null,
            "price" => $this->price ?? null,
            "storageId" => $this->storageId ?? null
        ];
    }
}