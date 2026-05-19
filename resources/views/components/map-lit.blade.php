<div x-data="map-litProps" class="map-lit-container">
  <map-lit
    id="segnalazioni-map"
    data-url="{{ asset('data/tickets.json') }}"
    height="clamp(360px,58vh,560px)"
    style="height:clamp(360px,58vh,560px);display:block;width:100%"
    aria-label="{{ __('fixcity::segnalazione.map.image.alt') }}"
  ></map-lit>
</div>