<?php

declare(strict_types=1);

namespace App\System\Listener;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;
use Hyperf\Validation\Validator;

#[Listener]
class ValidatorFactoryResolvedListener implements ListenerInterface
{
    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    public function process(object $event): void
    {
        /** @var ValidatorFactoryInterface $validatorFactory */
        $validatorFactory = $event->validatorFactory;

        $validatorFactory->extend('phone_number', function (
            string $attribute,
            mixed $value,
            array $parameters,
            Validator $validator,
        ): bool {
            return (bool)preg_match('/^1[3-9]\d{9}$/', $value);
        });
    }
}
