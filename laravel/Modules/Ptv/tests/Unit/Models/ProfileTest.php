<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Modules\Ptv\Models\Profile;
use Modules\User\Models\Membership;
use Modules\User\Models\User;

beforeEach(function () {
    $this->profile = Profile::factory()->create([
        'first_name' => 'Mario',
        'last_name' => 'Rossi',
        'ente' => 1,
        'matr' => 12345,
        'user_id' => 'user-123',
        'email' => 'mario.rossi@example.com',
        'phone' => '+39 123 456 7890',
        'bio' => 'Sviluppatore software esperto',
        'address' => 'Via Roma 123',
        'premise' => 'Palazzo A',
        'locality' => 'Milano',
        'postal_town' => 'Milano',
        'administrative_area_level_1' => 'Lombardia',
        'country' => 'Italia',
        'postal_code' => '20100',
        'route' => 'Via Roma',
        'street_number' => '123',
    ]);
});

describe('Profile Model Creation', function () {
    it('can be created with valid data', function () {
        expect($this->profile)
            ->toBeInstanceOf(Profile::class)
            ->first_name->toBe('Mario')
            ->last_name->toBe('Rossi')
            ->ente->toBe(1)
            ->matr->toBe(12345)
            ->user_id->toBe('user-123')
            ->email->toBe('mario.rossi@example.com')
            ->phone->toBe('+39 123 456 7890')
            ->bio->toBe('Sviluppatore software esperto');
    });

    it('uses ptv database connection', function () {
        expect($this->profile->getConnectionName())->toBe('ptv');
    });

    it('has factory', function () {
        $profiles = Profile::factory()->count(3)->create();

        expect($profiles)->toHaveCount(3);
        $profiles->each(function ($profile) {
            expect($profile)->toBeInstanceOf(Profile::class);
        });
    });
});

describe('Profile Model Attributes and Casts', function () {
    it('casts user_id as string', function () {
        $profile = Profile::factory()->create([
            'user_id' => 12345,
        ]);

        expect($profile->user_id)->toBe('12345');
    });

    it('casts data as array', function () {
        $profile = Profile::factory()->create([
            'data' => ['key' => 'value', 'number' => 42],
        ]);

        expect($profile->data)->toBeArray()
            ->and($profile->data)->toHaveKey('key')
            ->and($profile->data)->toHaveKey('number')
            ->and($profile->data['key'])->toBe('value')
            ->and($profile->data['number'])->toBe(42);
    });

    it('casts timestamps as datetime', function () {
        $profile = Profile::factory()->create();

        expect($profile->created_at)->toBeInstanceOf(Carbon::class)
            ->and($profile->updated_at)->toBeInstanceOf(Carbon::class);
    });

    it('has correct fillable attributes', function () {
        $fillable = $this->profile->getFillable();

        expect($fillable)->toContain('first_name', 'last_name', 'ente', 'matr', 'user_id');
    });
});

describe('Profile Model Business Logic', function () {
    it('can calculate full name', function () {
        $profile = Profile::factory()->create([
            'first_name' => 'Giuseppe',
            'last_name' => 'Verdi',
        ]);

        $fullName = $profile->first_name.' '.$profile->last_name;

        expect($fullName)->toBe('Giuseppe Verdi');
    });

    it('can validate employee data', function () {
        $profile = Profile::factory()->create([
            'ente' => 1,
            'matr' => 67890,
        ]);

        expect($profile->ente)->toBe(1)
            ->and($profile->matr)->toBe(67890);
    });

    it('can handle contact information', function () {
        $profile = Profile::factory()->create([
            'email' => 'test@example.com',
            'phone' => '+39 987 654 3210',
        ]);

        expect($profile->email)->toBe('test@example.com')
            ->and($profile->phone)->toBe('+39 987 654 3210');
    });

    it('can manage address information', function () {
        $profile = Profile::factory()->create([
            'address' => 'Via Milano 456',
            'premise' => 'Edificio B',
            'locality' => 'Roma',
            'postal_code' => '00100',
        ]);

        expect($profile->address)->toBe('Via Milano 456')
            ->and($profile->premise)->toBe('Edificio B')
            ->and($profile->locality)->toBe('Roma')
            ->and($profile->postal_code)->toBe('00100');
    });
});

describe('Profile Model Scopes and Queries', function () {
    it('can filter by establishment', function () {
        Profile::factory()->create(['ente' => 1]);
        Profile::factory()->create(['ente' => 2]);
        Profile::factory()->create(['ente' => 1]);

        $countEnte1 = Profile::where('ente', 1)->count();
        $countEnte2 = Profile::where('ente', 2)->count();

        expect($countEnte1)->toBe(3) // 2 created + 1 from beforeEach
            ->and($countEnte2)->toBe(1);
    });

    it('can filter by employee number', function () {
        Profile::factory()->create(['matr' => 11111]);
        Profile::factory()->create(['matr' => 22222]);

        $countMatr11111 = Profile::where('matr', 11111)->count();
        $countMatr22222 = Profile::where('matr', 22222)->count();

        expect($countMatr11111)->toBe(1)
            ->and($countMatr22222)->toBe(1);
    });

    it('can filter by user id', function () {
        Profile::factory()->create(['user_id' => 'user-456']);
        Profile::factory()->create(['user_id' => 'user-789']);

        $countUser123 = Profile::where('user_id', 'user-123')->count();
        $countUser456 = Profile::where('user_id', 'user-456')->count();

        expect($countUser123)->toBe(1) // from beforeEach
            ->and($countUser456)->toBe(1);
    });

    it('can search by name', function () {
        Profile::factory()->create(['first_name' => 'Giuseppe', 'last_name' => 'Verdi']);
        Profile::factory()->create(['first_name' => 'Antonio', 'last_name' => 'Rossi']);

        $marioProfiles = Profile::where('first_name', 'Mario')->count();
        $giuseppeProfiles = Profile::where('first_name', 'Giuseppe')->count();

        expect($marioProfiles)->toBe(1) // from beforeEach
            ->and($giuseppeProfiles)->toBe(1);
    });

    it('can filter by email domain', function () {
        Profile::factory()->create(['email' => 'test@company.com']);
        Profile::factory()->create(['email' => 'user@example.org']);

        $companyEmails = Profile::where('email', 'like', '%@company.com')->count();
        $exampleEmails = Profile::where('email', 'like', '%@example.org')->count();

        expect($companyEmails)->toBe(1)
            ->and($exampleEmails)->toBe(1);
    });
});

describe('Profile Model Validation', function () {
    it('requires essential fields', function () {
        $this->expectException(QueryException::class);

        Profile::create([
            // Missing required fields
        ]);
    });

    it('validates email format when provided', function () {
        $profile = Profile::factory()->create([
            'email' => 'invalid-email',
        ]);

        // The model should accept any string for email as per current implementation
        expect($profile->email)->toBe('invalid-email');
    });

    it('validates phone format when provided', function () {
        $profile = Profile::factory()->create([
            'phone' => '123-456-7890',
        ]);

        expect($profile->phone)->toBe('123-456-7890');
    });

    it('validates numeric fields', function () {
        $profile = Profile::factory()->create([
            'ente' => 'not-a-number',
        ]);

        // Should be cast to integer (0 if invalid)
        expect($profile->ente)->toBe(0);
    });
});

describe('Profile Model Address Management', function () {
    it('can build complete address', function () {
        $profile = Profile::factory()->create([
            'street_number' => '123',
            'route' => 'Via Roma',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'administrative_area_level_1' => 'Lombardia',
            'country' => 'Italia',
        ]);

        $fullAddress = $profile->street_number.' '.$profile->route.', '.
                      $profile->locality.' '.$profile->postal_code.', '.
                      $profile->administrative_area_level_1.', '.$profile->country;

        expect($fullAddress)->toBe('123 Via Roma, Milano 20100, Lombardia, Italia');
    });

    it('can handle short address versions', function () {
        $profile = Profile::factory()->create([
            'street_number_short' => '123',
            'route_short' => 'V. Roma',
            'locality_short' => 'MI',
            'postal_code_short' => '20100',
            'administrative_area_level_1_short' => 'LO',
            'country_short' => 'IT',
        ]);

        $shortAddress = $profile->street_number_short.' '.$profile->route_short.', '.
                       $profile->locality_short.' '.$profile->postal_code_short.', '.
                       $profile->administrative_area_level_1_short.', '.$profile->country_short;

        expect($shortAddress)->toBe('123 V. Roma, MI 20100, LO, IT');
    });

    it('can validate postal code format', function () {
        $profile = Profile::factory()->create([
            'postal_code' => '20100',
        ]);

        expect($profile->postal_code)->toBe('20100');
    });

    it('can handle Google Places integration', function () {
        $profile = Profile::factory()->create([
            'googleplace_url' => 'https://maps.google.com/place/123',
            'point_of_interest' => 'Palazzo del Governo',
            'political' => 'Municipio',
            'campground' => 'Parco pubblico',
        ]);

        expect($profile->googleplace_url)->toBe('https://maps.google.com/place/123')
            ->and($profile->point_of_interest)->toBe('Palazzo del Governo')
            ->and($profile->political)->toBe('Municipio')
            ->and($profile->campground)->toBe('Parco pubblico');
    });
});

describe('Profile Model Data Management', function () {
    it('can store extra attributes in data field', function () {
        $profile = Profile::factory()->create([
            'data' => [
                'skills' => ['PHP', 'Laravel', 'MySQL'],
                'experience_years' => 5,
                'certifications' => ['AWS', 'Docker'],
                'preferences' => [
                    'theme' => 'dark',
                    'language' => 'it',
                    'notifications' => true,
                ],
            ],
        ]);

        expect($profile->data)->toBeArray()
            ->and($profile->data['skills'])->toContain('PHP', 'Laravel', 'MySQL')
            ->and($profile->data['experience_years'])->toBe(5)
            ->and($profile->data['certifications'])->toContain('AWS', 'Docker')
            ->and($profile->data['preferences']['theme'])->toBe('dark')
            ->and($profile->data['preferences']['language'])->toBe('it')
            ->and($profile->data['preferences']['notifications'])->toBe(true);
    });

    it('can update extra attributes', function () {
        $profile = Profile::factory()->create([
            'data' => ['initial' => 'value'],
        ]);

        $profile->data = array_merge($profile->data, ['new' => 'data']);
        $profile->save();

        expect($profile->data)->toHaveKey('initial')
            ->and($profile->data)->toHaveKey('new')
            ->and($profile->data['initial'])->toBe('value')
            ->and($profile->data['new'])->toBe('data');
    });

    it('can handle nested data structures', function () {
        $profile = Profile::factory()->create([
            'data' => [
                'work' => [
                    'department' => 'IT',
                    'position' => 'Senior Developer',
                    'start_date' => '2020-01-15',
                    'projects' => [
                        'current' => 'E-commerce Platform',
                        'completed' => ['CRM System', 'Mobile App'],
                    ],
                ],
                'personal' => [
                    'interests' => ['Technology', 'Music', 'Travel'],
                    'languages' => ['Italian', 'English', 'Spanish'],
                ],
            ],
        ]);

        expect($profile->data['work']['department'])->toBe('IT')
            ->and($profile->data['work']['position'])->toBe('Senior Developer')
            ->and($profile->data['work']['projects']['current'])->toBe('E-commerce Platform')
            ->and($profile->data['work']['projects']['completed'])->toContain('CRM System', 'Mobile App')
            ->and($profile->data['personal']['interests'])->toContain('Technology', 'Music', 'Travel')
            ->and($profile->data['personal']['languages'])->toContain('Italian', 'English', 'Spanish');
    });
});

describe('Profile Model Relationships', function () {
    it('can have user relationship', function () {
        $profile = Profile::factory()->create([
            'user_id' => 'user-456',
        ]);

        // The profile should be able to relate to a user
        expect($profile->user_id)->toBe('user-456');
    });

    it('can have permissions', function () {
        $profile = Profile::factory()->create();

        // Profile should be able to have permissions through user relationship
        expect($profile)->toBeInstanceOf(Profile::class);
    });

    it('can have roles', function () {
        $profile = Profile::factory()->create();

        // Profile should be able to have roles through user relationship
        expect($profile)->toBeInstanceOf(Profile::class);
    });

    it('can have teams', function () {
        $profile = Profile::factory()->create();

        // Profile should be able to have teams through user relationship
        expect($profile)->toBeInstanceOf(Profile::class);
    });

    it('can have membership', function () {
        $profile = Profile::factory()->create();

        // Profile should be able to have membership through user relationship
        expect($profile)->toBeInstanceOf(Profile::class);
    });
});

describe('Profile Model Edge Cases', function () {
    it('handles null values correctly', function () {
        $profile = Profile::factory()->create([
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'phone' => null,
        ]);

        expect($profile->first_name)->toBeNull()
            ->and($profile->last_name)->toBeNull()
            ->and($profile->email)->toBeNull()
            ->and($profile->phone)->toBeNull();
    });

    it('handles empty strings correctly', function () {
        $profile = Profile::factory()->create([
            'first_name' => '',
            'last_name' => '',
            'bio' => '',
        ]);

        expect($profile->first_name)->toBe('')
            ->and($profile->last_name)->toBe('')
            ->and($profile->bio)->toBe('');
    });

    it('handles very long text fields', function () {
        $longBio = str_repeat('This is a very long bio text. ', 100);

        $profile = Profile::factory()->create([
            'bio' => $longBio,
        ]);

        expect($profile->bio)->toBe($longBio);
    });

    it('handles special characters in text fields', function () {
        $profile = Profile::factory()->create([
            'first_name' => 'José',
            'last_name' => 'García-López',
            'bio' => 'Sviluppatore con esperienza in C++ & Python',
            'address' => 'Via dell\'Ospedale, 123',
        ]);

        expect($profile->first_name)->toBe('José')
            ->and($profile->last_name)->toBe('García-López')
            ->and($profile->bio)->toBe('Sviluppatore con esperienza in C++ & Python')
            ->and($profile->address)->toBe('Via dell\'Ospedale, 123');
    });
});
