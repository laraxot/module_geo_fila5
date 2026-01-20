<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Ptv\Models\Profile;

/**
 * @property-read Profile|null $creator
 * @property-read Employee|null $employee
 * @property-read Project|null $project
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|EmployeeProject newModelQuery()
 * @method static Builder<static>|EmployeeProject newQuery()
 * @method static Builder<static>|EmployeeProject query()
 *
 * @mixin \Eloquent
 */
class EmployeeProject extends BasePivot
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'employee_id',
        'project_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
