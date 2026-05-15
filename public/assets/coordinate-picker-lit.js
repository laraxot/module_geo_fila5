var L=Object.defineProperty;var O=(e,t,n)=>t in e?L(e,t,{enumerable:!0,configurable:!0,writable:!0,value:n}):e[t]=n;var _=(e,t,n)=>O(e,typeof t!="symbol"?t+"":t,n);import{html as l,LitElement as M}from"lit";import{g as i,L as d,c as E,m as R,i as C}from"./map-picker-marker-config.js";function q(e){const t=e.labels||{},n=!!e.showSearch&&typeof e._toggleSearch=="function";return l`
        <div class="layer-controls-overlay">
            ${n?l`
                <button class="ctrl-btn" type="button"
                    @click=${()=>e._toggleSearch()}
                    aria-label="${t.search||"Cerca indirizzo"}"
                    title="${t.search||"Cerca indirizzo"}">
                    ${i("magnifying-glass")}
                    <span class="ctrl-fallback" aria-hidden="true">🔍</span>
                </button>
            `:""}
            <button class="ctrl-btn" type="button" @click=${()=>e._toggleFullscreen()} aria-label="${e.isFullscreen?t.close_fullscreen||"Chiudi":t.fullscreen||"Fullscreen"}" title="${e.isFullscreen?t.close_fullscreen||"Chiudi":t.fullscreen||"Fullscreen"}">
                ${e.isFullscreen?i("arrows-pointing-in"):i("arrows-pointing-out")}
                <span class="ctrl-fallback" aria-hidden="true">${e.isFullscreen?"⤢":"⛶"}</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>e._requestGeolocation()} ?disabled=${e.isLocating} aria-label="${t.use_location||"Mia posizione"}" title="${t.use_location||"Mia posizione"}">
                ${e.isLocating?l`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:i("map-pin")}
                <span class="ctrl-fallback" aria-hidden="true">◎</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>e._switchLayer()} aria-label="${t.switch_layer||"Cambia Layer"}" title="${t.switch_layer||"Cambia Layer"}">
                ${i("squares-2x2")}
                <span class="ctrl-fallback" aria-hidden="true">▦</span>
            </button>

            <button class="ctrl-btn" type="button" @click=${()=>e._zoomIn()} aria-label="${t.zoom_in||"Zoom In"}" title="${t.zoom_in||"Zoom In"}">
                ${i("plus")}
                <span class="ctrl-fallback" aria-hidden="true">+</span>
            </button>
            <button class="ctrl-btn" type="button" @click=${()=>e._zoomOut()} aria-label="${t.zoom_out||"Zoom Out"}" title="${t.zoom_out||"Zoom Out"}">
                ${i("minus")}
                <span class="ctrl-fallback" aria-hidden="true">−</span>
            </button>
        </div>
    `}function I(e){if(!e._map||!e._layers)return;const t=["street","humanitarian","satellite","topo"],r=(t.indexOf(e._currentLayer)+1)%t.length,a=t[r],o=e._layers[e._currentLayer];o&&e._map.removeLayer(o);const s=e._layers[a];s&&!s._map&&s.addTo(e._map),e._currentLayer=a,u(e,[0,120,300])}async function U(e){var r;const t=w(e),n=!e.isFullscreen;if(console.log("[map-controls] Toggling fullscreen - entering:",n,"container:",t?"found":"not found"),!t){console.error("[map-controls] Cannot toggle fullscreen: container not found");return}if(n)if(e._previousBodyOverflow=document.body.style.overflow||"",e._previousHtmlOverflow=document.documentElement.style.overflow||"",document.documentElement.classList.add("geo-map-fullscreen-active"),document.body.style.overflow="hidden",document.documentElement.style.overflow="hidden",console.log("[map-controls] Attempting to enter fullscreen..."),t.requestFullscreen&&!document.fullscreenElement)try{await t.requestFullscreen(),console.log("[map-controls] Successfully entered fullscreen")}catch(a){console.error("[map-controls] Failed to enter fullscreen:",a),h(e)}else console.log("[map-controls] Already in fullscreen or requestFullscreen not available");else{if(console.log("[map-controls] Exiting fullscreen..."),document.fullscreenElement&&document.exitFullscreen)try{await document.exitFullscreen(),console.log("[map-controls] Successfully exited fullscreen")}catch(a){console.error("[map-controls] Failed to exit fullscreen:",a)}else console.log("[map-controls] Not in fullscreen or exitFullscreen not available");h(e)}e.isFullscreen=n,(r=e.requestUpdate)==null||r.call(e),e.dispatchEvent(new CustomEvent("fullscreen-changed",{detail:{isFullscreen:e.isFullscreen},bubbles:!0,composed:!0})),u(e,[0,160,380,700])}function A(e){var r;const t=w(e),n=document.fullscreenElement===t;if(console.log("[map-controls] Syncing fullscreen state - container:",t?"found":"not found","active:",n,"ctx.isFullscreen:",e.isFullscreen),document.fullscreenElement&&!n){console.log("[map-controls] Different element is fullscreen, ignoring");return}e.isFullscreen!==n&&(console.log("[map-controls] Updating fullscreen state from",e.isFullscreen,"to",n),e.isFullscreen=n,(r=e.requestUpdate)==null||r.call(e)),n||h(e),u(e,[0,160,380])}function P(e){e._map&&(e._map.zoomIn(),u(e,[150]))}function T(e){e._map&&(e._map.zoomOut(),u(e,[150]))}function v(e,t={}){const{showLoading:n=!0}=t;if(!navigator.geolocation){console.error("[map-controls] Geolocation not supported by browser");return}if(e.isLocating){console.warn("[map-controls] Geolocation already in progress");return}if(e._geolocRequested&&!n){console.warn("[map-controls] Geolocation already requested, skipping duplicate request");return}e._geolocRequested=!0,console.log("[map-controls] Starting geolocation request..."),n&&(e.isLocating=!0,e.requestUpdate()),navigator.geolocation.getCurrentPosition(r=>{console.log("[map-controls] Geolocation success:",r.coords);const a=r.coords.latitude,o=r.coords.longitude;if(typeof e._handleMapInteraction=="function"?(console.log("[map-controls] Calling _handleMapInteraction with:",a,o),e._handleMapInteraction(a,o,"geolocation")):console.error("[map-controls] _handleMapInteraction method not found"),e.geolocated=!0,n&&(e.isLocating=!1,e.requestUpdate()),e._map){const s=Number.isFinite(e.zoom)?Math.max(e.zoom,14):15;console.log("[map-controls] Centering map on user location:",a,o,"zoom:",s),e._map.setView([a,o],s,{animate:!1}),e._isUserCentered=!0,u(e,[150])}else console.error("[map-controls] Map not available for centering")},r=>{console.error("[map-controls] Geolocation error:",r),e._geolocRequested=!1,n&&(e.isLocating=!1,e.requestUpdate()),e.geolocated=!1},{enableHighAccuracy:!0,timeout:1e4,maximumAge:3e5})}function w(e){var t,n,r;return((n=(t=e.renderRoot)==null?void 0:t.querySelector)==null?void 0:n.call(t,".map-container"))||((r=e.querySelector)==null?void 0:r.call(e,".map-container"))||null}function h(e){document.documentElement.classList.remove("geo-map-fullscreen-active"),document.body.style.overflow=e._previousBodyOverflow||"",document.documentElement.style.overflow=e._previousHtmlOverflow||""}function u(e,t=[0]){if(typeof e._refreshMapSize=="function"){e._refreshMapSize(t);return}t.forEach(n=>{setTimeout(()=>{var r;return(r=e._map)==null?void 0:r.invalidateSize()},n)})}const S=3,N=350,B="https://nominatim.openstreetmap.org/search";function Z(e){const t=e.labels||{},n=t.search_placeholder||"Cerca indirizzo...",r=Array.isArray(e.searchResults)?e.searchResults:[],a=!!(e.showSearchResults&&r.length>0);return l`
        <div class="search-box geo-address-search geo-search-expanded"
             @click="${o=>o.stopPropagation()}">
            <input
                type="text"
                class="map-picker-search-input"
                placeholder="${n}"
                aria-label="${n}"
                autocomplete="off"
                .value="${e.searchQuery||""}"
                @input="${o=>G(e,o.target.value)}"
                @keydown="${o=>Q(e,o)}"
            />
            <button
                class="ctrl-btn"
                type="button"
                aria-label="${t.search||"Cerca"}"
                title="${t.search||"Cerca"}"
                @click="${()=>f(e,{selectFirst:!0})}"
            >
                ${e.isSearching?l`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:i("magnifying-glass")}
                <span class="ctrl-fallback" aria-hidden="true">S</span>
            </button>
            <button
                class="ctrl-btn geo-search-close"
                type="button"
                aria-label="${t.close_search||"Chiudi ricerca"}"
                title="${t.close_search||"Chiudi ricerca"}"
                @click="${()=>k(e)}"
            >
                ${i("x-mark")}
                <span class="ctrl-fallback" aria-hidden="true">x</span>
            </button>

            ${a?l`
                <ul class="geo-address-search-results" role="listbox">
                    ${r.map(o=>l`
                        <li
                            role="option"
                            @click="${()=>z(e,o)}"
                            title="${o.display_name||""}"
                        >
                            ${o.display_name||`${o.lat}, ${o.lon}`}
                        </li>
                    `)}
                </ul>
            `:""}
        </div>
    `}function k(e){var t;e._searchOpen=!1,"_isSearchVisible"in e&&(e._isSearchVisible=!1),e.searchQuery="",e.searchResults=[],e.showSearchResults=!1,(t=e.requestUpdate)==null||t.call(e)}function G(e,t){var n;e.searchQuery=t||"",e.showSearchResults=!1,e._searchDebounce&&clearTimeout(e._searchDebounce),e.searchQuery.trim().length>=S?e._searchDebounce=setTimeout(()=>{f(e,{selectFirst:!1})},N):e.searchResults=[],(n=e.requestUpdate)==null||n.call(e)}function Q(e,t){if(t.key==="Escape"){k(e);return}t.key==="Enter"&&(t.preventDefault(),f(e,{selectFirst:!0}))}async function f(e,t={}){var r,a,o;const n=String(e.searchQuery||"").trim();if(n.length<S){e.searchResults=[],e.showSearchResults=!1,(r=e.requestUpdate)==null||r.call(e);return}e.isSearching=!0,(a=e.requestUpdate)==null||a.call(e);try{const s=await H(e,n);e.searchResults=Array.isArray(s)?s:[],e.showSearchResults=e.searchResults.length>0,t.selectFirst&&e.searchResults[0]&&z(e,e.searchResults[0])}catch(s){console.warn("[map-picker-search] Address search failed",s),e.searchResults=[],e.showSearchResults=!1}finally{e.isSearching=!1,(o=e.requestUpdate)==null||o.call(e)}}function z(e,t){var s;const n=Number.parseFloat(t.lat),r=Number.parseFloat(t.lon??t.lng);if(!Number.isFinite(n)||!Number.isFinite(r))return;const a=t.display_name||`${n}, ${r}`,o=j(t,n,r,a);e.searchQuery=a,e.searchResults=[],e.showSearchResults=!1,typeof e._handleSearchSelection=="function"?e._handleSearchSelection(t,n,r,o):typeof e._handleMapInteraction=="function"?e._handleMapInteraction(n,r,"search"):e._map&&e._map.setView([n,r],Math.max(e._map.getZoom(),16)),e.dispatchEvent(new CustomEvent("address-selected",{detail:{result:t,address:a,lat:n,lng:r,latitude:n,longitude:r,payload:o},bubbles:!0,composed:!0})),(s=e.requestUpdate)==null||s.call(e)}function j(e,t,n,r){const a=e&&typeof e.address=="object"&&e.address!==null?e.address:{},o=(...s)=>{for(const c of s)if(typeof c=="string"&&c.trim()!=="")return c;return null};return{lat:t,lng:n,latitude:t,longitude:n,address:r,display_name:(e==null?void 0:e.display_name)??r,provider:"nominatim",place_id:(e==null?void 0:e.place_id)??null,osm_type:(e==null?void 0:e.osm_type)??null,osm_id:(e==null?void 0:e.osm_id)??null,licence:(e==null?void 0:e.licence)??null,importance:typeof(e==null?void 0:e.importance)=="number"?e.importance:null,type:(e==null?void 0:e.type)??null,class:(e==null?void 0:e.class)??null,boundingbox:Array.isArray(e==null?void 0:e.boundingbox)?e.boundingbox:null,street:o(a.road,a.pedestrian,a.footway,a.path,a.residential,a.highway),street_number:o(a.house_number),zip:o(a.postcode),postcode:o(a.postcode),city:o(a.city,a.town,a.village,a.municipality,a.hamlet,a.county),suburb:o(a.suburb,a.neighbourhood,a.quarter,a.city_district),province:o(a.province,a.county,a.state_district),state:o(a.state,a.region),country:o(a.country),country_code:o(a.country_code),address_details:a,raw:e}}async function H(e,t){if(typeof e.searchAddress=="function")return e.searchAddress(t);const n=new URL(B);n.searchParams.set("format","json"),n.searchParams.set("addressdetails","1"),n.searchParams.set("limit","5"),n.searchParams.set("q",t);const r=await fetch(n.toString(),{headers:{"Accept-Language":document.documentElement.lang||"it"}});if(!r.ok)throw new Error(`HTTP ${r.status}`);return r.json()}function V(e){return{street:e.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19}),humanitarian:e.tileLayer("https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",{maxZoom:19}),satellite:e.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",{maxZoom:19}),topo:e.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}",{maxZoom:19})}}function D(e,t,n){[0,50,150,300,500,800,1200].forEach(r=>{setTimeout(()=>{if(e.offsetParent===null||!t)return;const a=t.getCenter(),o=t.getZoom();t.invalidateSize({animate:!1}),a&&t.setView(a,o,{animate:!1})},r)})}function p(e){e._map&&D(e,e._map)}function K(e){const{resizeObserver:t,mutationObserver:n}=Y(e,()=>p(e));e._resizeObserver=t,e._mutationObserver=n}function W(e){e._resizeObserver&&(e._resizeObserver.disconnect(),e._resizeObserver=null),e._mutationObserver&&(e._mutationObserver.disconnect(),e._mutationObserver=null)}function Y(e,t){const n=new ResizeObserver(t);n.observe(e);const r=new MutationObserver(()=>{e.offsetParent!==null&&t()});let a=e.parentElement;for(let o=0;o<20&&a;o++)r.observe(a,{attributes:!0,attributeFilter:["class","style","hidden"]}),a=a.parentElement;return{resizeObserver:n,mutationObserver:r}}function y(e){return!e||typeof e!="object"?{lat:null,lng:null}:{lat:e.lat??e.latitude??null,lng:e.lng??e.longitude??null}}function J(e,t){const n=Number.parseFloat(Number.parseFloat(e).toFixed(6)),r=Number.parseFloat(Number.parseFloat(t).toFixed(6));return!Number.isFinite(n)||!Number.isFinite(r)?null:{lat:n,lng:r}}function g(e,t,n,r="manual"){e._isProgrammaticUpdate=!0;const a=J(t,n);if(!a){e._isProgrammaticUpdate=!1;return}e.state={...e.state||{},lat:a.lat,lng:a.lng,latitude:a.lat,longitude:a.lng},e._shouldRecenterAfterResize=!0,e._updateMarker(a.lat,a.lng),e.dispatchEvent(new CustomEvent("coords-changed",{detail:{lat:a.lat,lng:a.lng,latitude:a.lat,longitude:a.lng,source:r},bubbles:!0,composed:!0})),window.setTimeout(()=>{e._isProgrammaticUpdate=!1},100)}function $(e,t,n){e._map&&(e._marker?e._marker.setLatLng([t,n]):(e._marker=d.marker([t,n],{draggable:!0,icon:E(d)}).addTo(e._map),e._marker.on("dragend",r=>{const a=r.target.getLatLng();g(e,a.lat,a.lng,"dragend")})))}function m(e){if(!e._map)return;const t=e._lat,n=e._lng;$(e,t,n),e._shouldRecenterAfterResize=!0,e._map.setView([t,n],Math.max(e._map.getZoom(),e.zoom)),p(e)}function b(e){const t=e.querySelector(".map-picker-leaflet-pane");if(!t||e._map)return;e._layers=e._layers??{},e._currentLayer=e._currentLayer??"street";const n=e._lat!=null&&e._lng!=null,r=n?e._lat:41.9028,a=n?e._lng:12.4964;e._map=d.map(t,{center:[r,a],zoom:e.zoom,zoomControl:!1,attributionControl:!1}),e._layers=V(d),e._layers.street.addTo(e._map),e._map.on("click",o=>g(e,o.latlng.lat,o.latlng.lng,"click")),n?m(e):window.setTimeout(()=>{e._lat==null&&e._lng==null&&v(e,{showLoading:!0})},300),p(e)}class F extends M{get _lat(){return y(this.state).lat}get _lng(){return y(this.state).lng}createRenderRoot(){return this}constructor(){super(),this.state=null,this.zoom=13,this.height="400px",this.isLocating=!1,this.isFullscreen=!1,this.geolocateWhenEmpty=!1,this.geolocated=!1,this.labels={},this.provider="osm",this.showSearch=!0,this.searchQuery="",this.searchResults=[],this.showSearchResults=!1,this.isSearching=!1,this._searchOpen=!1,this._isProgrammaticUpdate=!1,this._layers={},this._marker=null,this._map=null,this._lastMeasuredSize=null,this._debounceTimeout=null,this._boundRefreshMapSize=null,this._resizeObserver=null,this._mutationObserver=null,this._currentLayer="street"}render(){return this.labels,l`
            <style>
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${R}
                .map-container { min-height: 200px; }
                .map-container.is-fullscreen,
                .map-container:fullscreen { position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; border: none !important; border-radius: 0 !important; z-index: 999999 !important; }
                .map-container.is-fullscreen .map-picker-leaflet-pane,
                .map-container:fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
            </style>
            <div class="map-container ${this.isFullscreen?"is-fullscreen":""}" style="--map-height: ${this.height}">
                ${C([],()=>l`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
                ${this.showSearch&&this._searchOpen?Z(this):""}
                ${q(this)}
                <div class="loading-overlay ${this.isLocating?"active":""}">
                    <div class="spinner"></div>
                </div>
            </div>
        `}firstUpdated(){b(this),this._boundRefreshMapSize=()=>p(this),K(this),this._handleFullscreenChange=()=>{console.log("[coordinate-picker] Fullscreen change event detected"),A(this)},document.addEventListener("fullscreenchange",this._handleFullscreenChange),this._handleEscapeKey=t=>{if(t.key==="Escape"){if(this._searchOpen){this._searchOpen=!1,this.requestUpdate();return}this.isFullscreen&&this._toggleFullscreen()}},document.addEventListener("keydown",this._handleEscapeKey)}disconnectedCallback(){super.disconnectedCallback(),this._map&&(this._map.remove(),this._map=null),W(this),this._handleEscapeKey&&document.removeEventListener("keydown",this._handleEscapeKey),this._handleFullscreenChange&&document.removeEventListener("fullscreenchange",this._handleFullscreenChange)}updated(t){t.has("state")&&!this._isProgrammaticUpdate&&this._map&&this._lat!=null&&this._lng!=null&&m(this)}_switchLayer(){I(this)}_toggleFullscreen(){U(this)}_zoomIn(){P(this)}_zoomOut(){T(this)}_requestGeolocation(){v(this)}_handleMapInteraction(t,n,r){g(this,t,n,r)}_updateMarker(t,n){$(this,t,n)}_syncMarkerToProperties(){m(this)}_refreshMapSize(){p(this)}_initMap(){b(this)}_toggleSearch(){if(!this.showSearch){console.log("[coordinate-picker] Search toggle ignored: showSearch is false");return}const t=this._searchOpen;this._searchOpen=!this._searchOpen,console.log("[coordinate-picker] Search toggled from",t,"to",this._searchOpen),this.requestUpdate(),this._searchOpen&&this.updateComplete.then(()=>{const n=this.querySelector(".map-picker-search-input");n?(n.focus(),console.log("[coordinate-picker] Search input focused")):console.warn("[coordinate-picker] Search input not found for focus")})}_handleSearchSelection(t,n,r,a=null){var s,c;const o=a&&typeof a=="object"?a:{lat:n,lng:r,latitude:n,longitude:r,address:(t==null?void 0:t.display_name)||((s=this.state)==null?void 0:s.address)||"",provider:"nominatim",raw:t};this.state={...this.state||{},...o},this._handleMapInteraction(n,r,"search"),(c=this._map)==null||c.setView([n,r],Math.max(this._map.getZoom(),16))}setCoordinates(t,n,r="programmatic"){var a;this._handleMapInteraction(t,n,r),(a=this._map)==null||a.setView([t,n],Math.max(this._map.getZoom(),this.zoom))}}_(F,"properties",{state:{type:Object},zoom:{type:Number},height:{type:String},isLocating:{type:Boolean,state:!0},isFullscreen:{type:Boolean,state:!0},geolocateWhenEmpty:{type:Boolean,attribute:"geolocate-when-empty"},labels:{type:Object},provider:{type:String},showSearch:{type:Boolean,attribute:"show-search"},searchQuery:{type:String,state:!0},searchResults:{type:Array,state:!0},showSearchResults:{type:Boolean,state:!0},isSearching:{type:Boolean,state:!0},_isProgrammaticUpdate:{type:Boolean,state:!0},_searchOpen:{type:Boolean,state:!0}});typeof customElements<"u"&&!customElements.get("coordinate-picker-lit")&&customElements.define("coordinate-picker-lit",F);
