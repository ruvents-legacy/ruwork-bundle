<?php

namespace Ruwork\CoreBundle\Validator\Constraints;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AliasValidator extends ConstraintValidator
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Alias) {
            throw new UnexpectedTypeException($constraint, Alias::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }

        $violationsList = $this->context->getValidator()->validate($value, [
            new Length([
                'max' => $constraint->maxLength,
                'maxMessage' => $constraint->maxLengthMessage,
            ]),
            new Regex([
                'htmlPattern' => $constraint->htmlPattern,
                'message' => $constraint->regexMessage,
                'pattern' => $constraint->pattern,
            ]),
        ]);

        foreach ($violationsList as $violation) {
            /** @var $violation ConstraintViolationInterface */
            $this->context->buildViolation($violation->getMessage())
                ->setCode($violation->getCode())
                ->addViolation();
        }

        $object = $this->context->getObject();

        if (null !== $object && null !== $this->registry->getManagerForClass(get_class($object))) {
            $violationsList = $this->context
                ->getValidator()
                ->validate($object, [
                    new UniqueEntity([
                        'entityClass' => $constraint->entityClass,
                        'fields' => $this->context->getPropertyName(),
                        'ignoreNull' => false,
                        'repositoryMethod' => $constraint->repositoryMethod,
                    ]),
                ]);

            if (0 < count($violationsList)) {
                $violation = $violationsList->get(0);
                $this->context->buildViolation($constraint->notUniqueMessage)
                    ->setParameters($violation->getParameters())
                    ->setCode($violation->getCode())
                    ->addViolation();
            }
        }
    }
}
