<?php

namespace App\Requests\Products;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints as Assert;

class ProductCreateRequest extends \App\Requests\BaseRequest
{
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
                "name" => new Assert\Required([new Assert\Type("string"), new Assert\NotBlank()]),
                "amount" => new Assert\Required([new Assert\Type("int"), new Assert\NotBlank()]),
                "price" => new Assert\Required([new Assert\Type("float"), new Assert\NotBlank()]),
                "storageId" => new Assert\Required([new Assert\Type("int"), new Assert\NotBlank()]),
            ])
        );

        if ($errorsEntity->count() > 0) {
            $this->sendValidationErrors($errorsEntity);
        }
    }

    public function toArray(){
        return [
            "name" => $this->name,
            "amount" => $this->amount,
            "price" => $this->price,
            "storageId" => $this->storageId,
        ];
    }
}