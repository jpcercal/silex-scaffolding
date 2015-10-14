<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationErrorResponse extends Response
{
    /**
     * @inheritdoc
     */
    public function __construct(ConstraintViolationList $errors, $status = 400, $headers = [])
    {
        $messages = [];

        foreach ($errors as $error) {
            $messages[] = sprintf('%s %s', $error->getPropertyPath(), $error->getMessage());
        }

        parent::__construct(json_encode($messages), $status, array_merge($headers, [
            'Content-Type' => 'application/json'
        ]));
    }
}
