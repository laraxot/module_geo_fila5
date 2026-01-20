<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Performance\Actions\GetHaDirittoMotivoAction;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\Performance;

// Mock class per testare l'action
class MockModelForAction extends Model
{
    public int $anno = 2025;

    public int $gg_ruolo = 250;

    public int $gg_presenza_anno = 220;

    public int $gg_assenza_anno = 30;

    public int $gg_propro = 200;

    public int $gg_posfun = 180;

    public function getAttributes(): array
    {
        return [
            'anno' => $this->anno,
            'gg_ruolo' => $this->gg_ruolo,
            'gg_presenza_anno' => $this->gg_presenza_anno,
            'gg_assenza_anno' => $this->gg_assenza_anno,
            'gg_propro' => $this->gg_propro,
            'gg_posfun' => $this->gg_posfun,
        ];
    }
}

beforeEach(function () {
    $this->action = new GetHaDirittoMotivoAction;
    $this->action->year = 2025;

    $this->model = new MockModelForAction;
});

describe('GetHaDirittoMotivoAction Basic Functionality', function () {
    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(GetHaDirittoMotivoAction::class);
    });

    it('has year property set', function () {
        expect($this->action->year)->toBe(2025);
    });

    it('can execute with valid model data', function () {
        $result = $this->action->execute($this->model);

        expect($result)->toBeBool();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Criteri di Esclusione', function () {
    it('returns false when anno is different from year', function () {
        $this->model->anno = 2024;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when anno is null', function () {
        $this->model->anno = null;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when anno is zero', function () {
        $this->model->anno = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when anno is negative', function () {
        $this->model->anno = -1;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when anno is not numeric', function () {
        $this->model->anno = 'invalid';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Validazione Giorni Ruolo', function () {
    it('returns false when gg_ruolo is zero', function () {
        $this->model->gg_ruolo = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_ruolo is negative', function () {
        $this->model->gg_ruolo = -10;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_ruolo is null', function () {
        $this->model->gg_ruolo = null;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_ruolo is not numeric', function () {
        $this->model->gg_ruolo = 'invalid';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns true when gg_ruolo is positive', function () {
        $this->model->gg_ruolo = 100;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Validazione Giorni Presenza', function () {
    it('returns false when gg_presenza_anno is zero', function () {
        $this->model->gg_presenza_anno = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_presenza_anno is negative', function () {
        $this->model->gg_presenza_anno = -5;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_presenza_anno is null', function () {
        $this->model->gg_presenza_anno = null;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_presenza_anno is not numeric', function () {
        $this->model->gg_presenza_anno = 'invalid';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns true when gg_presenza_anno is positive', function () {
        $this->model->gg_presenza_anno = 150;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Validazione Giorni Assenza', function () {
    it('returns false when gg_assenza_anno is negative', function () {
        $this->model->gg_assenza_anno = -1;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns true when gg_assenza_anno is zero', function () {
        $this->model->gg_assenza_anno = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns true when gg_assenza_anno is positive', function () {
        $this->model->gg_assenza_anno = 20;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns false when gg_assenza_anno is null', function () {
        $this->model->gg_assenza_anno = null;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_assenza_anno is not numeric', function () {
        $this->model->gg_assenza_anno = 'invalid';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Validazione Giorni Propro', function () {
    it('returns false when gg_propro is negative', function () {
        $this->model->gg_propro = -5;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns true when gg_propro is zero', function () {
        $this->model->gg_propro = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns true when gg_propro is positive', function () {
        $this->model->gg_propro = 100;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns false when gg_propro is null', function () {
        $this->model->gg_propro = null;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_propro is not numeric', function () {
        $this->model->gg_propro = 'invalid';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Validazione Giorni Posfun', function () {
    it('returns false when gg_posfun is negative', function () {
        $this->model->gg_posfun = -3;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns true when gg_posfun is zero', function () {
        $this->model->gg_posfun = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns true when gg_posfun is positive', function () {
        $this->model->gg_posfun = 80;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns false when gg_posfun is null', function () {
        $this->model->gg_posfun = null;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_posfun is not numeric', function () {
        $this->model->gg_posfun = 'invalid';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Combinazioni Valide', function () {
    it('returns true with all valid positive values', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 250;
        $this->model->gg_presenza_anno = 220;
        $this->model->gg_assenza_anno = 30;
        $this->model->gg_propro = 200;
        $this->model->gg_posfun = 180;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns true with zero values for optional fields', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 250;
        $this->model->gg_presenza_anno = 220;
        $this->model->gg_assenza_anno = 0;
        $this->model->gg_propro = 0;
        $this->model->gg_posfun = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('returns true with minimum valid values', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 1;
        $this->model->gg_presenza_anno = 1;
        $this->model->gg_assenza_anno = 0;
        $this->model->gg_propro = 0;
        $this->model->gg_posfun = 0;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });
});

describe('GetHaDirittoMotivoAction Business Logic - Combinazioni Non Valide', function () {
    it('returns false when anno is wrong year', function () {
        $this->model->anno = 2024;
        $this->model->gg_ruolo = 250;
        $this->model->gg_presenza_anno = 220;
        $this->model->gg_assenza_anno = 30;
        $this->model->gg_propro = 200;
        $this->model->gg_posfun = 180;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_ruolo is zero', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 0;
        $this->model->gg_presenza_anno = 220;
        $this->model->gg_assenza_anno = 30;
        $this->model->gg_propro = 200;
        $this->model->gg_posfun = 180;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when gg_presenza_anno is zero', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 250;
        $this->model->gg_presenza_anno = 0;
        $this->model->gg_assenza_anno = 30;
        $this->model->gg_propro = 200;
        $this->model->gg_posfun = 180;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });

    it('returns false when multiple fields are invalid', function () {
        $this->model->anno = 2024;
        $this->model->gg_ruolo = 0;
        $this->model->gg_presenza_anno = 0;
        $this->model->gg_assenza_anno = -5;
        $this->model->gg_propro = -10;
        $this->model->gg_posfun = -3;

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });
});

describe('GetHaDirittoMotivoAction Edge Cases', function () {
    it('handles very large numbers correctly', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 999999;
        $this->model->gg_presenza_anno = 999999;
        $this->model->gg_assenza_anno = 999999;
        $this->model->gg_propro = 999999;
        $this->model->gg_posfun = 999999;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('handles decimal numbers correctly', function () {
        $this->model->anno = 2025;
        $this->model->gg_ruolo = 250.5;
        $this->model->gg_presenza_anno = 220.7;
        $this->model->gg_assenza_anno = 30.2;
        $this->model->gg_propro = 200.1;
        $this->model->gg_posfun = 180.9;

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('handles string representations of numbers', function () {
        $this->model->anno = '2025';
        $this->model->gg_ruolo = '250';
        $this->model->gg_presenza_anno = '220';
        $this->model->gg_assenza_anno = '30';
        $this->model->gg_propro = '200';
        $this->model->gg_posfun = '180';

        $result = $this->action->execute($this->model);

        expect($result)->toBeTrue();
    });

    it('handles empty strings as invalid', function () {
        $this->model->anno = '';
        $this->model->gg_ruolo = '';
        $this->model->gg_presenza_anno = '';
        $this->model->gg_assenza_anno = '';
        $this->model->gg_propro = '';
        $this->model->gg_posfun = '';

        $result = $this->action->execute($this->model);

        expect($result)->toBeFalse();
    });
});

describe('GetHaDirittoMotivoAction Performance', function () {
    it('executes quickly with valid data', function () {
        $startTime = microtime(true);

        for ($i = 0; $i < 1000; $i++) {
            $this->action->execute($this->model);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($executionTime)->toBeLessThan(1.0); // Dovrebbe essere molto veloce
    });

    it('executes quickly with invalid data', function () {
        $this->model->anno = 2024; // Invalid year

        $startTime = microtime(true);

        for ($i = 0; $i < 1000; $i++) {
            $this->action->execute($this->model);
        }

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($executionTime)->toBeLessThan(1.0); // Dovrebbe essere molto veloce
    });
});

describe('GetHaDirittoMotivoAction Integration', function () {
    it('works with Performance model', function () {
        $performance = new Performance;
        $performance->anno = 2025;
        $performance->gg_ruolo = 250;
        $performance->gg_presenza_anno = 220;
        $performance->gg_assenza_anno = 30;
        $performance->gg_propro = 200;
        $performance->gg_posfun = 180;

        $result = $this->action->execute($performance);

        expect($result)->toBeBool();
    });

    it('works with Individuale model', function () {
        $individuale = new Individuale;
        $individuale->anno = 2025;
        $individuale->gg_ruolo = 250;
        $individuale->gg_presenza_anno = 220;
        $individuale->gg_assenza_anno = 30;
        $individuale->gg_propro = 200;
        $individuale->gg_posfun = 180;

        $result = $this->action->execute($individuale);

        expect($result)->toBeBool();
    });

    it('maintains consistency across different model types', function () {
        $models = [
            new MockModelForAction,
            new Performance,
            new Individuale,
        ];

        foreach ($models as $model) {
            $model->anno = 2025;
            $model->gg_ruolo = 250;
            $model->gg_presenza_anno = 220;
            $model->gg_assenza_anno = 30;
            $model->gg_propro = 200;
            $model->gg_posfun = 180;

            $result = $this->action->execute($model);
            expect($result)->toBeTrue();
        }
    });
});
