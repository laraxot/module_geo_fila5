<?php

declare(strict_types=1);
<<<<<<< .merge_file_Uj0WCP
?>
@php
    /** @var \Illuminate\Database\Eloquent\Model|array<string, mixed> $record */
    $record = $getRecord();
=======

?>
@php
    /** @var \Illuminate\Database\Eloquent\Model|array $record */
    $record = $getRecord();

>>>>>>> .merge_file_8JY6AB
    $parts = [];

    $fullAddress = data_get($record, 'full_address');
    if (is_string($fullAddress) && $fullAddress !== '') {
<<<<<<< .merge_file_Uj0WCP
        $parts = array_values(array_filter(explode(' - ', $fullAddress)));
    } else {
        foreach (['address', 'route', 'street_number', 'postal_code', 'locality', 'city', 'province', 'country'] as $field) {
            $value = data_get($record, $field);
            if ((is_string($value) || is_numeric($value)) && $value !== '') {
=======
        $fullAddress = str_replace(' - ', '<br/>', $fullAddress);
        $parts[] = $fullAddress;
    } else {
        foreach (['address', 'city', 'province', 'postal_code', 'country'] as $field) {
            $value = data_get($record, $field);
            if (is_string($value) && $value !== '') {
>>>>>>> .merge_file_8JY6AB
                $parts[] = $value;
            }
        }
    }
@endphp

<div class="flex flex-col text-sm leading-tight">
<<<<<<< .merge_file_Uj0WCP
    @if ($parts === [])
        <span class="text-gray-400">-</span>
    @else
        @foreach ($parts as $part)
            <span>{{ $part }}</span>
        @endforeach
=======
    @if (count($parts) === 0)
        <br/><span class="text-gray-400">-</span>
    @else
        <span>{!! implode(', ', $parts) !!}</span>
>>>>>>> .merge_file_8JY6AB
    @endif
</div>
