# Lit.js Map Component Implementation

## Overview
This document describes the implementation of a custom web component for interactive maps using Lit.js and Leaflet.js.

## Component Structure

### File Location
- **Component**: `/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/src/components/my-map.ts`
- **Build Output**: `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/js/components/my-map-lit.js`

### Key Features
1. **Interactive Map**: Uses Leaflet.js for mapping functionality
2. **Custom Events**: Emits `map-coordinates-changed` when coordinates are updated
3. **Responsive Design**: Adapts to different screen sizes with mobile-first approach
4. **Layer Switching**: Toggle between road and satellite views
5. **Geolocation**: Get current location button
6. **Fullscreen Mode**: Toggle fullscreen view
7. **Real-time Updates**: Coordinates update when marker is dragged

## Usage

### Basic Implementation
```html
<my-map
    id="my-map"
    lat="41.9028"
    lng="12.4964"
    zoom="13"
    height="400px"
    interactive="true"
    marker-title="Selected position"
></my-map>
```

### Listening for Coordinate Changes
```javascript
document.getElementById('my-map').addEventListener('map-coordinates-changed', (event) => {
    const { lat, lng } = event.detail;
    console.log('Coordinates updated:', lat, lng);
});
```

## Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| lat | Number | 45.6669 | Latitude coordinate |
| lng | Number | 12.2423 | Longitude coordinate |
| zoom | Number | 10 | Map zoom level |
| height | String | '400px' | Map container height |
| interactive | Boolean | true | Enable marker dragging and map clicks |
| markerTitle | String | 'My Map' | Popup text for marker |

## Events

### map-coordinates-changed
Fired when coordinates are updated via marker drag or map click.

```typescript
detail: {
    lat: number;
    lng: number;
    zoom: number;
}
```

## Build Process

1. **Development**: Component is written in TypeScript in `/src/components/`
2. **Build**: Vite compiles TypeScript to JavaScript in `/public/`
3. **Import**: Component is imported in `app.js` from the Geo module
4. **Copy**: Build assets are copied to Laravel public directory

## Mobile Optimization

The component implements a mobile-first approach with:
- Responsive controls that adapt to screen size
- Touch-friendly button sizes
- Optimized layout for mobile devices
- Reduced height on smaller screens

## Integration with Filament

The component integrates with Filament forms through:
- Custom Blade template (`latitude-longitude-input-lit.blade.php`)
- Livewire model synchronization
- Real-time coordinate updates

## Browser Support

- Modern browsers with ES6 support
- Leaflet.js for map rendering
- Lit.js for component lifecycle management

## Performance Considerations

1. **Lazy Loading**: Leaflet.js is imported dynamically
2. **Event Delegation**: Efficient event handling
3. **Shadow DOM**: Scoped styles prevent conflicts
4. **Cleanup**: Proper disposal in `disconnectedCallback`