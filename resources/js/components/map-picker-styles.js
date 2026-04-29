import { css, html } from 'lit';

export const mapPickerStyles = css`
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

    .map-picker-leaflet-pane .leaflet-container,
    .map-picker-leaflet-pane .leaflet-pane,
    .map-picker-leaflet-pane .leaflet-layer,
    .map-picker-leaflet-pane .leaflet-tile,
    .map-picker-leaflet-pane .leaflet-tile-pane {
        opacity: 1 !important;
        filter: none !important;
    }

    .layer-controls-overlay {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 3001 !important;
        display: flex !important;
        flex-direction: column;
        gap: 0.75rem;
        opacity: 1 !important;
        visibility: visible !important;
        pointer-events: auto !important;
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
        opacity: 1 !important;
        visibility: visible !important;
        position: relative;
        z-index: 3002;
    }

    .ctrl-btn:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        color: #2563eb;
    }

    .ctrl-btn svg {
        width: 1.25rem !important;
        height: 1.25rem !important;
    }

    .ctrl-btn .ctrl-fallback {
        display: none;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1;
    }

    .ctrl-btn:not(:has(svg)) .ctrl-fallback {
        display: inline-block;
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
        width: min(300px, calc(100% - 5rem));
        align-items: center;
    }

    .search-box input {
        flex: 1;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        width: 100%;
        min-width: 0;
        outline: none;
        color: #17324d;
        background: #ffffff;
        line-height: 1.25rem;
    }

    .search-box .ctrl-btn {
        flex: 0 0 auto;
        width: 2.75rem;
        min-width: 2.75rem;
        height: 2.75rem;
    }

    .search-box .ctrl-btn svg {
        display: block;
        width: 1.25rem !important;
        height: 1.25rem !important;
        flex: 0 0 auto;
    }

    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.3s;
    }

    .loading-overlay.active {
        display: flex;
        opacity: 1;
        visibility: visible;
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
        width: 32px;
        height: 45px;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }

    .map-picker-marker svg {
        width: 100%;
        height: 100%;
        display: block;
    }
`;

// Light DOM components cannot rely on Lit static styles.
// Expose raw CSS text for inline <style> injection.
export const mapPickerStylesText = mapPickerStyles.cssText;

// controlIcons: name mapping → geoIcon() in geo-heroicons.js
// DEPRECATED: use geoIcon('name') directly in templates
export const controlIcons = {
    zoomIn: 'plus',
    zoomOut: 'minus',
    fullscreen: 'arrows-pointing-out',
    fullscreenExit: 'arrows-pointing-in',
    locate: 'map-pin',
    layer: 'squares-2x2',
    crosshair: 'map-pin',
};
