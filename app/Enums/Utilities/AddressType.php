<?php

namespace App\Enums\Utilities;

enum AddressType: string
{
    case MANUAL = 'MANUAL';
    case AUTOMATIC = 'AUTOMATIC';

    public function getColor(): string
    {
        return match ($this) {
            AddressType::MANUAL => 'bg-secondary',
            AddressType::AUTOMATIC => 'bg-success',
        };
    }

    public function getName(): string
    {
        return match ($this) {

            self::MANUAL => 'MANUAL',
            self::AUTOMATIC => 'AUTOMATIC',
        };
    }

    public static function options()
    {
        return collect(self::cases())
            ->mapWithKeys(fn(self $type) => [
                $type->value => $type->getName(),
            ])
            ->toArray();
    }
}
