<x-filament::widget>
    <x-filament::card>
        <div 
            x-data="{
                payload: {{ json_encode($this->getPayload()) }},
            }"
            class="w-full"
        >
            <geo-map-widget
                :payload="payload"
                style="height: 600px; display: block;"
            ></geo-map-widget>
        </div>
    </x-filament::card>
</x-filament::widget>
