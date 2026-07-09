const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/leaflet.markercluster-BLhr5ZVY.js","assets/chunk-ChgXRy64.js"])))=>i.map(i=>d[i]);
import{n as e}from"./chunk-ChgXRy64.js";import{i as t,l as n,s as r,t as i}from"./leaflet-src-BC8gaMNm.js";import{a,c as o,i as s,n as c,o as l,r as u,s as d,t as f}from"./map-picker-layers-D-nhYgP0.js";var p=e(i(),1);(function(){function e(t){return this instanceof e?(this._canvas=t=typeof t==`string`?document.getElementById(t):t,this._ctx=t.getContext(`2d`),this._width=t.width,this._height=t.height,this._max=1,void this.clear()):new e(t)}e.prototype={defaultRadius:25,defaultGradient:{.4:`blue`,.6:`cyan`,.7:`lime`,.8:`yellow`,1:`red`},data:function(e,t){return this._data=e,this},max:function(e){return this._max=e,this},add:function(e){return this._data.push(e),this},clear:function(){return this._data=[],this},radius:function(e,t){t||=15;var n=this._circle=document.createElement(`canvas`),r=n.getContext(`2d`),i=this._r=e+t;return n.width=n.height=2*i,r.shadowOffsetX=r.shadowOffsetY=200,r.shadowBlur=t,r.shadowColor=`black`,r.beginPath(),r.arc(i-200,i-200,e,0,2*Math.PI,!0),r.closePath(),r.fill(),this},gradient:function(e){var t=document.createElement(`canvas`),n=t.getContext(`2d`),r=n.createLinearGradient(0,0,0,256);for(var i in t.width=1,t.height=256,e)r.addColorStop(i,e[i]);return n.fillStyle=r,n.fillRect(0,0,1,256),this._grad=n.getImageData(0,0,1,256).data,this},draw:function(e){this._circle||this.radius(this.defaultRadius),this._grad||this.gradient(this.defaultGradient);var t=this._ctx;t.clearRect(0,0,this._width,this._height);for(var n,r=0,i=this._data.length;i>r;r++)n=this._data[r],t.globalAlpha=Math.max(n[2]/this._max,e||.05),t.drawImage(this._circle,n[0]-this._r,n[1]-this._r);var a=t.getImageData(0,0,this._width,this._height);return this._colorize(a.data,this._grad),t.putImageData(a,0,0),this},_colorize:function(e,t){for(var n,r=3,i=e.length;i>r;r+=4)n=4*e[r],n&&(e[r-3]=t[n],e[r-2]=t[n+1],e[r-1]=t[n+2])}},window.simpleheat=e})(),L.HeatLayer=(L.Layer?L.Layer:L.Class).extend({initialize:function(e,t){this._latlngs=e,L.setOptions(this,t)},setLatLngs:function(e){return this._latlngs=e,this.redraw()},addLatLng:function(e){return this._latlngs.push(e),this.redraw()},setOptions:function(e){return L.setOptions(this,e),this._heat&&this._updateOptions(),this.redraw()},redraw:function(){return!this._heat||this._frame||this._map._animating||(this._frame=L.Util.requestAnimFrame(this._redraw,this)),this},onAdd:function(e){this._map=e,this._canvas||this._initCanvas(),e._panes.overlayPane.appendChild(this._canvas),e.on(`moveend`,this._reset,this),e.options.zoomAnimation&&L.Browser.any3d&&e.on(`zoomanim`,this._animateZoom,this),this._reset()},onRemove:function(e){e.getPanes().overlayPane.removeChild(this._canvas),e.off(`moveend`,this._reset,this),e.options.zoomAnimation&&e.off(`zoomanim`,this._animateZoom,this)},addTo:function(e){return e.addLayer(this),this},_initCanvas:function(){var e=this._canvas=L.DomUtil.create(`canvas`,`leaflet-heatmap-layer leaflet-layer`),t=L.DomUtil.testProp([`transformOrigin`,`WebkitTransformOrigin`,`msTransformOrigin`]);e.style[t]=`50% 50%`;var n=this._map.getSize();e.width=n.x,e.height=n.y;var r=this._map.options.zoomAnimation&&L.Browser.any3d;L.DomUtil.addClass(e,`leaflet-zoom-`+(r?`animated`:`hide`)),this._heat=simpleheat(e),this._updateOptions()},_updateOptions:function(){this._heat.radius(this.options.radius||this._heat.defaultRadius,this.options.blur),this.options.gradient&&this._heat.gradient(this.options.gradient),this.options.max&&this._heat.max(this.options.max)},_reset:function(){var e=this._map.containerPointToLayerPoint([0,0]);L.DomUtil.setPosition(this._canvas,e);var t=this._map.getSize();this._heat._width!==t.x&&(this._canvas.width=this._heat._width=t.x),this._heat._height!==t.y&&(this._canvas.height=this._heat._height=t.y),this._redraw()},_redraw:function(){var e,t,n,r,i,a,o,s,c,l=[],u=this._heat._r,d=this._map.getSize(),f=new L.Bounds(L.point([-u,-u]),d.add([u,u])),p=this.options.max===void 0?1:this.options.max,m=this.options.maxZoom===void 0?this._map.getMaxZoom():this.options.maxZoom,h=1/2**Math.max(0,Math.min(m-this._map.getZoom(),12)),g=u/2,_=[],v=this._map._getMapPanePos(),y=v.x%g,b=v.y%g;for(e=0,t=this._latlngs.length;t>e;e++)n=this._map.latLngToContainerPoint(this._latlngs[e]),f.contains(n)&&(i=Math.floor((n.x-y)/g)+2,a=Math.floor((n.y-b)/g)+2,c=(this._latlngs[e].alt===void 0?this._latlngs[e][2]===void 0?1:+this._latlngs[e][2]:this._latlngs[e].alt)*h,_[a]=_[a]||[],r=_[a][i],r?(r[0]=(r[0]*r[2]+n.x*c)/(r[2]+c),r[1]=(r[1]*r[2]+n.y*c)/(r[2]+c),r[2]+=c):_[a][i]=[n.x,n.y,c]);for(e=0,t=_.length;t>e;e++)if(_[e])for(o=0,s=_[e].length;s>o;o++)r=_[e][o],r&&l.push([Math.round(r[0]),Math.round(r[1]),Math.min(r[2],p)]);this._heat.data(l).draw(this.options.minOpacity),this._frame=null},_animateZoom:function(e){var t=this._map.getZoomScale(e.zoom),n=this._map._getCenterOffset(e.center)._multiplyBy(-t).subtract(this._map._getMapPanePos());L.DomUtil.setTransform?L.DomUtil.setTransform(this._canvas,n,t):this._canvas.style[L.DomUtil.TRANSFORM]=L.DomUtil.getTranslateString(n)+` scale(`+t+`)`}}),L.heatLayer=function(e,t){return new L.HeatLayer(e,t)};var m=/^#[0-9a-f]{3}([0-9a-f]{3})?$/i;function h(e,t=`#0066cc`){return m.test(String(e||``))?e:t}function g(e,t=`#0066cc`){let n=h(t);return e.divIcon({html:`<svg viewBox="0 0 32 45" width="32" height="45" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 29 16 29S32 26 32 16C32 7.163 24.837 0 16 0z"
                  fill="${n}" stroke="#fff" stroke-width="1.5"/>
            <circle cx="16" cy="16" r="6" fill="#fff"/>
        </svg>`,className:`geo-map-marker-wrapper`,iconSize:[32,45],iconAnchor:[16,45],popupAnchor:[0,-46]})}var _=`modulepreload`,v=function(e){return`/assets/geo/`+e},y={},b=function(e,t,n){let r=Promise.resolve();if(t&&t.length>0){let e=document.getElementsByTagName(`link`),i=document.querySelector(`meta[property=csp-nonce]`),a=i?.nonce||i?.getAttribute(`nonce`);function o(e){return Promise.all(e.map(e=>Promise.resolve(e).then(e=>({status:`fulfilled`,value:e}),e=>({status:`rejected`,reason:e}))))}r=o(t.map(t=>{if(t=v(t,n),t in y)return;y[t]=!0;let r=t.endsWith(`.css`),i=r?`[rel="stylesheet"]`:``;if(n)for(let n=e.length-1;n>=0;n--){let i=e[n];if(i.href===t&&(!r||i.rel===`stylesheet`))return}else if(document.querySelector(`link[href="${t}"]${i}`))return;let o=document.createElement(`link`);if(o.rel=r?`stylesheet`:_,r||(o.as=`script`),o.crossOrigin=``,o.href=t,a&&o.setAttribute(`nonce`,a),document.head.appendChild(o),r)return new Promise((e,n)=>{o.addEventListener(`load`,e),o.addEventListener(`error`,()=>n(Error(`Unable to preload CSS for ${t}`)))})}))}function i(e){let t=new Event(`vite:preloadError`,{cancelable:!0});if(t.payload=e,window.dispatchEvent(t),!t.defaultPrevented)throw e}return r.then(t=>{for(let e of t||[])e.status===`rejected`&&i(e.reason);return e().catch(i)})},x=`/data/tickets.json`,S=[41.9028,12.4964],C=6,w=class extends r{static properties={filterType:{type:String},activeLayer:{type:String},isFullscreen:{type:Boolean,state:!0},height:{type:String},_searchOpen:{type:Boolean,state:!0},labels:{type:Object},dataUrl:{type:String,attribute:`data-url`},searchQuery:{type:String,state:!0},searchResults:{type:Array,state:!0},showSearchResults:{type:Boolean,state:!0},isSearching:{type:Boolean,state:!0},isLocating:{type:Boolean,state:!0},_mapStatus:{type:String,state:!0},_mapStatusMessage:{type:String,state:!0}};createRenderRoot(){return this}constructor(){super(),this.filterType=null,this.activeLayer=`markers`,this.isFullscreen=!1,this._searchOpen=!1,this.searchQuery=``,this.searchResults=[],this.showSearchResults=!1,this.isSearching=!1,this.isLocating=!1,this._previousBodyOverflow=``,this._previousHtmlOverflow=``,this.labels={fullscreen:`Schermo intero`,close_fullscreen:`Esci da schermo intero`,use_location:`Usa la mia posizione`,switch_layer:`Cambia layer`,zoom_in:`Aumenta zoom`,zoom_out:`Diminuisci zoom`,search:`Cerca`,search_placeholder:`Cerca indirizzo...`},this.height=`450px`,this.dataUrl=x,this._currentLayer=`street`,this._allFeatures=[],this._allMarkers=[],this._layers={},this._mapStatus=`idle`,this._mapStatusMessage=``,this._isUserCentered=!1}render(){return n`
            <style>
                ${t}
                geo-map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                .geo-map-marker-wrapper svg { display: block; }
                .leaflet-div-icon { background: transparent !important; border: none !important; }

                /* farmshops.eu / direktvermarkter.js cluster styles */
                .geo-cluster-circle {
                    background: #fff; border: 2.5px solid #0066cc; border-radius: 50%;
                    width: 80px; height: 80px; display: flex; flex-direction: column; align-items: center;
                    justify-content: center; font-weight: 700; font-size: 15px; box-shadow: 0 2px 8px rgba(0,0,0,.35);
                    text-align: center; line-height: 1.1; box-sizing: border-box; color: #17324d;
                    font-family: sans-serif; overflow: hidden;
                }
                .geo-cluster-type-icons {
                    display: flex; gap: 3px; justify-content: center; flex-wrap: wrap;
                    max-width: 58px; margin-top: 2px;
                }

                .geo-address-search { position: absolute !important; top: 1rem !important; right: 1rem !important; z-index: 3001 !important; display: flex !important; flex-wrap: wrap !important; gap: 0.4rem !important; background: rgba(255,255,255,0.95) !important; padding: 0.4rem !important; border-radius: 0.75rem !important; box-shadow: 0 4px 14px rgba(0,0,0,.15) !important; max-width: 280px !important; width: min(280px, calc(100% - 5rem)) !important; align-items: center !important; backdrop-filter: blur(6px) !important; }
                .geo-address-search .map-picker-search-input { flex: 1 !important; border: 1px solid #d1d5db !important; border-radius: 0.5rem !important; padding: 0.4rem 0.6rem !important; font-size: 0.85rem !important; min-width: 0 !important; outline: none !important; color: #17324d !important; background: #fff !important; height: auto !important; box-shadow: none !important; }
                .geo-address-search .ctrl-btn { flex: 0 0 2.5rem !important; width: 2.5rem !important; height: 2.5rem !important; min-width: 2.5rem !important; }
                .geo-address-search-results { position: absolute !important; top: 100% !important; left: 0 !important; right: 0 !important; max-height: 12rem !important; margin: 0.25rem 0 0 !important; padding: 0.25rem 0 !important; overflow: auto !important; list-style: none !important; border: 1px solid #d1d5db !important; border-radius: 0.75rem !important; background: #fff !important; color: #17324d !important; box-shadow: 0 10px 24px rgba(23,50,77,.16) !important; z-index: 3002 !important; }
                .geo-address-search-results li { padding: 0.5rem 0.75rem !important; cursor: pointer !important; font-size: 0.8125rem !important; line-height: 1.25 !important; list-style: none !important; }
                .geo-address-search-results li:hover { background: #eef6ff !important; color: #0050a4 !important; }

                .geo-popup { padding: 2px 0; }
                .geo-popup-title { display: block; font-size: 14px; margin-bottom: 4px; color: #17324d; font-weight: 700; }
                .geo-popup-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; color: #fff; margin-bottom: 6px; font-weight: 600; }
                .geo-popup-description { font-size: 12.5px; line-height: 1.4; color: #4b5563; margin-top: 4px; }

                .geo-map-status {
                    position: absolute; left: 0.75rem; bottom: 0.75rem; z-index: 3002;
                    background: rgba(255,255,255,0.95); color: #17324d; border-radius: 0.5rem;
                    padding: 0.4rem 0.6rem; font-size: 12px; line-height: 1.2;
                    box-shadow: 0 3px 10px rgba(0,0,0,.12); max-width: min(90%, 420px);
                }
                .geo-map-status.error { border-left: 3px solid #b91c1c; }
                .geo-map-status.empty { border-left: 3px solid #b45309; }

                html.geo-map-fullscreen-active, html.geo-map-fullscreen-active body { overflow: hidden !important; }
            </style>
            <div class="map-container ${this.isFullscreen?`is-fullscreen`:``}"
                 style="position:relative;--map-height:${this.height||`450px`};">
                <div class="geo-map-leaflet" style="width:100%;height:100%;"></div>
                ${u(this)}
                ${this._searchOpen?c(this):``}
                ${this._mapStatus===`empty`||this._mapStatus===`error`?n`
                    <div class="geo-map-status ${this._mapStatus}">
                        ${this._mapStatusMessage}
                    </div>
                `:``}
            </div>
                    <div class="geo-popup">
                        <strong class="geo-popup-title">${t.title||``}</strong>
                        <span class="geo-popup-badge" style="background:${i}">${t.type_label||``}</span>
                        <br><small class="text-muted">${t.address||``}</small>
                    </div>
                `,{maxWidth:260}),t.id&&a.once(`click`,()=>{fetch(`/api/ticket-details/${t.id}`).then(e=>e.ok?e.json():null).then(e=>{if(!e)return;let n=`
                                    <div class="geo-popup">
                                        <strong class="geo-popup-title">${e.title||t.title||``}</strong>
                                        <span class="geo-popup-badge" style="background:${i}">${t.type_label||``}</span>
                                        <p class="geo-popup-description">${e.description||``}</p>
                                        ${e.address?`<small class="text-muted d-block mb-1">${e.address}</small>`:``}
                                    </div>