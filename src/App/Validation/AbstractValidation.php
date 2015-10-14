<?php

namespace App\Validation;

use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractValidation implements ValidationInterface
{
    /**
     * @var ValidatorInterface
     */
    protected $validator;

    /**
     * @inheritdoc
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @inheritdoc
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @inheritdoc
     */
    public function validate($data)
    {
        return $this->getValidator()->validate($data, $this->getConstraints());
    }
}
