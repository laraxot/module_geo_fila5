<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Modules\Xot\Filament\Pages\XotBasePage;

class UpdateDiriByCsv extends XotBasePage
{
    use InteractsWithForms;

    // public ?UploadedFile $csvFile = null;

    public ?array $data = [];

    protected string $view = 'indennitaresponsabilita::filament.pages.import-csv';

    protected static string $icon = 'heroicon-o-upload'; // Add icon here

    protected static bool $shouldRegisterNavigation = false;

    protected function getFormSchema(): array
    {
        return [
            FileUpload::make('csvFile')
                ->label(__('indennitaresponsabilita::messages.upload_csv'))
                ->acceptedFileTypes(['text/csv', 'text/plain'])
                ->required()
                ->columnSpan('full'),
        ];
    }

    public function form(Schema $schema): Schema
    {
        /** @var array<int, Component> $components */
        $components = $this->getFormSchema();

        return $schema->components($components)
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->data;
        // dddx($data);

        if (! is_array($data) || ! isset($data['csvFile'])) {
            throw new RuntimeException('CSV file not provided');
        }

        try {
            // $path = $this->handleFileUpload($data['csvFile']);
            /** @var string $csvFile */
            $csvFile = $data['csvFile'] ?? '';
            if ($csvFile === '') {
                throw new RuntimeException('CSV file path not provided');
            }
            $path = Storage::disk('public')->path($csvFile);
            $records = $this->processCSV($path);

            // Call the updateDiri action with the CSV data
            $this->updateDiri($records);

            Notification::make()
                ->title(__('indennitaresponsabilita::messages.csv_processed'))
                ->success()
                ->send();
        } catch (Throwable $e) {
            // Handle errors and notify
            Notification::make()
                ->title(__('indennitaresponsabilita::messages.error'))
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    protected function handleFileUpload(UploadedFile $file): string
    {
        $path = $file->storeAs('csv-uploads', $file->getClientOriginalName());
        if ($path === false) {
            throw new RuntimeException('Failed to store uploaded file');
        }

        return $path;
    }

    protected function processCSV(string $path): array
    {
        // $csv = Reader::createFromPath(Storage::path($path), 'r');
        // $csv = Reader::createFromPath($path, 'r');
        // $csv->setHeaderOffset(0); // Assuming first row contains headers

        $csv = Reader::createFromPath($path, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        // returns all the records as
        $records = $csv->getRecords(); // an Iterator object containing arrays
        // $records = $csv->getRecordsAsObject(MyDTO::class); // an Iterator object containing MyDTO objects
        $rows = iterator_to_array($records);

        return $rows;
    }

    public function updateDiri(array $data): void
    {
        $anno = 2024;
        $ente = 90;

        StabiDirigente::where('anno', $anno)
            ->where('matr', null)
            ->delete();

        $rows = [];

        // Example logic to process $data
        /** @var array<int, array<string, mixed>> $dataArray */
        $dataArray = $data;
        foreach ($dataArray as $record) {
            /** @var array<string, mixed> $record */
            // Process each record, example: map data to your models
            /** @var int|string|null $diri */
            $diri = $record['DIRI'] ?? null;
            if ($diri === null) {
                continue;
            }
            $where = [
                'anno' => $anno,
                'ente' => $ente,
                'matr' => $diri,
            ];

            $diris = StabiDirigente::where($where)->get();

            if ($diris->count() == 0) {
                $anag = Ana10f::firstWhere(Arr::only($where, ['ente', 'matr']));
                $rep = Rep00f::where(Arr::only($where, ['ente', 'matr']))
                    ->whereRaw('repann=""')
                    ->orderBy('rep2kd', 'desc')
                    ->first();

                if ($anag === null || $rep === null) {
                    continue; // Skip this record if anag or rep is not found
                }

                $data = $where;
                $data['nome_diri'] = $anag->conome.' '.$anag->nome;
                $data['stabi'] = $rep->repst1;
                $data['repar'] = $rep->repre1;
                StabiDirigente::create($data);
            }

            if ($diris->count() == 1) {
                $diri = $diris->first();
                if ($diri !== null) {
                    $diri->valutatore_id = $diri->id;
                    $diri->save();
                }
            }
            if ($diris->count() > 1) {
                dddx($diris);
            }

            $valutatore_id = $diris->where('valutatore_id', '!=', null)->first()?->id;
            if ($valutatore_id == null) {
                dddx('ERRORE');
            }
            /** @var int|string|null $matricola */
            $matricola = $record['Matricola'] ?? null;
            if ($matricola === null) {
                continue;
            }
            $where1 = [
                'anno' => $anno,
                'ente' => $ente,
                'matr' => $matricola,
            ];
            /** @var int $r */
            $r = IndennitaResponsabilita::where($where1)->update(['valutatore_id' => $valutatore_id]);
        }

        dddx($rows);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('submit')
                ->label(__('indennitaresponsabilita::messages.process_csv'))
                ->action('submit'),
        ];
    }
}
