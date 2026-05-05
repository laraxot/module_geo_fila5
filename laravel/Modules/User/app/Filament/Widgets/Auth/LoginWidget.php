<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * LoginWidget: widget login con form Filament e "vestito" demandato al template tema.
 * - Estende XotBaseWidget
 * - Usa solo componenti Filament importati
 * - Validazione e sicurezza integrate
 * - Facilmente estendibile (2FA, captcha, login social).
 *
 * VIETATO: ->label(), ->placeholder(), ->helperText(). Le traduzioni sono gestite
 * automaticamente da LangServiceProvider tramite i file in Modules/User/lang/.
 * Vedi .cursor/rules/no-filament-labels.mdc
 * Traduzioni: LangServiceProvider risolve automaticamente da user::login_widget
 * (lang/it/login_widget.php). MAI usare ->label(), ->placeholder(), ->helperText().
 */
class LoginWidget extends XotBaseWidget
{
    /**
     * @return array<string, Field>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'email' => TextInput::make('email')
                ->email()
                ->required()
                ->autofocus(),
            'password' => TextInput::make('password')
                ->password()
                ->revealable()
                ->required(),
            'remember' => Checkbox::make('remember'),
        ];
    }

    public function login(): void
    {
        // try {
        /** @var array<string, mixed> $data */
        $data = $this->form->getState();

        $credentials = [
            'email' => is_string($data['email'] ?? null) ? $data['email'] : '',
            'password' => is_string($data['password'] ?? null) ? $data['password'] : '',
        ];

        $remember = isset($data['remember']) && true === $data['remember'];

        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();
            redirect()->intended('/');
        }

        $this->addError('data.email', __('user::login.actions.login.error'));
        // } catch (ValidationException $e) {
        // dddx([
        //    'credentials' => $credentials,
        //    'remember' => $remember,
        //    'e' => $e,
        // ]);
        // La validazione Filament gestisce automaticamente gli errori
        // throw $e;
        // }
    }

    /**
     * Invocato dal form della view (wire:submit.prevent="save"); delega a login().
     */
    public function save(): void
    {
        $this->login();
    }
}
