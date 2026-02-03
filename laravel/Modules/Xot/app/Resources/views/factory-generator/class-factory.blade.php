<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> 8b18e4bff (.)
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 73eab74 (.)
>>>>>>> d2b0a27 (.)
=======
>>>>>>> 300ef70 (.)
<<<<<<< HEAD
=======
>>>>>>> 285375c74 (.)
=======
>>>>>>> 8b18e4bff (.)
<?php

declare(strict_types=1);

<<<<<<< HEAD
<<<<<<< HEAD
/** @var \ReflectionClass $reflection */
/** @var array<string, string> $properties */

=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
?>
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> f1d4085 (.)
=======
>>>>>>> 73eab74 (.)
>>>>>>> d2b0a27 (.)
=======
>>>>>>> 300ef70 (.)
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
<<<<<<< HEAD
<<<<<<< HEAD
<?php if (array_key_exists('remember_token', $properties)): ?>
use Illuminate\Support\Str;
<?php endif; ?>
use <?= $reflection->getName(); ?>;

class <?= $reflection->getShortName(); ?>Factory extends Factory
{
    /**
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = <?= $reflection->getShortName(); ?>::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
<?php foreach ($properties as $name => $property): ?>
            '<?= $name ?>' => <?= $property ?>,
<?php endforeach; ?>
        ];
    }
=======
=======
>>>>>>> 5a14301c (.)
@isset($properties['remember_token'])
    use Illuminate\Support\Str;
@endisset
use {{ $reflection->getName() }};

class {{ $reflection->getShortName() }}Factory extends Factory
{
/**
* The name of the factory's corresponding model.
*
* @var string
*/
protected $model = {{ $reflection->getShortName() }}::class;

/**
* Define the model's default state.
*
* @return array
*/
public function definition(): array
{
return [
@foreach ($properties as $name => $property)
    '{{ $name }}' => {!! $property !!},
@endforeach
];
}
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 5a14301c (.)
}
>>>>>>> 48515e368 (.)
