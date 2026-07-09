const __vite__mapDeps=(i,m=__vite__mapDeps,d=(m.f||(m.f=["assets/leaflet.markercluster-src-56a-q5dW.js","assets/chunk-ChgXRy64.js"])))=>i.map(i=>d[i]);
import{n as e}from"./chunk-ChgXRy64.js";import{i as t,l as n,s as r,t as i}from"./leaflet-src-BC8gaMNm.js";import{a,c as o,i as s,n as c,o as l,r as u,s as d,t as f}from"./map-picker-layers-D-nhYgP0.js";var p=e(i(),1),m=/^#[0-9a-f]{3}([0-9a-f]{3})?$/i;function h(e,t=`#0066cc`){return m.test(String(e||``))?e:t}function g(e,t=`#0066cc`){let n=h(t);return e.divIcon({html:`<svg viewBox="0 0 32 45" width="32" height="45" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 29 16 29S32 26 32 16C32 7.163 24.837 0 16 0z"
                  fill="${n}" stroke="#fff" stroke-width="1.5"/>
            <circle cx="16" cy="16" r="6" fill="#fff"/>
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