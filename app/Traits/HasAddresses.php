<?php

declare(strict_types=1);

namespace Modules\Geo\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
<<<<<<< HEAD
=======
use Webmozart\Assert\Assert;
>>>>>>> laraxot/dev

/**
 * Trait HasAddresses.
 *
<<<<<<< HEAD
 * Questo trait fornisce funzionalità per gestire indirizzi multipli su qualsiasi modello.
 */
trait HasAddresses
{
    /** @return MorphMany<Address, $this> */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model'); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function primaryAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('is_primary', true); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function homeAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::HOME->value); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function workAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::WORK->value); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::BILLING->value); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::SHIPPING->value); // @phpstan-ignore return.type
    }

    /**
     * Imposta un indirizzo come principale.
     */
    public function setPrimaryAddress(Address $address): void
    {
        // Assicurati che l'indirizzo appartenga a questo modello
=======
 * @property MorphMany<Address, $this> $addresses
 * @property MorphOne<Address, $this>  $primaryAddress
 * @property MorphOne<Address, $this>  $homeAddress
 * @property MorphOne<Address, $this>  $workAddress
 * @property MorphOne<Address, $this>  $billingAddress
 * @property MorphOne<Address, $this>  $shippingAddress
 */
trait HasAddresses
{
    /**
     * Relazione a tutti gli indirizzi.
     *
     * @return MorphMany<Address, $this>
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo principale.
     *
     * @return MorphOne<Address, $this>
     */
    public function primaryAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('is_primary', true);
    }

    /**
     * Relazione all'indirizzo di casa.
     *
     * @return MorphOne<Address, $this>
     */
    public function homeAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::HOME->value);
    }

    /**
     * Relazione all'indirizzo di lavoro.
     *
     * @return MorphOne<Address, $this>
     */
    public function workAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::WORK->value);
    }

    /**
     * Relazione all'indirizzo di fatturazione.
     *
     * @return MorphOne<Address, $this>
     */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::BILLING->value);
    }

    /**
     * Relazione all'indirizzo di spedizione.
     *
     * @return MorphOne<Address, $this>
     */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::SHIPPING->value);
    }

    public function setPrimaryAddress(Address $address): void
    {
>>>>>>> laraxot/dev
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            throw new \InvalidArgumentException('L\'indirizzo non appartiene a questo modello.');
        }

<<<<<<< HEAD
        // Rimuovi lo stato primario da tutti gli altri indirizzi
        $this->addresses()->update(['is_primary' => false]);

        // Imposta questo indirizzo come primario
=======
        $this->addresses()->update(['is_primary' => false]);

>>>>>>> laraxot/dev
        $address->is_primary = true;
        $address->save();
    }

    /**
<<<<<<< HEAD
     * Aggiunge un nuovo indirizzo.
     *
=======
>>>>>>> laraxot/dev
     * @param array<string, mixed> $data
     */
    public function addAddress(array $data, bool $isPrimary = false): Address
    {
<<<<<<< HEAD
        // Se l'indirizzo deve essere primario, rimuovi lo stato primario dagli altri
=======
>>>>>>> laraxot/dev
        if ($isPrimary) {
            $this->addresses()->update(['is_primary' => false]);
        }

<<<<<<< HEAD
        // Crea il nuovo indirizzo
        $data['is_primary'] = $isPrimary;

        return $this->addresses()->create($data);
    }

    /** @return Collection<int, Address> */
=======
        $payload = array_merge($data, ['is_primary' => $isPrimary]);

        $address = $this->addresses()->create($payload);
        Assert::isInstanceOf($address, Address::class);

        return $address;
    }

    /**
     * Ottiene gli indirizzi per tipo.
     *
     * @return Collection<int, Address>
     */
>>>>>>> laraxot/dev
    public function getAddressesByType(AddressTypeEnum|string $type): Collection
    {
        $typeValue = $type instanceof AddressTypeEnum ? $type->value : $type;

        return $this->addresses()->where('type', $typeValue)->get();
    }
}
