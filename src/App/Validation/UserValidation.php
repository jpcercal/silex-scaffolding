<?php

namespace App\Validation;

use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserValidation extends AbstractValidation implements ValidationInterface
{
    /**
     * @inheritdoc
     */
    public function getConstraints()
    {
        return new Collection([
            'fields' => [
                'username' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
                'password' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
            ],
            'allowExtraFields'   => true,
            'allowMissingFields' => false,
        ]);
    }
}