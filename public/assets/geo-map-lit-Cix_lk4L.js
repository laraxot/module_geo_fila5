            <path d="M16 0C7.163 0 0 7.163 0 16c0 10 16 29 16 29S32 26 32 16C32 7.163 24.837 0 16 0z"
                  fill="${n}" stroke="#fff" stroke-width="1.5"/>
            <circle cx="16" cy="16" r="6" fill="#fff"/>
        </svg>`,className:`geo-map-marker-wrapper`,iconSize:[32,45],iconAnchor:[16,45],popupAnchor:[0,-46]})}var y=`/data/tickets.json`,b=[41.9028,12.4964],x=6,S=class extends r{static properties={filterType:{type:String},activeLayer:{type:String},isFullscreen:{type:Boolean,state:!0},height:{type:String},_searchOpen:{type:Boolean,state:!0},labels:{type:Object},dataUrl:{type:String,attribute:`data-url`},searchQuery:{type:String,state:!0},searchResults:{type:Array,state:!0},showSearchResults:{type:Boolean,state:!0},isSearching:{type:Boolean,state:!0},isLocating:{type:Boolean,state:!0}};createRenderRoot(){return this}constructor(){super(),this.filterType=null,this.activeLayer=`markers`,this.isFullscreen=!1,this._searchOpen=!1,this.searchQuery=``,this.searchResults=[],this.showSearchResults=!1,this.isSearching=!1,this.isLocating=!1,this.labels={fullscreen:`Schermo intero`,close_fullscreen:`Esci da schermo intero`,use_location:`Usa la mia posizione`,switch_layer:`Cambia layer`,zoom_in:`Aumenta zoom`,zoom_out:`Diminuisci zoom`,search:`Cerca`,search_placeholder:`Cerca indirizzo...`},this.height=`450px`,this.dataUrl=y,this._currentLayer=`street`,this._allFeatures=[],this._allMarkers=[],this._layers={},this._boundDocumentClickHandler=e=>this._handleDocumentClick(e),this._boundDocumentKeydownHandler=e=>this._handleDocumentKeydown(e)}render(){return n`
            <style>
                ${t}
                geo-map-lit { display: block; width: 100%; min-height: 320px; }
                .geo-map-leaflet { width: 100%; height: 100%; min-height: 320px; }
                .geo-map-marker-wrapper svg { display: block; }
                .leaflet-div-icon { background: transparent !important; border: none !important; }
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
                html.geo-map-fullscreen-active, html.geo-map-fullscreen-active body { overflow: hidden !important; }
            </style>
            <div class="map-container ${this.isFullscreen?`is-fullscreen`:``}"
                 @click=${e=>this._handleSurfaceClick(e)}
                 style="position:relative;--map-height:${this.height||`450px`};">
                <div class="geo-map-leaflet" style="width:100%;height:100%;"></div>
                ${d(this)}
                ${this._searchOpen?l(this):``}
            </div>
                            <div class="geo-popup">
                                <strong class="geo-popup-title">${o.title||``}</strong>
                                <span class="geo-popup-badge" style="background:${s}">${o.type_label||``}</span>
                                <br><small class="text-muted">${o.address||``}</small>
                            </div>