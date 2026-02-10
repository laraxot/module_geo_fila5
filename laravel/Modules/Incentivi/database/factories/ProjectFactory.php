<?php

declare(strict_types=1);

namespace Modules\Incentivi\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Enums\ProjectStatus;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->sentence(3), // "Lorem ipsum dolor"
            'tipo' => fake()->randomElement(['Lavori', 'Servizi', 'Misti']),
            'stato' => ProjectStatus::Compilazione->value,
            'data_aggiudicazione' => fake()->date(),
            'data_inizio_esecuzione' => fake()->date(),
            'data_fine_esecuzione' => fake()->date(),
            'ente_finanziatore' => fake()->company(),
            'oggetto' => fake()->sentence(6),
            'determina' => (string) fake()->numberBetween(1000, 9999),
            'percentuale_fondo' => fake()->randomFloat(2, 0, 100),
            'importo_totale' => fake()->randomFloat(2, 1000, 100000),
            'importo_effettivo_fondo' => fake()->randomFloat(2, 0, 50000),
            'componente_incentivante' => fake()->randomFloat(2, 0, 50000),
            'componente_innovazione' => fake()->randomFloat(2, 0, 50000),
            'settore' => fake()->word(),
            'rup' => (string) fake()->numberBetween(1, 9999),
            'dec' => (string) fake()->numberBetween(1, 9999),
            'ditta_nome' => fake()->company(),
            'ditta_sede' => fake()->address(),
            'ditta_partitaiva' => fake()->numerify('###########'),
            'ditta_oneri_sicurezza' => fake()->randomFloat(2, 0, 10000),
            'ditta_trattativa' => fake()->word(),
            'department_id' => null,
        ];
    }
}
