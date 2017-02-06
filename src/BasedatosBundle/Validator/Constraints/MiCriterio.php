<?php
// src/AppBundle/Validator/Constraints/ContainsAlphanumeric.php
namespace BasedatosBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MiCriterio extends Constraint
{
    public $message = 'Mi validator define que tu %string% esta mal xD';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
