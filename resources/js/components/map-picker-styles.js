/**
 * MapPickerLit Styles - CSSResult for Shadow DOM isolation.
 *
 * These styles are scoped to the Shadow DOM of the Lit component,
 * ensuring complete style isolation from the rest of the application.
 *
 * @see https://lit.dev/docs/components/styles/
 */

import { css } from '@theme-lit';

/**
 * Main component styles.
 */
export const mapPickerStyles = css`
    :host {
        display: block;
        width: 100%;
        box-sizing: border-box;
        --map-height: 400px;
        --map-border-radius: 0.5rem;
        --map-border-color: #e5e7eb;
        --map-bg: #f3f4f6;
    }

    * {
        box-sizing: border-box;
    }

    .map-container {
        width: 100%;
        height: var(--map-height);
        min-height: 300px;
        border-radius: var(--map-border-radius);
        overflow: hidden;
        position: relative;
        border: 1px solid var(--map-border-color);
        background: var(--map-bg);
    }

    .map-picker-leaflet-pane {
        width: 100%;
        height: 100%;
        position: relative;
        z-index: 0;
    }

    /* Controlli Leaflet in overlay sopra i tile */
    .leaflet-top.leaflet-left .leaflet-control {
        z-index: 1100;
    }

    /* Custom Marker Styling */
    .map-picker-marker {
        background: transparent;
        border: none;
    }

    /* Search Box */
    .search-box {
        position: absolute;
        top: 12px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1200;
        display: flex;
        gap: 8px;
        background: white;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        width: calc(100% - 24px);
        max-width: 400px;
    }

    .search-box input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }

    .search-box input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-box button {
        border: none;
        border-radius: 6px;
        background: #3b82f6;
        color: white;
        padding: 8px 16px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .search-box button:hover {
        background: #2563eb;
    }

    /* Custom Toolbar Controls */
    .map-picker-toolbar {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .control-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: white;
        color: #111827;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        transition: all 0.2s ease;
        pointer-events: auto;
    }

    .control-btn:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
    }

    .control-btn svg {
        width: 18px;
        height: 18px;
    }

    /* Loading State */
    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
    }

    .loading-overlay.active {
        opacity: 1;
        pointer-events: auto;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e5e7eb;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Fullscreen state */
    :host(.is-fullscreen) .map-container {
        position: fixed;
        inset: 0;
        height: 100vh;
        border-radius: 0;
        z-index: 9999;
    }

    /* Leaflet bar reset — custom zoom buttons replace native control */
    .leaflet-bar {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }
`;

/**
 * Icon SVGs for toolbar controls.
 */
export const controlIcons = {
    zoomIn: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>`,

    zoomOut: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="8" y1="11" x2="14" y2="11"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>`,

    fullscreen: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>`,

    fullscreenExit: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 14 10 14 10 20"/><polyline points="20 10 14 10 14 4"/><line x1="10" y1="14" x2="3" y2="21"/><line x1="21" y1="3" x2="14" y2="10"/></svg>`,

    locate: `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><circle cx="12" cy="12" r="3"/></svg>`,

    layer: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>`,
};

/**
 * Marker SVG icon.
 */
export const markerSvg = `
<svg width="35" height="45" viewBox="0 0 35 45" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M17.5 0C7.835 0 0 7.835 0 17.5C0 30.625 17.5 45 17.5 45C17.5 45 35 30.625 35 17.5C35 7.835 27.165 0 17.5 0Z" fill="#EF4444"/>
  <circle cx="17.5" cy="17.5" r="9.5" fill="#FFFFFF"/>
  <circle cx="17.5" cy="17.5" r="5" fill="#EF4444"/>
</svg>
`;
