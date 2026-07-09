import{l as e,n as t}from"./leaflet-src-DYl4HaFB.js";function n(n){let r=n.labels||{};return e`
        <div class="layer-controls-overlay">
            ${typeof n._toggleSearch==`function`?e`
                <button class="ctrl-btn" type="button"
                    @click=${()=>n._toggleSearch()}
                    aria-label="${r.search||`Cerca indirizzo`}"
                    title="${r.search||`Cerca indirizzo`}">
                    ${t(`magnifying-glass`)}
                    <span class="ctrl-fallback" aria-hidden="true">🔍</span>
                </button>
            `:``}
            <button class="ctrl-btn" type="button" @click=${()=>n._toggleFullscreen()} aria-label="${n.isFullscreen?r.close_fullscreen||`Chiudi`:r.fullscreen||`Fullscreen`}" title="${n.isFullscreen?r.close_fullscreen||`Chiudi`:r.fullscreen||`Fullscreen`}">
                ${n.isFullscreen?t(`arrows-pointing-in`):t(`arrows-pointing-out`)}
                <span class="ctrl-fallback" aria-hidden="true">${n.isFullscreen?`⤢`:`⛶`}</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>n._requestGeolocation()} ?disabled=${n.isLocating} aria-label="${r.use_location||`Mia posizione`}" title="${r.use_location||`Mia posizione`}">
                ${n.isLocating?e`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:t(`map-pin`)}
                <span class="ctrl-fallback" aria-hidden="true">◎</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>n._switchLayer()} aria-label="${r.switch_layer||`Cambia Layer`}" title="${r.switch_layer||`Cambia Layer`}">
                ${t(`squares-2x2`)}
                <span class="ctrl-fallback" aria-hidden="true">▦</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>n._zoomIn()} aria-label="${r.zoom_in||`Zoom In`}" title="${r.zoom_in||`Zoom In`}">
                ${t(`plus`)}
                <span class="ctrl-fallback" aria-hidden="true">+</span>
            </button>
            <button class="ctrl-btn" type="button" @click=${()=>n._zoomOut()} aria-label="${r.zoom_out||`Zoom Out`}" title="${r.zoom_out||`Zoom Out`}">
                ${t(`minus`)}
                <span class="ctrl-fallback" aria-hidden="true">−</span>
            </button>
        </div>
    `}function r(e){if(!e._map||!e._layers)return;let t=[`street`,`humanitarian`,`satellite`,`topo`],n=t[(t.indexOf(e._currentLayer)+1)%t.length],r=e._layers[e._currentLayer];r&&e._map.removeLayer(r);let i=e._layers[n];i&&!i._map&&i.addTo(e._map),e._currentLayer=n,u(e,[0,120,300])}async function i(e){let t=c(e),n=!e.isFullscreen;n?(e._previousBodyOverflow=document.body.style.overflow||``,e._previousHtmlOverflow=document.documentElement.style.overflow||``,document.documentElement.classList.add(`geo-map-fullscreen-active`),document.body.style.overflow=`hidden`,document.documentElement.style.overflow=`hidden`,t?.requestFullscreen&&!document.fullscreenElement&&await t.requestFullscreen().catch(()=>void 0)):(document.fullscreenElement&&document.exitFullscreen&&await document.exitFullscreen().catch(()=>void 0),l(e)),e.isFullscreen=n,e.requestUpdate?.(),e.dispatchEvent(new CustomEvent(`fullscreen-changed`,{detail:{isFullscreen:e.isFullscreen},bubbles:!0,composed:!0})),u(e,[0,160,380,700])}function a(e){e._map&&(e._map.zoomIn(),u(e,[150]))}function o(e){e._map&&(e._map.zoomOut(),u(e,[150]))}function s(e,t={}){let{showLoading:n=!0}=t;!navigator.geolocation||e.isLocating||(n&&(e.isLocating=!0,e.requestUpdate()),navigator.geolocation.getCurrentPosition(t=>{let r=t.coords.latitude,i=t.coords.longitude;typeof e._handleMapInteraction==`function`&&e._handleMapInteraction(r,i,`geolocation`),n&&(e.isLocating=!1,e.requestUpdate()),e._map&&(e._map.setView([r,i],12,{animate:!1}),e._isUserCentered=!0,u(e,[150]))},()=>{n&&(e.isLocating=!1,e.requestUpdate()),e.geolocated=!1},{enableHighAccuracy:!0,timeout:5e3}))}function c(e){return e.renderRoot?.querySelector?.(`.map-container`)||e.querySelector?.(`.map-container`)||null}function l(e){document.documentElement.classList.remove(`geo-map-fullscreen-active`),document.body.style.overflow=e._previousBodyOverflow||``,document.documentElement.style.overflow=e._previousHtmlOverflow||``}function u(e,t=[0]){if(typeof e._refreshMapSize==`function`){e._refreshMapSize(t);return}t.forEach(t=>{setTimeout(()=>e._map?.invalidateSize(),t)})}var d=3,f=350,p=`https://nominatim.openstreetmap.org/search`;function m(n){let r=n.labels||{},i=r.search_placeholder||`Cerca indirizzo...`,a=Array.isArray(n.searchResults)?n.searchResults:[],o=!!(n.showSearchResults&&a.length>0);return e`
        <div class="search-box geo-address-search geo-search-expanded"
             @click="${e=>e.stopPropagation()}">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${i}"
                aria-label="${i}"
                autocomplete="off"
                .value="${n.searchQuery||``}"
                @input="${e=>g(n,e.target.value)}"
                @keydown="${e=>_(n,e)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${r.search||`Cerca`}"
                title="${r.search||`Cerca`}"
                @click="${()=>v(n,{selectFirst:!0})}"
            >
                ${n.isSearching?e`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:t(`magnifying-glass`)}
                <span class="ctrl-fallback" aria-hidden="true">&#x2715;</span>
            </button>
            <button
                class="ctrl-btn geo-search-close"
                type="button"
                aria-label="Chiudi ricerca"
                title="Chiudi ricerca"
                @click="${()=>h(n)}"
            >
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="18" height="18" style="display:block;margin:auto;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                <span class="ctrl-fallback" aria-hidden="true">&#x2715;</span>
            </button>

            ${o?e`
                <ul class="geo-address-search-results" role="listbox">
                    ${a.map(t=>e`
                        <li
                            role="option"
                            @click="${()=>y(n,t)}"
                            title="${t.display_name||``}"
                        >
                            ${t.display_name||`${t.lat}, ${t.lon}`}
                        </li>
                    `)}
                </ul>
            `:``}
        </div>