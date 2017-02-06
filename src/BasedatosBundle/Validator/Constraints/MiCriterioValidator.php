<?php
// src/AppBundle/Validator/Constraints/ContainsAlphanumericValidator.php
namespace BasedatosBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MiCriterioValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if(strlen($value)>5){
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }

    }
}
