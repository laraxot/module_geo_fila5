<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Models\Address;

use function Safe\preg_replace;

=======
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Models\Address;
>>>>>>> laraxot/dev
use Webmozart\Assert\Assert;

/**
 * Trait HasAddress.
 *
<<<<<<< HEAD
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 *
 * @property Collection<int, Address> $addresses
 * @property string|null              $route
 * @property string|null              $street_number
 * @property string|null              $postal_code
 * @property string|null              $city
 * @property string|null              $province
 * @property string|int               $id
 */
trait HasAddress
{
    /**
     * Ottiene gli indirizzi associati al modello.
     *
     * @return MorphMany<Address, $this>
     */
    public function addresses(): MorphMany // @phpstan-ignore missingType.generics
    {return $this->morphMany(Address::class, 'model');
    }

    /**
     * Ottiene indirizzo associato al modello.
     *
     * @return MorphOne<Address, $this>
     */
    public function address(): MorphOne // @phpstan-ignore missingType.generics
    {return $this->morphOne(Address::class, 'model');
    }

    /**
     * Ottiene l'indirizzo principale del modello.
     */
=======
 * @property MorphMany<Address, $this> $addresses
 * @property MorphOne<Address, $this>  $address
 */
trait HasAddress
{
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

>>>>>>> laraxot/dev
    public function primaryAddress(): ?Address
    {
        $res = $this->addresses()->where('is_primary', true)->first();
        if (null === $res) {
            return $res;
        }
        Assert::isInstanceOf($res, Address::class);

        return $res;
    }

<<<<<<< HEAD
    /**
     * Ottiene l'indirizzo completo formattato.
     */
=======
>>>>>>> laraxot/dev
    public function getFullAddress(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->getFullAddress() : null;
    }

    public function getFullAddressAttribute(?string $value): string
    {
        if (null !== $value) {
            return $value;
        }
<<<<<<< HEAD
        $address = sprintf(
            '%s, %s - %s, %s (%s)',
            $this->route,
            $this->street_number,
            $this->postal_code,
            $this->city,
            $this->province,
        );

        return trim(preg_replace('/[,\s]+/', ' ', $address));
=======

        $route = $this->getAttribute('route');
        $streetNumber = $this->getAttribute('street_number');
        $postalCode = $this->getAttribute('postal_code');
        $city = $this->getAttribute('city');
        $province = $this->getAttribute('province');

        $formatted = sprintf(
            '%s, %s - %s, %s (%s)',
            is_string($route) ? $route : '',
            is_string($streetNumber) ? $streetNumber : '',
            is_string($postalCode) ? $postalCode : '',
            is_string($city) ? $city : '',
            is_string($province) ? $province : '',
        );

        return trim(preg_replace('/[,\s]+/', ' ', $formatted));
>>>>>>> laraxot/dev
    }

    public function getFullAddressesAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }
        $address = $this->address()->first();
        if (null === $address) {
            return null;
        }
        Assert::isInstanceOf($address, Address::class);

        $locality = $address->getLocality();
        if (null === $locality) {
            return null;
        }

        $streetAddress = is_string($address->street_address) ? $address->street_address : '';
        $streetNumber = is_string($address->street_number) ? $address->street_number : '';
        $postalCode = is_string($address->postal_code) ? $address->postal_code : '';

        $localityNome = isset($locality['nome']) && is_string($locality['nome']) ? $locality['nome'] : '';
        $provinciaNome = isset($locality['provincia']) && is_array($locality['provincia']) && isset($locality['provincia']['nome']) && is_string($locality['provincia']['nome']) ? $locality['provincia']['nome'] : '';

        return $streetAddress.
            ', '.
            $streetNumber.
            ' - '.
            $postalCode.
            ' '.
            $localityNome.
            ' ('.
            $provinciaNome.
            ') ';
    }

<<<<<<< HEAD
    /**
     * Ottiene la località dell'indirizzo principale.
     */
=======
>>>>>>> laraxot/dev
    public function getCity(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->locality : null;
    }

<<<<<<< HEAD
    /**
     * Ottiene il CAP dell'indirizzo principale.
     */
=======
>>>>>>> laraxot/dev
    public function getPostalCode(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->postal_code : null;
    }

<<<<<<< HEAD
    /**
     * Ottiene la provincia dell'indirizzo principale.
     */
=======
>>>>>>> laraxot/dev
    public function getProvince(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->administrative_area_level_3 : null;
    }

<<<<<<< HEAD
    /**
     * Ottiene la regione dell'indirizzo principale.
     */
=======
>>>>>>> laraxot/dev
    public function getRegion(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->administrative_area_level_2 : null;
    }

<<<<<<< HEAD
    /**
     * Ottiene il paese dell'indirizzo principale.
     */
=======
>>>>>>> laraxot/dev
    public function getCountry(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->country : null;
    }

<<<<<<< HEAD
    /**
     * Imposta un indirizzo come principale e rimuove il flag da tutti gli altri.
     */
    public function setAsPrimaryAddress(Address $address): bool
    {
        // Verifica che l'indirizzo appartenga a questo modello
=======
    public function setAsPrimaryAddress(Address $address): bool
    {
>>>>>>> laraxot/dev
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            return false;
        }

<<<<<<< HEAD
        // Rimuovi il flag is_primary da tutti gli altri indirizzi
=======
>>>>>>> laraxot/dev
        $this->addresses()
            ->where('id', '!=', $address->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);

<<<<<<< HEAD
        // Imposta questo indirizzo come principale
=======
>>>>>>> laraxot/dev
        return $address->update(['is_primary' => true]);
    }

    /**
<<<<<<< HEAD
     * Ottiene gli indirizzi di un determinato tipo.
     *
     * @return Collection<int, Address>
     */
    public function getAddressesByType(string $type): Collection // @phpstan-ignore missingType.generics
    {return $this->addresses()->where('type', $type)->get();
    }

    /**
     * Aggiunge un nuovo indirizzo al modello.
     *
     * @param array<string, mixed> $data
     * @param bool                 $setPrimary Se impostare questo indirizzo come principale
     */
    public function addAddress(array $data, bool $setPrimary = false): Address // @phpstan-ignore missingType.iterableValue, return.type
    {// Se è il primo indirizzo o è richiesto esplicitamente, impostalo come principale
            if ($setPrimary || 0 === $this->addresses()->count()) {
                $data['is_primary'] = true;

                // Rimuovi il flag is_primary da tutti gli altri indirizzi
                if ($this->addresses()->count() > 0) {
                    $this->addresses()->update(['is_primary' => false]);
                }
            }

        /** @var Address $address */
        $address = $this->addresses()->create($data); // @phpstan-ignore argument.type
=======
     * @return Collection<int, Address>
     */
    public function getAddressesByType(string $type): Collection
    {
        return $this->addresses()->where('type', $type)->get();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function addAddress(array $data, bool $setPrimary = false): Address
    {
        $payload = $data;

        if ($setPrimary || 0 === $this->addresses()->count()) {
            $payload = array_merge($payload, ['is_primary' => true]);

            if ($this->addresses()->count() > 0) {
                $this->addresses()->update(['is_primary' => false]);
            }
        }

        $address = $this->addresses()->create($payload);
        Assert::isInstanceOf($address, Address::class);
>>>>>>> laraxot/dev

        return $address;
    }

    /**
<<<<<<< HEAD
     * Aggiorna l'indirizzo principale.
     *
     * @param array<string, mixed> $data
     */
    public function updatePrimaryAddress(array $data): ?Address // @phpstan-ignore missingType.iterableValue
    {$primaryAddress = $this->primaryAddress();
=======
     * @param array<string, mixed> $data
     */
    public function updatePrimaryAddress(array $data): ?Address
    {
        $primaryAddress = $this->primaryAddress();

>>>>>>> laraxot/dev
        if (! $primaryAddress) {
            return $this->addAddress($data, true);
        }

<<<<<<< HEAD
        $primaryAddress->update($data); // @phpstan-ignore argument.type
=======
        $primaryAddress->update($data);
>>>>>>> laraxot/dev

        return $primaryAddress;
    }

    /**
<<<<<<< HEAD
     * Scope per filtrare i modelli in base alla città dell'indirizzo.
     */
    /** @param Builder<Model> $query
     *  @return Builder<Model> */
    public function scopeInCity(Builder $query, string $city): Builder // @phpstan-ignore missingType.generics
    {return $query->whereHas('addresses', function (Builder $q) use ($city): void {
        $q->where('locality', $city);
    });
    }

    /**
     * Scope per filtrare i modelli in base alla provincia dell'indirizzo.
     *
     * @param Builder<Model> $query
     *
     * @return Builder<Model>
     */
    public function scopeInProvince(Builder $query, string $province): Builder // @phpstan-ignore missingType.generics
    {return $query->whereHas('addresses', function (Builder $q) use ($province): void {
        $q->where('administrative_area_level_3', $province);
    });
    }

    /**
     * Scope per filtrare i modelli in base alla regione dell'indirizzo.
     *
     * @param Builder<Model> $query
     *
     * @return Builder<Model>
     */
    public function scopeInRegion(Builder $query, string $region): Builder // @phpstan-ignore missingType.generics
    {return $query->whereHas('addresses', function (Builder $q) use ($region): void {
        $q->where('administrative_area_level_2', $region);
    });
    }

    /**
     * Scope per filtrare i modelli in base al CAP dell'indirizzo.
     *
     * @param Builder<Model> $query
     *
     * @return Builder<Model>
     */
    public function scopeInPostalCode(Builder $query, string $postalCode): Builder // @phpstan-ignore missingType.generics
    {return $query->whereHas('addresses', function (Builder $q) use ($postalCode): void {
        $q->where('postal_code', $postalCode);
    });
    }

    /**
     * Initialize the trait.
     */
    protected function initializeHasAddress(): void
    {
        /** @var array<string> $fields */
        $fields = array_values(array_map(
            fn (AddressItemEnum $item): string => $item->value,
            AddressItemEnum::cases(),
        ));
        $this->mergeFillable($fields);
=======
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInCity(Builder $query, string $city): Builder
    {
        $query->whereHas('addresses', function ($q) use ($city): void {
            $q->where('locality', $city);
        });

        return $query;
    }

    /**
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInProvince(Builder $query, string $province): Builder
    {
        $query->whereHas('addresses', function ($q) use ($province): void {
            $q->where('administrative_area_level_3', $province);
        });

        return $query;
    }

    /**
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInRegion(Builder $query, string $region): Builder
    {
        $query->whereHas('addresses', function ($q) use ($region): void {
            $q->where('administrative_area_level_2', $region);
        });

        return $query;
    }

    /**
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInPostalCode(Builder $query, string $postalCode): Builder
    {
        $query->whereHas('addresses', function ($q) use ($postalCode): void {
            $q->where('postal_code', $postalCode);
        });

        return $query;
    }

    protected function initializeHasAddress(): void
    {
        $this->mergeFillable(Arr::map(
            AddressItemEnum::cases(),
            static fn (AddressItemEnum $item): string => $item->value,
        ));
>>>>>>> laraxot/dev
    }
}
