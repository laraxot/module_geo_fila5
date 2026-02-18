<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Components;

use Filament\Forms\Components\Component;
use Illuminate\Contracts\View\View;

/**
 * Componente per indicatore visivo di progresso form.
 * 
 * Fornisce feedback visivo immediato sullo stato delle operazioni
 * con colori contestuali e animazioni appropriate.
 */
class ProgressIndicator extends Component
{
    public string $step;
    public string $status; // 'loading', 'validating', 'completed', 'error'
    public string $message;
    public bool $showIcon;

    public function __construct(
        string $step,
        string $status = 'loading',
        string $message = '',
        bool $showIcon = true
    ) {
        $this->step = $step;
        $this->status = $status;
        $this->message = $message;
        $this->showIcon = $showIcon;
    }

    /**
     * Determina il colore di sfondo basato sullo stato.
     */
    protected function getBackgroundColor(): string
    {
        return match($this->status) {
            'loading' => 'bg-blue-100 dark:bg-blue-900/20',
            'validating' => 'bg-yellow-100 dark:bg-yellow-900/20',
            'completed' => 'bg-green-100 dark:bg-green-900/20',
            'error' => 'bg-red-100 dark:bg-red-900/20',
            default => 'bg-gray-100 dark:bg-gray-800',
        };
    }

    /**
     * Determina il colore del testo.
     */
    protected function getTextColor(): string
    {
        return match($this->status) {
            'loading' => 'text-blue-900 dark:text-blue-100',
            'validating' => 'text-yellow-900 dark:text-yellow-100',
            'completed' => 'text-green-900 dark:text-green-100',
            'error' => 'text-red-900 dark:text-red-100',
            default => 'text-gray-900 dark:text-gray-100',
        };
    }

    /**
     * Determina l'icona da visualizzare.
     */
    protected function getIcon(): string
    {
        return match($this->status) {
            'loading' => '⏳',
            'validating' => '🔍',
            'completed' => '✅',
            'error' => '❌',
            default => '📋',
        };
    }

    /**
     * Determina il testo di stato predefinito.
     */
    protected function getDefaultMessage(): string
    {
        return match($this->status) {
            'loading' => 'Caricamento dati...',
            'validating' => 'Verificando validità...',
            'completed' => 'Operazione completata con successo',
            'error' => 'Errore durante l\'operazione',
            default => 'In corso...',
        };
    }

    /**
     * Restituisce il messaggio completo.
     */
    protected function getFullMessage(): string
    {
        if (empty($this->message)) {
            return $this->getDefaultMessage();
        }
        
        return $this->message;
    }

    /**
     * Determina se mostrare animazione.
     */
    protected function shouldAnimate(): bool
    {
        return in_array($this->status, ['loading', 'validating'], true);
    }

    public function render(): View
    {
        $bgColor = $this->getBackgroundColor();
        $textColor = $this->getTextColor();
        $icon = $this->getIcon();
        $message = $this->getFullMessage();
        $animate = $this->shouldAnimate();

        return view('indennitaresponsabilita::filament.components.progress-indicator', [
            'step' => $this->step,
            'status' => $this->status,
            'bgColor' => $bgColor,
            'textColor' => $textColor,
            'icon' => $icon,
            'message' => $message,
            'showIcon' => $this->showIcon,
            'animate' => $animate,
        ]);
    }

    /**
     * Crea un'istanza per stato di caricamento.
     */
    public static function loading(string $step, string $message = ''): self
    {
        return new self($step, 'loading', $message);
    }

    /**
     * Crea un'istanza per stato di validazione.
     */
    public static function validating(string $step, string $message = ''): self
    {
        return new self($step, 'validating', $message);
    }

    /**
     * Crea un'istanza per stato completato.
     */
    public static function completed(string $step, string $message = ''): self
    {
        return new self($step, 'completed', $message);
    }

    /**
     * Crea un'istanza per stato di errore.
     */
    public static function error(string $step, string $message = ''): self
    {
        return new self($step, 'error', $message);
    }
}