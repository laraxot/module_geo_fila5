<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class IconMediaColumn extends IconColumn
{
    protected function setUp(): void
    {
        parent::setUp();
        $attachment = $this->getName();

        $this->default(function ($record) use ($attachment) {
            if (is_object($record) && method_exists($record, 'getFirstMedia')) {
                return $record->getFirstMedia($attachment);
            }

<<<<<<< HEAD
            return null;
=======
>>>>>>> ac0ea089 (.)
        })
            ->icon('heroicon-o-document-text')
            ->color(function ($record) use ($attachment): string {
                if (is_object($record) && method_exists($record, 'getFirstMedia')) {
                    return $record->getFirstMedia($attachment) ? 'success' : 'danger';
                }

                return 'danger';
            })
            ->tooltip(function ($record) use ($attachment): string {
                if (is_object($record) && method_exists($record, 'getFirstMedia')) {
                    $media = $record->getFirstMedia($attachment);
                    if (is_object($media) && isset($media->file_name) && is_string($media->file_name)) {
                        return $media->file_name;
                    }
                }

                return 'Documento non caricato';
            })
            ->action(function (array $arguments, Request $request) use ($attachment) {
                // Skip action if record is not available or doesn't have media capabilities
                if (! isset($arguments['record'])) {
<<<<<<< HEAD
                    return null;
=======
                    return;
>>>>>>> ac0ea089 (.)
                }

                $record = $arguments['record'];

                // Verify record is an object and has the required method
                if (! is_object($record) || ! method_exists($record, 'getFirstMedia')) {
<<<<<<< HEAD
                    return null;
=======
                    return;
>>>>>>> ac0ea089 (.)
                }

                /** @var Media|null $media */
                $media = $record->getFirstMedia($attachment);
                if ($media === null) {
<<<<<<< HEAD
                    return null;
=======
                    return;
>>>>>>> ac0ea089 (.)
                }

                return $media->toInlineResponse($request);

                // return $media->toResponse($request);
                // return Storage::disk($media->disk)->download($media->getPathRelativeToRoot());
                // return Storage::disk($media->disk)
                //    ->temporaryUploadUrl($media->getPathRelativeToRoot(),now()->addMinutes(5));
                // return response()->streamDownload(function () use ($media) {
                //    echo $media->get();
                // }, $media->file_name);
                // $headers=[
                //    'Content-Type' => $media->mime_type,
                //    'Content-Disposition' => 'inline; filename="' . basename($media->getPathRelativeToRoot()) . '"'
                // ];
                // $path = Storage::disk($media->disk)->path($media->getPathRelativeToRoot());
                // return response()->file($path, $headers);

                // return Storage::disk($media->disk)->response($media->getPathRelativeToRoot(), null, $headers);
            });
    }
}
