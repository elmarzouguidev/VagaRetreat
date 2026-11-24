<?php

namespace App\Enums\Transaction;

enum TransactionStatusEnums: string
{
    case PENDING = 'PENDING';
    case IN_PROGRESS = 'IN_PROGRESS';

    case SUCCESSFUL = 'SUCCESSFUL';
    case FAILED = 'FAILED';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'En attente',
            self::IN_PROGRESS => 'En cours',
            self::SUCCESSFUL => 'Réussie',
            self::FAILED => 'Échouée',
        };
    }

    public static function options()
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type) => [
                $type->value => $type->label(),
            ])
            ->toArray();
    }
}
