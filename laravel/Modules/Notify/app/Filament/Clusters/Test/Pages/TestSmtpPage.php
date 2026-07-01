<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Clusters\Test\Pages;

use Exception;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Notify\Datas\EmailData;
use Modules\Notify\Datas\SmtpData;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Xot\Filament\Pages\XotBasePage;
use Override;
use Webmozart\Assert\Assert;

/**
 * @property Schema $emailForm
 */
class TestSmtpPage extends XotBasePage
{
    /** @var array<string, mixed>|null */
    public ?array $emailData = [];

    public ?string $error_message = null;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-paper-airplane';

    protected string $view = 'notify::filament.pages.send-email';

    protected static ?string $cluster = Test::class;

    public function mount(): void
    {
        $this->fillForms();
    }

    public function emailForm(Schema $schema): Schema
    {
        $this->emailData['subject'] = 'test';

        return $schema->components([
            Section::make('SMTP')
                ->schema([
                    TextInput::make('host'),
                    // Valori di default disabilitati: usare Arr::get(config('mail'), 'mailers.smtp') se riattivati.
                    TextInput::make('port')->numeric(),
                    TextInput::make('username'),
                    TextInput::make('password'),
                    TextInput::make('encryption'),
                ])
                ->columns(3),
            Section::make('MAIL')
                ->schema([
                    TextInput::make('from_email')
                        // Valore di default disabilitato: usare XotData::make()->super_admin se riattivato.
                        ->email()
                        ->required(),
                    TextInput::make('from'),
                    TextInput::make('recipient')
                        ->email()
                        ->required(),
                    TextInput::make('subject')->default('test')->required(),
                    RichEditor::make('body_html')
                        ->default('test body')
                        ->required()
                        ->columnSpanFull(),
                ])
                ->columns(3),
        ])->statePath('emailData');
    }

    public function sendEmail(): void
    {
        $data = $this->emailForm->getState();
        $smtp = SmtpData::from($data);
        $emailData = EmailData::from($data);
        // dddx([
        //    'a' => $emailData,
        // 'b' => EmailData::make(),
        // ]);
        $smtp->send($emailData);

        Notification::make()
            ->success()
            ->title(__('Controlla il tuo client di posta'))
            ->send();
    }

    protected function getForms(): array
    {
        return ['emailForm'];
    }

    /** @return array<string, \Filament\Actions\Action> */
    protected function getEmailFormActions(): array
    {
        return [
            'submit' => Action::make('emailFormActions')->submit('emailFormActions'),
        ];
    }

    #[Override]
    protected function getUser(): Authenticatable&Model
    {
        $user = Filament::auth()->user();

        if (! ($user instanceof Model)) {
            throw new Exception(
                'L\'utente autenticato deve essere un modello Eloquent per consentire l\'aggiornamento della pagina del profilo.',
            );
        }

        return $user;
    }

    protected function fillForms(): void
    {
        Assert::isArray($mail_config = config('mail'));
        Assert::isArray($smtpConfig = Arr::get($mail_config, 'mailers.smtp'));

        // Convertiamo l'array generico in un array<string, mixed>
        $typedConfig = [];
        foreach ($smtpConfig as $key => $value) {
            if (is_string($key)) {
                $typedConfig[$key] = $value;
            }
        }

        $this->emailForm->fill($typedConfig);
    }
}
