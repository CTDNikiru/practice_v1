<?php
namespace App\Requests;

use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    /**
     * Вызов валидации запроса
     */
    public function validate(): void
    {
        $errors = $this->validator->validate($this);
        if($errors->count() > 0){
            $this->sendValidationErrors($errors);
        }
    }

    /**
     * Отправляет сообщение об ошибке валидации
     * @param ConstraintViolationListInterface $errors
     * @return void
     */
    #[NoReturn] public function sendValidationErrors(ConstraintViolationListInterface $errors){
        $messages = ['status' => "error", 'code'=>10009, 'message' => 'validation_failed', 'errors' => []];
        foreach ($errors as $message) {
            $messages['errors'][] = [
                $message->getPropertyPath() => $message->getMessage(),
            ];
        }
        $response = new JsonResponse($messages);
        $response->send();
        exit;
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    /**
     * Распределение запроса по параметрам
     * @return void
     **/
    protected function populate(): void
    {
        $request = $this->getRequest();
        if($request->getMethod() == Request::METHOD_GET || $request->getMethod() == Request::METHOD_DELETE){
            $params = $request->query->all();
        }
        else{
            $params = $request->toArray();
        }

        foreach ($params as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * Автовалидация запроса
     * Если валидация запроса не нужна, переопределите эту функцию в запросе с return false
     * @return bool
     **/
    public function autoValidateRequest(){
        return true;
    }
}