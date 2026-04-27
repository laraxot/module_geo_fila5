import { html, customElement } from 'lit';
import { guard } from 'lit/directives/guard.js';

export function searchInputTemplate(searchQuery, searchAddress, showResults, isSearching) {
    return html`
        <div class="relative items-center gap-2" x-show="!isFullscreen">
            <div class="relative group">
                <input type="text"
                    x-model=${searchQuery}
                    @input=${searchAddress}
                    @keydown.escape=${() => { showResults = false }}
                    placeholder=${'Cerca indirizzo...'}
                    class="fi-input block w-full border-none bg-white py-1.5 pl-10 pr-3 text-sm text-gray-950 shadow-sm ring-1 ring-gray-950/10 transition duration-75 focus-within:ring-2 focus-within:ring-primary-600 dark:bg-white/5 dark:text-white dark:ring-white/20 dark:focus-within:ring-primary-500 rounded-lg">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4 min-h-4 min-w-4 block" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div x-show=${isSearching} class="absolute right-3 top-1/2 -translate-y-1/2">
                    <svg aria-hidden="true" viewBox="0 0 24 24" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" stroke="currentColor" stroke-width="2" class="animate-spin" />
                    </svg>
                </div>
            </div>

            <ul x-show=${showResults} @click.away=${() => { showResults = false }}
                class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-lg bg-white py-1 shadow-lg ring-1 ring-gray-950/5 dark:bg-gray-800 dark:ring-white/10">
                <template x-for=${showResults ? searchResults : [], forEach=${renderResult}} :key=${res => res.place_id}>
                    <li @click=${(e) => selectSearchResult(res)}
                        class="cursor-pointer px-4 py-2 text-sm text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-white/5">
                        <span x-text=${res.display_name}></span>
                    </li>
                </template>
            </ul>
        </div>
    `;
}

export function renderResult(res) {
    return {
        place_id: res.place_id,
        display_name: res.display_name
    };
}

export function selectSearchResult(res) {
    // placeholder for selection handling
}