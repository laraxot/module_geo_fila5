<?php

declare(strict_types=1);

namespace Modules\Geo\Enums;

<<<<<<< HEAD
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Enum for address types.
 *
 * Uses EnumTrait for getLabel().
 * Configure values in: Modules/Geo/lang/{locale}/enums.php
 */
enum AddressTypeEnum: string implements HasLabel
{
    use EnumTrait;

=======
/**
 * Enum per i tipi di indirizzi.
 */
enum AddressTypeEnum: string
{
>>>>>>> laraxot/dev
    case HOME = 'home';
    case WORK = 'work';
    case BILLING = 'billing';
    case SHIPPING = 'shipping';
    case LEGAL = 'legal';
    case OTHER = 'other';

    /**
<<<<<<< HEAD
=======
     * Get the label for the enum value.
     */
    public function label(): string
    {
        return match ($this) {
            self::HOME => 'Casa',
            self::WORK => 'Lavoro',
            self::BILLING => 'Fatturazione',
            self::SHIPPING => 'Spedizione',
            self::LEGAL => 'Sede legale',
            self::OTHER => 'Altro',
        };
    }

    /**
>>>>>>> laraxot/dev
     * Get all the options as key-value pairs.
     *
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
<<<<<<< HEAD
            self::HOME->value => self::HOME->getLabel(),
            self::WORK->value => self::WORK->getLabel(),
            self::BILLING->value => self::BILLING->getLabel(),
            self::SHIPPING->value => self::SHIPPING->getLabel(),
            self::LEGAL->value => self::LEGAL->getLabel(),
            self::OTHER->value => self::OTHER->getLabel(),
=======
            self::HOME->value => self::HOME->label(),
            self::WORK->value => self::WORK->label(),
            self::BILLING->value => self::BILLING->label(),
            self::SHIPPING->value => self::SHIPPING->label(),
            self::LEGAL->value => self::LEGAL->label(),
            self::OTHER->value => self::OTHER->label(),
>>>>>>> laraxot/dev
        ];
    }
}
