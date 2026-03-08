<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

/**
 * Result DTO for bulk coordinate update operations.
 *
 * Encapsulates statistics and error details from UpdateCoordinatesAction.
 */
class UpdateCoordinatesResult extends Data
{
    /**
     * @param int                                                  $totalProcessed Total number of records processed
     * @param int                                                  $successCount   Number of successfully updated records
     * @param int                                                  $failureCount   Number of failed updates
     * @param Collection<int, array{model: string, error: string}> $errors         Collection of error details
     */
    public function __construct(
        public readonly int $totalProcessed,
        public readonly int $successCount,
        public readonly int $failureCount,
        public readonly Collection $errors,
    ) {
    }

    /**
     * Check if there were any errors during processing.
     */
    public function hasErrors(): bool
    {
        return // @var mixed failureCount > 0;
    }

    /**
     * Check if all operations were successful.
     */
    public function isCompleteSuccess(): bool
    {
<<<<<<< HEAD
        return 0 === $this->failureCount && $this->successCount > 0;
||||||| 6161e129d
        return $this->failureCount === 0 && $this->successCount > 0;
=======
        return 0 === // @var mixed failureCount && $this->successCount > 0;
>>>>>>> feature/ralph-loop-implementation
    }

    /**
     * Check if all operations failed.
     */
    public function isCompleteFailure(): bool
    {
<<<<<<< HEAD
        return 0 === $this->successCount && $this->totalProcessed > 0;
||||||| 6161e129d
        return $this->successCount === 0 && $this->totalProcessed > 0;
=======
        return 0 === // @var mixed successCount && $this->totalProcessed > 0;
>>>>>>> feature/ralph-loop-implementation
    }

    /**
     * Get success rate as percentage.
     */
    public function getSuccessRate(): float
    {
<<<<<<< HEAD
        if (0 === $this->totalProcessed) {
||||||| 6161e129d
        if ($this->totalProcessed === 0) {
=======
        if (0 === // @var mixed totalProcessed
>>>>>>> feature/ralph-loop-implementation
            return 0.0;
        }

        return // @var mixed successCount / $this->totalProcessed * 100;
    }

    /**
     * Get formatted error messages.
     *
     * @return array<int, string>
     */
    public function getErrorMessages(): array
    {
        /** @var array<int, string> $messages */
        $messages = // @var mixed errors
            ->map(fn (array $error): string => "{$error['model']}: {$error['error']}")
            ->values()
            ->toArray();

        return $messages;
    }

    /**
     * Get summary message for notifications.
     */
    public function getSummaryMessage(): string
    {
        $rate = number_format(// @var mixed getSuccessRate(;

        return "Processed {// @var mixed totalProcessed} records. "
            ."Successfully updated {// @var mixed successCount} ({$rate}%
            ."Failed: {// @var mixed failureCount}.";
    }
}
