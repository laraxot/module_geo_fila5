import { LitElement, html } from 'lit';

/**
 * Filtri tipologia per map-lit — click aggiorna la mappa senza reload.
 * Stessa fonte dati del server (facet passati via attributo `filters`).
 */
class MapFilterLit extends LitElement {
    static properties = {
        mapId: { type: String, attribute: 'map-id' },
        title: { type: String },
        filters: {
            attribute: 'filters',
            converter: {
                fromAttribute(value) {
                    return MapFilterLit._parseJson(value, []);
                },
            },
        },
        total: { type: Number },
        initialSelected: {
            attribute: 'initial-selected',
            converter: {
                fromAttribute(value) {
                    return MapFilterLit._parseJson(value, []);
                },
            },
        },
        resultsTarget: { type: String, attribute: 'results-target' },
        clearTarget: { type: String, attribute: 'clear-target' },
        _selected: { type: Array, state: true },
    };

    static _parseJson(value, fallback) {
        if (Array.isArray(value)) {
            return value;
        }
        if (typeof value !== 'string' || value === '') {
            return fallback;
        }
        try {
            const parsed = JSON.parse(value);
            return Array.isArray(parsed) ? parsed : fallback;
        } catch {
            return fallback;
        }
    }

    createRenderRoot() {
        return this;
    }

    constructor() {
        super();
        this.mapId = 'ticket-map';
        this.title = '';
        this.filters = [];
        this.total = 0;
        this.initialSelected = [];
        this.resultsTarget = '';
        this.clearTarget = '';
        this._selected = [];
    }

    connectedCallback() {
        super.connectedCallback();
        this._selected = [...MapFilterLit._parseJson(this.initialSelected, [])];
        this._bindMapLoaded();
        this._bindClearControl();
        this._applyToMap(false);
    }

    disconnectedCallback() {
        super.disconnectedCallback();
        if (this._clearHandler && this.clearTarget) {
            const el = document.querySelector(this.clearTarget);
            el?.removeEventListener('click', this._clearHandler);
        }
    }

    /** @param {string[]} selected */
    syncSelected(selected) {
        this._selected = [...selected];
        this.requestUpdate();
    }

    clearAll() {
        this._selected = [];
        this._applyToMap(true);
        this.requestUpdate();
    }

    _getMap() {
        if (!this.mapId) {
            return null;
        }
        return document.getElementById(this.mapId);
    }

    _bindMapLoaded() {
        const map = this._getMap();
        if (!map) {
            return;
        }
        map.addEventListener('geo-map-loaded', () => this._applyToMap(false), { once: true });
        if (Array.isArray(map._allMarkers) && map._allMarkers.length > 0) {
            this._applyToMap(false);
        }
    }

    _bindClearControl() {
        if (!this.clearTarget) {
            return;
        }
        const el = document.querySelector(this.clearTarget);
        if (!el) {
            return;
        }
        this._clearHandler = (event) => {
            event.preventDefault();
            document.querySelectorAll(`map-filter-lit[map-id="${this.mapId}"]`).forEach((node) => {
                if (node instanceof MapFilterLit) {
                    node.clearAll();
                }
            });
        };
        el.addEventListener('click', this._clearHandler);
    }

    _filteredCount() {
        if (this._selected.length === 0) {
            return this.total;
        }

        return this.filters
            .filter((item) => this._selected.includes(item.value))
            .reduce((sum, item) => sum + (Number(item.count) || 0), 0);
    }

    _updateResultsCount() {
        if (!this.resultsTarget) {
            return;
        }
        const el = document.querySelector(this.resultsTarget);
        if (!el) {
            return;
        }
        const count = this._filteredCount();
        const template = el.dataset.countTemplate;
        if (template) {
            el.textContent = template.replace(':count', String(count));
            return;
        }
        el.textContent = String(count);
    }

    _updateUrl() {
        const url = new URL(window.location.href);
        url.searchParams.delete('types[]');
        url.searchParams.delete('types');
        for (const type of this._selected) {
            url.searchParams.append('types[]', type);
        }
        window.history.replaceState({}, '', url);
    }

    _syncSiblings() {
        document.querySelectorAll(`map-filter-lit[map-id="${this.mapId}"]`).forEach((node) => {
            if (node !== this && node instanceof MapFilterLit) {
                node.syncSelected(this._selected);
            }
        });
    }

    /**
     * @param {boolean} syncUrl
     */
    _applyToMap(syncUrl) {
        const map = this._getMap();
        if (map && typeof map.filterByTypes === 'function') {
            map.filterByTypes(this._selected);
        }
        this._updateResultsCount();
        if (syncUrl) {
            this._updateUrl();
        }
        this.dispatchEvent(
            new CustomEvent('map-filter-change', {
                detail: { types: [...this._selected], count: this._filteredCount() },
                bubbles: true,
            }),
        );
    }

    /**
     * @param {string} value
     * @param {boolean} checked
     */
    _onToggle(value, checked) {
        if (checked) {
            if (!this._selected.includes(value)) {
                this._selected = [...this._selected, value];
            }
        } else {
            this._selected = this._selected.filter((type) => type !== value);
        }
        this._applyToMap(true);
        this._syncSiblings();
        this.requestUpdate();
    }

    render() {
        if (!Array.isArray(this.filters) || this.filters.length === 0) {
            return html``;
        }

        return html`
            <fieldset>
                <legend class="h6 text-uppercase category-list__title">${this.title}</legend>
                <div class="categoy-list pb-4">
                    <ul>
                        ${this.filters.map(
                            (item) => html`
                                <li>
                                    <div class="form-check">
                                        <div class="checkbox-body border-light py-1">
                                            <input
                                                type="checkbox"
                                                id="${item.id}"
                                                .checked=${this._selected.includes(item.value)}
                                                @change=${(event) =>
                                                    this._onToggle(item.value, event.target.checked)}
                                            />
                                            <label
                                                for="${item.id}"
                                                class="subtitle-small_semi-bold mb-0 category-list__list"
                                            >
                                                ${item.label} (${item.count ?? 0})
                                            </label>
                                        </div>
                                    </div>
                                </li>
                            `,
                        )}
                    </ul>
                </div>
            </fieldset>
        `;
    }
}

if (!customElements.get('map-filter-lit')) {
    customElements.define('map-filter-lit', MapFilterLit);
}

export default MapFilterLit;
