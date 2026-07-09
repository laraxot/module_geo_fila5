// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
// Geo — frontend asset (claude-audit doc ratio).
const Ze=globalThis,bi=Ze.ShadowRoot&&(Ze.ShadyCSS===void 0||Ze.ShadyCSS.nativeShadow)&&"adoptedStyleSheets"in Document.prototype&&"replace"in CSSStyleSheet.prototype,Li=Symbol(),Vn=new WeakMap;let no=class{constructor(r,a,u){if(this._$cssResult$=!0,u!==Li)throw Error("CSSResult is not constructable. Use `unsafeCSS` or `css` instead.");this.cssText=r,this.t=a}get styleSheet(){let r=this.o;const a=this.t;if(bi&&r===void 0){const u=a!==void 0&&a.length===1;u&&(r=Vn.get(a)),r===void 0&&((this.o=r=new CSSStyleSheet).replaceSync(this.cssText),u&&Vn.set(a,r))}return r}toString(){return this.cssText}};const Ds=_=>new no(typeof _=="string"?_:_+"",void 0,Li),$s=(_,...r)=>{const a=_.length===1?_[0]:r.reduce((u,c,m)=>u+(p=>{if(p._$cssResult$===!0)return p.cssText;if(typeof p=="number")return p;throw Error("Value passed to 'css' function must be a 'css' function result: "+p+". Use 'unsafeCSS' to pass non-literal values, but take care to ensure page security.")})(c)+_[m+1],_[0]);return new no(a,_,Li)},Hs=(_,r)=>{if(bi)_.adoptedStyleSheets=r.map(a=>a instanceof CSSStyleSheet?a:a.styleSheet);else for(const a of r){const u=document.createElement("style"),c=Ze.litNonce;c!==void 0&&u.setAttribute("nonce",c),u.textContent=a.cssText,_.appendChild(u)}},qn=bi?_=>_:_=>_ instanceof CSSStyleSheet?(r=>{let a="";for(const u of r.cssRules)a+=u.cssText;return Ds(a)})(_):_;const{is:Fs,defineProperty:Us,getOwnPropertyDescriptor:Ws,getOwnPropertyNames:Vs,getOwnPropertySymbols:qs,getPrototypeOf:Gs}=Object,Be=globalThis,Gn=Be.trustedTypes,js=Gn?Gn.emptyScript:"",Ks=Be.reactiveElementPolyfillSupport,he=(_,r)=>_,Pi={toAttribute(_,r){switch(r){case Boolean:_=_?js:null;break;case Object:case Array:_=_==null?_:JSON.stringify(_)}return _},fromAttribute(_,r){let a=_;switch(r){case Boolean:a=_!==null;break;case Number:a=_===null?null:Number(_);break;case Object:case Array:try{a=JSON.parse(_)}catch{a=null}}return a}},oo=(_,r)=>!Fs(_,r),jn={attribute:!0,type:String,converter:Pi,reflect:!1,useDefault:!1,hasChanged:oo};Symbol.metadata??=Symbol("metadata"),Be.litPropertyMetadata??=new WeakMap;let Ut=class extends HTMLElement{static addInitializer(r){this._$Ei(),(this.l??=[]).push(r)}static get observedAttributes(){return this.finalize(),this._$Eh&&[...this._$Eh.keys()]}static createProperty(r,a=jn){if(a.state&&(a.attribute=!1),this._$Ei(),this.prototype.hasOwnProperty(r)&&((a=Object.create(a)).wrapped=!0),this.elementProperties.set(r,a),!a.noAccessor){const u=Symbol(),c=this.getPropertyDescriptor(r,u,a);c!==void 0&&Us(this.prototype,r,c)}}static getPropertyDescriptor(r,a,u){const{get:c,set:m}=Ws(this.prototype,r)??{get(){return this[a]},set(p){this[a]=p}};return{get:c,set(p){const B=c?.call(this);m?.call(this,p),this.requestUpdate(r,B,u)},configurable:!0,enumerable:!0}}static getPropertyOptions(r){return this.elementProperties.get(r)??jn}static _$Ei(){if(this.hasOwnProperty(he("elementProperties")))return;const r=Gs(this);r.finalize(),r.l!==void 0&&(this.l=[...r.l]),this.elementProperties=new Map(r.elementProperties)}static finalize(){if(this.hasOwnProperty(he("finalized")))return;if(this.finalized=!0,this._$Ei(),this.hasOwnProperty(he("properties"))){const a=this.properties,u=[...Vs(a),...qs(a)];for(const c of u)this.createProperty(c,a[c])}const r=this[Symbol.metadata];if(r!==null){const a=litPropertyMetadata.get(r);if(a!==void 0)for(const[u,c]of a)this.elementProperties.set(u,c)}this._$Eh=new Map;for(const[a,u]of this.elementProperties){const c=this._$Eu(a,u);c!==void 0&&this._$Eh.set(c,a)}this.elementStyles=this.finalizeStyles(this.styles)}static finalizeStyles(r){const a=[];if(Array.isArray(r)){const u=new Set(r.flat(1/0).reverse());for(const c of u)a.unshift(qn(c))}else r!==void 0&&a.push(qn(r));return a}static _$Eu(r,a){const u=a.attribute;return u===!1?void 0:typeof u=="string"?u:typeof r=="string"?r.toLowerCase():void 0}constructor(){super(),this._$Ep=void 0,this.isUpdatePending=!1,this.hasUpdated=!1,this._$Em=null,this._$Ev()}_$Ev(){this._$ES=new Promise(r=>this.enableUpdating=r),this._$AL=new Map,this._$E_(),this.requestUpdate(),this.constructor.l?.forEach(r=>r(this))}addController(r){(this._$EO??=new Set).add(r),this.renderRoot!==void 0&&this.isConnected&&r.hostConnected?.()}removeController(r){this._$EO?.delete(r)}_$E_(){const r=new Map,a=this.constructor.elementProperties;for(const u of a.keys())this.hasOwnProperty(u)&&(r.set(u,this[u]),delete this[u]);r.size>0&&(this._$Ep=r)}createRenderRoot(){const r=this.shadowRoot??this.attachShadow(this.constructor.shadowRootOptions);return Hs(r,this.constructor.elementStyles),r}connectedCallback(){this.renderRoot??=this.createRenderRoot(),this.enableUpdating(!0),this._$EO?.forEach(r=>r.hostConnected?.())}enableUpdating(r){}disconnectedCallback(){this._$EO?.forEach(r=>r.hostDisconnected?.())}attributeChangedCallback(r,a,u){this._$AK(r,u)}_$ET(r,a){const u=this.constructor.elementProperties.get(r),c=this.constructor._$Eu(r,u);if(c!==void 0&&u.reflect===!0){const m=(u.converter?.toAttribute!==void 0?u.converter:Pi).toAttribute(a,u.type);this._$Em=r,m==null?this.removeAttribute(c):this.setAttribute(c,m),this._$Em=null}}_$AK(r,a){const u=this.constructor,c=u._$Eh.get(r);if(c!==void 0&&this._$Em!==c){const m=u.getPropertyOptions(c),p=typeof m.converter=="function"?{fromAttribute:m.converter}:m.converter?.fromAttribute!==void 0?m.converter:Pi;this._$Em=c;const B=p.fromAttribute(a,m.type);this[c]=B??this._$Ej?.get(c)??B,this._$Em=null}}requestUpdate(r,a,u,c=!1,m){if(r!==void 0){const p=this.constructor;if(c===!1&&(m=this[r]),u??=p.getPropertyOptions(r),!((u.hasChanged??oo)(m,a)||u.useDefault&&u.reflect&&m===this._$Ej?.get(r)&&!this.hasAttribute(p._$Eu(r,u))))return;this.C(r,a,u)}this.isUpdatePending===!1&&(this._$ES=this._$EP())}C(r,a,{useDefault:u,reflect:c,wrapped:m},p){u&&!(this._$Ej??=new Map).has(r)&&(this._$Ej.set(r,p??a??this[r]),m!==!0||p!==void 0)||(this._$AL.has(r)||(this.hasUpdated||u||(a=void 0),this._$AL.set(r,a)),c===!0&&this._$Em!==r&&(this._$Eq??=new Set).add(r))}async _$EP(){this.isUpdatePending=!0;try{await this._$ES}catch(a){Promise.reject(a)}const r=this.scheduleUpdate();return r!=null&&await r,!this.isUpdatePending}scheduleUpdate(){return this.performUpdate()}performUpdate(){if(!this.isUpdatePending)return;if(!this.hasUpdated){if(this.renderRoot??=this.createRenderRoot(),this._$Ep){for(const[c,m]of this._$Ep)this[c]=m;this._$Ep=void 0}const u=this.constructor.elementProperties;if(u.size>0)for(const[c,m]of u){const{wrapped:p}=m,B=this[c];p!==!0||this._$AL.has(c)||B===void 0||this.C(c,void 0,m,B)}}let r=!1;const a=this._$AL;try{r=this.shouldUpdate(a),r?(this.willUpdate(a),this._$EO?.forEach(u=>u.hostUpdate?.()),this.update(a)):this._$EM()}catch(u){throw r=!1,this._$EM(),u}r&&this._$AE(a)}willUpdate(r){}_$AE(r){this._$EO?.forEach(a=>a.hostUpdated?.()),this.hasUpdated||(this.hasUpdated=!0,this.firstUpdated(r)),this.updated(r)}_$EM(){this._$AL=new Map,this.isUpdatePending=!1}get updateComplete(){return this.getUpdateComplete()}getUpdateComplete(){return this._$ES}shouldUpdate(r){return!0}update(r){this._$Eq&&=this._$Eq.forEach(a=>this._$ET(a,this[a])),this._$EM()}updated(r){}firstUpdated(r){}};Ut.elementStyles=[],Ut.shadowRootOptions={mode:"open"},Ut[he("elementProperties")]=new Map,Ut[he("finalized")]=new Map,Ks?.({ReactiveElement:Ut}),(Be.reactiveElementVersions??=[]).push("2.1.2");const Ti=globalThis,Kn=_=>_,Ie=Ti.trustedTypes,Yn=Ie?Ie.createPolicy("lit-html",{createHTML:_=>_}):void 0,so="$lit$",Pt=`lit$${Math.random().toFixed(9).slice(2)}$`,ro="?"+Pt,Ys=`<${ro}>`,Et=document,ue=()=>Et.createComment(""),ce=_=>_===null||typeof _!="object"&&typeof _!="function",Mi=Array.isArray,Js=_=>Mi(_)||typeof _?.[Symbol.iterator]=="function",xi=`[ 	
\f\r]`,re=/<(?:(!--|\/[^a-zA-Z])|(\/?[a-zA-Z][^>\s]*)|(\/?$))/g,Jn=/-->/g,Xn=/>/g,Ct=RegExp(`>|${xi}(?:([^\\s"'>=/]+)(${xi}*=${xi}*(?:[^ 	
    :host {
        display: block;
        width: 100%;
        --mp-z-index: 10;
        --mp-overlay-z-index: 1000;
        --mp-fullscreen-z-index: 999999;
    }

    .map-container {
        position: relative;
        width: 100%;
        height: var(--map-height, 400px);
        border-radius: 0.5rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
        background: #f3f4f6;
        z-index: var(--mp-z-index);
    }

    .map-container.is-fullscreen {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        width: 100vw !important;
        height: 100vh !important;
        z-index: var(--mp-fullscreen-z-index) !important;
        border-radius: 0 !important;
    }

    .map-picker-leaflet-pane {
        width: 100%;
        height: 100%;
        z-index: 1;
        background: #e5e7eb;
        opacity: 1;
    }

    .layer-controls-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: var(--mp-overlay-z-index);
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .ctrl-btn {
        width: 2.75rem;
        height: 2.75rem;
        background: #ffffff;
        border: 1px solid #94a3b8;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #17324d;
        box-shadow: 0 8px 18px rgba(23, 50, 77, 0.22);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        padding: 0;
        opacity: 1;
    }

    .ctrl-btn:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: #2563eb;
    }

    .ctrl-btn svg {
        width: 1.5rem;
        height: 1.5rem;
    }

    .search-box {
        position: absolute;
        top: 1rem;
        right: 1rem;
        z-index: var(--mp-overlay-z-index);
        display: flex;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.9);
        padding: 0.5rem;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(8px);
        max-width: 300px;
    }

    .search-box input {
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
        outline: none;
    }

    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .loading-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    .spinner {
        width: 2.5rem;
        height: 2.5rem;
        border: 4px solid #e5e7eb;
        border-top-color: #2563eb;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .leaflet-container {
        font-family: inherit;
    }

    .map-picker-marker {
        display: block;
        width: 44px;
        height: 56px;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }

    .map-picker-marker svg {
        width: 100%;
        height: 100%;
        display: block;
    }
`,Ft={zoomIn:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>`,zoomOut:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/></svg>`,fullscreen:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/></svg>`,fullscreenExit:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14h6v6M20 10h-6V4M14 10l7-7M10 14l-7 7"/></svg>`,locate:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/><line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/><line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/></svg>`,layer:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>`,crosshair:dt`<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/></svg>`},lo="/assets/geo/assets/map-picker-marker-fallback-Bu_stv-I.svg",uo={iconSize:[35,45],iconAnchor:[17,42],popupAnchor:[1,-32]},gr={iconUrl:lo,...uo,className:"map-picker-marker map-picker-marker--primary"},vr={iconUrl:lo,...uo,className:"map-picker-marker map-picker-marker--fallback"};function yr(_){return _.toString().trim().toLowerCase()==="fallback"?vr:gr}function wr(_,r="default"){return(r??"").toString().trim().toLowerCase()==="fallback"?_.icon(yr("fallback")):_.divIcon({className:"map-picker-marker map-picker-marker--custom",html:`<div class="map-picker-marker__inner" aria-hidden="true">
        <svg width="44" height="56" viewBox="0 0 44 56" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
            <defs>
                <linearGradient id="geoMarkerMain" x1="0%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#fb7185"/>
                    <stop offset="100%" stop-color="#e11d48"/>
                </linearGradient>
                <filter id="geoMarkerDrop" x="-35%" y="-25%" width="170%" height="190%">
                    <feDropShadow dx="0" dy="3" stdDeviation="2.2" flood-color="#111827" flood-opacity="0.35"/>
                </filter>
            </defs>
            <g filter="url(#geoMarkerDrop)">
                <path d="M22 2c-10.3 0-18.5 8.2-18.5 18.5 0 13.4 16.2 29 17.1 29.8.8.7 2 .7 2.8 0 .9-.8 17.1-16.4 17.1-29.8C40.5 10.2 32.3 2 22 2z" fill="url(#geoMarkerMain)"/>
                <circle cx="22" cy="20.5" r="9.2" fill="#fff"/>
                <circle cx="22" cy="20.5" r="5.2" fill="#9f1239"/>
                <rect x="17.4" y="16.2" width="9.2" height="2.2" rx="1.1" fill="#be123c" opacity="0.45"/>
            </g>
        </svg>
    </div>`,iconSize:[44,56],iconAnchor:[22,54],popupAnchor:[0,-42]})}class xr extends le{static properties={state:{type:Object},zoom:{type:Number},height:{type:String},isLocating:{type:Boolean,state:!0},isFullscreen:{type:Boolean,state:!0},geolocateWhenEmpty:{type:Boolean,attribute:"geolocate-when-empty"},labels:{type:Object},provider:{type:String},showSearch:{type:Boolean,attribute:"show-search"},_isProgrammaticUpdate:{type:Boolean,state:!0}};get _lat(){return this.state?.latitude??null}get _lng(){return this.state?.longitude??null}createRenderRoot(){return this}constructor(){super(),this.state=null,this.zoom=13,this.height="400px",this.isLocating=!1,this.isFullscreen=!1,this.geolocateWhenEmpty=!1,this.labels={},this.provider="osm",this.showSearch=!1,this._isProgrammaticUpdate=!1,this._layers={},this._currentLayer="street",this._geolocated=!1,this._boundRefreshMapSize=null}_handleMapInteraction(r,a,u="manual"){this._isProgrammaticUpdate=!0;const c=parseFloat(Number(r).toFixed(6)),m=parseFloat(Number(a).toFixed(6));if(!Number.isFinite(c)||!Number.isFinite(m)){this._isProgrammaticUpdate=!1;return}this.state?(this.state.latitude=c,this.state.longitude=m):this.state={latitude:c,longitude:m},this._updateMarker(c,m),this.dispatchEvent(new CustomEvent("coords-changed",{detail:{latitude:c,longitude:m,source:u},bubbles:!0,composed:!0})),setTimeout(()=>{this._isProgrammaticUpdate=!1},100)}_updateMarker(r,a){this._map&&(this._marker?this._marker.setLatLng([r,a]):(this._marker=Ht.marker([r,a],{draggable:!0,icon:wr(Ht)}).addTo(this._map),this._marker.on("dragend",u=>{const c=u.target.getLatLng();this._handleMapInteraction(c.lat,c.lng,"drag")})))}_initMap(){const r=this.querySelector(".map-picker-leaflet-pane");if(!r||this._map)return;const a=this._lat??41.9028,u=this._lng??12.4964;this._map=Ht.map(r,{center:[a,u],zoom:this.zoom,zoomControl:!1,attributionControl:!1}),this._layers.street=Ht.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19}).addTo(this._map),this._layers.satellite=Ht.tileLayer("https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",{maxZoom:19}),this._layers.topo=Ht.tileLayer("https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png",{maxZoom:17}),this._map.on("click",c=>this._handleMapInteraction(c.latlng.lat,c.latlng.lng,"click")),this._lat!=null&&this._lng!=null?this._syncMarkerToProperties():this.geolocateWhenEmpty&&!this._geolocated&&this._requestGeolocation(),this._refreshMapSize()}_refreshMapSize=()=>{this._map&&[0,80,180,350,700,1200].forEach(r=>{setTimeout(()=>{const u=this.querySelector(".map-picker-leaflet-pane")?.getBoundingClientRect();!u||u.width===0||u.height===0||(this._map.invalidateSize({animate:!1,pan:!1}),this._lat!=null&&this._lng!=null&&(this._updateMarker(this._lat,this._lng),this._map.setView([this._lat,this._lng],Math.max(this._map.getZoom(),this.zoom),{animate:!1})))},r)})};_syncMarkerToProperties(){if(!this._map)return;const r=this._lat,a=this._lng;r==null||a==null||(this._updateMarker(r,a),this._map.setView([r,a],Math.max(this._map.getZoom(),this.zoom)),this._refreshMapSize())}_requestGeolocation(){!navigator.geolocation||this._geolocated||(this._geolocated=!0,this.isLocating=!0,navigator.geolocation.getCurrentPosition(r=>{const a=r.coords.latitude,u=r.coords.longitude;this._handleMapInteraction(a,u,"geolocation"),this._map&&this._map.setView([a,u],16),this.isLocating=!1,this.requestUpdate()},()=>{this._geolocated=!1,this.isLocating=!1,this.requestUpdate()},{enableHighAccuracy:!0,timeout:5e3}))}_switchLayer(){const r=["street","satellite","topo"],u=(r.indexOf(this._currentLayer)+1)%r.length,c=r[u];this._map.removeLayer(this._layers[this._currentLayer]),this._layers[c]._map||this._layers[c].addTo(this._map),this._currentLayer=c}_toggleFullscreen(){this.isFullscreen=!this.isFullscreen,this.isFullscreen?document.body.style.overflow="hidden":document.body.style.overflow="",this.dispatchEvent(new CustomEvent("fullscreen-changed",{detail:{isFullscreen:this.isFullscreen},bubbles:!0,composed:!0})),this._map&&setTimeout(()=>this._map?.invalidateSize(),350)}_zoomIn(){this._map&&(this._map.zoomIn(),setTimeout(()=>this._map?.invalidateSize(),150))}_zoomOut(){this._map&&(this._map.zoomOut(),setTimeout(()=>this._map?.invalidateSize(),150))}setCoordinates(r,a,u="programmatic"){!Number.isFinite(r)||!Number.isFinite(a)||(this._handleMapInteraction(r,a,u),this._map&&(this._map.setView([r,a],Math.max(this._map.getZoom(),16),{animate:!0}),this._refreshMapSize()))}render(){const r=this.labels||{};return dt`
            <style>
                coordinate-picker-lit { display: block; width: 100%; height: 100%; min-height: 200px; }
                ${mr}
                .map-container { min-height: 200px; }
                .map-container.is-fullscreen { position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; border: none !important; border-radius: 0 !important; z-index: 9999 !important; }
                .map-container.is-fullscreen .map-picker-leaflet-pane { height: 100vh !important; }
                .layer-controls-overlay { display: flex !important; flex-direction: column !important; gap: 0.5rem !important; }
            </style>
            <div class="map-container ${this.isFullscreen?"is-fullscreen":""}" style="--map-height: ${this.height}">
                ${cr([],()=>dt`<div class="map-picker-leaflet-pane" style="height: 100%;"></div>`)}
                <div class="layer-controls-overlay">
                    <button class="ctrl-btn" type="button" @click="${this._toggleFullscreen}" title="${this.isFullscreen?r.close_fullscreen||"Chiudi":r.fullscreen||"Fullscreen"}">
                        ${this.isFullscreen?Ft.fullscreenExit:Ft.fullscreen}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${()=>this._requestGeolocation()}" ?disabled="${this.isLocating}" title="${r.use_location||"Mia posizione"}">
                        ${this.isLocating?dt`<svg class="animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M4 12a8 8 0 018-8" opacity=".75"/></svg>`:Ft.crosshair}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._switchLayer}" title="${r.switch_layer||"Cambia Layer"}">
                        ${Ft.layer}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._zoomIn}" title="${r.zoom_in||"Zoom In"}">
                        ${Ft.zoomIn}
                    </button>
                    <button class="ctrl-btn" type="button" @click="${this._zoomOut}" title="${r.zoom_out||"Zoom Out"}">
                        ${Ft.zoomOut}
                    </button>
                </div>
                <div class="loading-overlay ${this.isLocating?"active":""}">
                    <div class="spinner"></div>
                </div>
            </div>
        `}firstUpdated(){this._boundRefreshMapSize=()=>this._refreshMapSize(),this._initMap(),this._resizeObserver=new ResizeObserver(()=>this._refreshMapSize()),this._resizeObserver.observe(this),this._visibilityObserver=new IntersectionObserver(a=>{a.some(u=>u.isIntersecting)&&this._refreshMapSize()},{threshold:.01}),this._visibilityObserver.observe(this),this._mutationObserver=new MutationObserver(()=>{this.offsetParent!==null&&this._refreshMapSize()});let r=this.parentElement;for(let a=0;a<15&&r;a++)this._mutationObserver.observe(r,{attributes:!0,attributeFilter:["class","style","hidden"]}),r=r.parentElement;window.addEventListener("resize",this._boundRefreshMapSize),document.addEventListener("livewire:navigated",this._boundRefreshMapSize),document.addEventListener("livewire:updated",this._boundRefreshMapSize),document.addEventListener("click",this._boundRefreshMapSize,!0),document.addEventListener("keydown",a=>{a.key==="Escape"&&this.isFullscreen&&this._toggleFullscreen()})}disconnectedCallback(){super.disconnectedCallback(),this._map&&(this._map.remove(),this._map=null),this._resizeObserver?.disconnect(),this._visibilityObserver?.disconnect(),this._mutationObserver?.disconnect(),window.removeEventListener("resize",this._boundRefreshMapSize),document.removeEventListener("livewire:navigated",this._boundRefreshMapSize),document.removeEventListener("livewire:updated",this._boundRefreshMapSize),document.removeEventListener("click",this._boundRefreshMapSize,!0)}updated(r){r.has("state")&&!this._isProgrammaticUpdate&&this._map&&this._lat!=null&&this._lng!=null&&this._syncMarkerToProperties()}}customElements.get("coordinate-picker-lit")||customElements.define("coordinate-picker-lit",xr);
