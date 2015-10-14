<?php

namespace App\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface ValidationInterface
{
    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator);

    /**
     * Get the validator instance
     *
     * @return ValidatorInterface
     */
    public function getValidator();

    /**
     * Get constraints
     *
     * @return Constraint
     */
    public function getConstraints();

    /**
     * Validate data
     *
     * @param mixed $data
     *
     * @return ConstraintViolationListInterface
     */
    public function validate($data);
}
