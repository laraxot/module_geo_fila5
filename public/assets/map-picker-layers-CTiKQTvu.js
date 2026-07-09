import{_ as e,d as t,m as n,n as r,r as i}from"./leaflet-src-Bmf1u-60.js";function a(e){let t=e.labels||{};return n`
        <div class="layer-controls-overlay">
            ${typeof e._toggleSearch==`function`?n`
                <button class="ctrl-btn" type="button"
                    @click=${()=>e._toggleSearch()}
                    aria-label="${t.search||`Cerca indirizzo`}"
                    title="${t.search||`Cerca indirizzo`}">
                    ${r(`magnifying-glass`)}
                    <span class="ctrl-fallback" aria-hidden="true">🔍</span>
                </button>
            `:``}
            <button class="ctrl-btn" type="button" @click=${()=>e._toggleFullscreen()} aria-label="${e.isFullscreen?t.close_fullscreen||`Chiudi`:t.fullscreen||`Fullscreen`}" title="${e.isFullscreen?t.close_fullscreen||`Chiudi`:t.fullscreen||`Fullscreen`}">
                ${e.isFullscreen?r(`arrows-pointing-in`):r(`arrows-pointing-out`)}
                <span class="ctrl-fallback" aria-hidden="true">${e.isFullscreen?`⤢`:`⛶`}</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>e._requestGeolocation()} ?disabled=${e.isLocating} aria-label="${t.use_location||`Mia posizione`}" title="${t.use_location||`Mia posizione`}">
                ${e.isLocating?n`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:r(`map-pin`)}
                <span class="ctrl-fallback" aria-hidden="true">◎</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>e._switchLayer()} aria-label="${t.switch_layer||`Cambia Layer`}" title="${t.switch_layer||`Cambia Layer`}">
                ${r(`squares-2x2`)}
                <span class="ctrl-fallback" aria-hidden="true">▦</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>e._zoomIn()} aria-label="${t.zoom_in||`Zoom In`}" title="${t.zoom_in||`Zoom In`}">
                ${r(`plus`)}
                <span class="ctrl-fallback" aria-hidden="true">+</span>
            </button>
            <button class="ctrl-btn" type="button" @click=${()=>e._zoomOut()} aria-label="${t.zoom_out||`Zoom Out`}" title="${t.zoom_out||`Zoom Out`}">
                ${r(`minus`)}
                <span class="ctrl-fallback" aria-hidden="true">−</span>
            </button>
        </div>
    `}function o(e){if(!e._map||!e._layers)return;let t=[`street`,`humanitarian`,`satellite`,`topo`],n=t[(t.indexOf(e._currentLayer)+1)%t.length],r=e._layers[e._currentLayer];r&&e._map.removeLayer(r);let i=e._layers[n];i&&!i._map&&i.addTo(e._map),e._currentLayer=n,p(e,[0,120,300])}async function s(e){let t=d(e),n=!e.isFullscreen;n?(e._previousBodyOverflow=document.body.style.overflow||``,e._previousHtmlOverflow=document.documentElement.style.overflow||``,document.documentElement.classList.add(`geo-map-fullscreen-active`),document.body.style.overflow=`hidden`,document.documentElement.style.overflow=`hidden`,t?.requestFullscreen&&!document.fullscreenElement&&await t.requestFullscreen().catch(()=>void 0)):(document.fullscreenElement&&document.exitFullscreen&&await document.exitFullscreen().catch(()=>void 0),f(e)),e.isFullscreen=n,e.requestUpdate?.(),e.dispatchEvent(new CustomEvent(`fullscreen-changed`,{detail:{isFullscreen:e.isFullscreen},bubbles:!0,composed:!0})),p(e,[0,160,380,700])}function c(e){e._map&&(e._map.zoomIn(),p(e,[150]))}function l(e){e._map&&(e._map.zoomOut(),p(e,[150]))}function u(e,t={}){let{showLoading:n=!0}=t;!navigator.geolocation||e.isLocating||(n&&(e.isLocating=!0,e.requestUpdate()),navigator.geolocation.getCurrentPosition(t=>{let r=t.coords.latitude,i=t.coords.longitude;e._handleMapInteraction(r,i,`geolocation`),n&&(e.isLocating=!1,e.requestUpdate()),e._map&&(e._map.setView([r,i],Math.max(e._map.getZoom(),16)),p(e,[150]))},()=>{n&&(e.isLocating=!1,e.requestUpdate()),e.geolocated=!1},{enableHighAccuracy:!0,timeout:5e3}))}function d(e){return e.renderRoot?.querySelector?.(`.map-container`)||e.querySelector?.(`.map-container`)||null}function f(e){document.documentElement.classList.remove(`geo-map-fullscreen-active`),document.body.style.overflow=e._previousBodyOverflow||``,document.documentElement.style.overflow=e._previousHtmlOverflow||``}function p(e,t=[0]){if(typeof e._refreshMapSize==`function`){e._refreshMapSize(t);return}t.forEach(t=>{setTimeout(()=>e._map?.invalidateSize(),t)})}var m=e((()=>{t(),i()}));function h(e){let t=e.labels||{},i=t.search_placeholder||`Cerca indirizzo...`,a=Array.isArray(e.searchResults)?e.searchResults:[],o=!!(e.showSearchResults&&a.length>0);return n`
        <div class="search-box geo-address-search geo-search-expanded"
             @click="${e=>e.stopPropagation()}">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${i}"
                aria-label="${i}"
                autocomplete="off"
                .value="${e.searchQuery||``}"
                @input="${t=>_(e,t.target.value)}"
                @keydown="${t=>v(e,t)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${t.search||`Cerca`}"
                title="${t.search||`Cerca`}"
                @click="${()=>y(e,{selectFirst:!0})}"
            >
                ${e.isSearching?n`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:r(`magnifying-glass`)}
                <span class="ctrl-fallback" aria-hidden="true">&#x2715;</span>
            </button>
            <button
                class="ctrl-btn geo-search-close"
                type="button"
                aria-label="Chiudi ricerca"
                title="Chiudi ricerca"
                @click="${()=>g(e)}"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="display:block;margin:auto;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                <span class="ctrl-fallback" aria-hidden="true">&#x2715;</span>
            </button>

            ${o?n`
                <ul class="geo-address-search-results" role="listbox">
                    ${a.map(t=>n`
                        <li
                            role="option"
                            @click="${()=>b(e,t)}"
                            title="${t.display_name||``}"
                        >
                            ${t.display_name||`${t.lat}, ${t.lon}`}
                        </li>
                    `)}
                </ul>
            `:``}
        </div>