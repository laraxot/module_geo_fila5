# Story: Enhanced Map Component for Ticket Wizard

## Story ID
GEO-2024-001

## Title
Implement Enhanced Interactive Map for Ticket Location Input

## As a
Citizen user reporting urban issues

## I want to
Select a location on an interactive map with geolocation support

## So that
I can accurately report where the issue occurred without typing complex addresses

## Acceptance Criteria

### Core Functionality (Must Have)
- [ ] **Map Initialization**: Map loads centered on Rome (41.9028, 12.4964) with zoom level 13
- [ ] **Geolocation Button**: "Use My Location" button that:
  - Requests GPS location with clear permission dialog
  - Shows loading state while searching
  - Centers map on detected location
  - Places marker at detected coordinates
  - Shows user-friendly error messages if permission denied or unavailable
- [ ] **Interactive Marker**: Draggable marker that:
  - Can be dragged to precise location
  - Updates latitude/longitude fields in real-time
  - Shows visual feedback when dragging
  - Can be placed by clicking on the map
- [ ] **Coordinate Fields**: Hidden latitude/longitude fields that:
  - Update when marker is moved or geolocation is used
  - Validate coordinates (lat: -90 to 90, lng: -180 to 180)
  - Round to 6 decimal places for precision
  - Are properly bound to the Ticket model

### Enhanced User Experience (Should Have)
- [ ] **Loading States**: Visual feedback during:
  - Map initialization
  - Geolocation request
  - Coordinate updates
- [ ] **Error Handling**: Graceful handling of:
  - Geolocation permission denied
  - Location unavailable (show alternatives)
  - Network issues (offline mode)
  - Invalid coordinates (validation errors)
- [ ] **Accessibility**: Full accessibility support:
  - Keyboard navigation (arrow keys for fine movement)
  - ARIA labels and descriptions
  - Screen reader announcements
  - High contrast mode support
- [ ] **Mobile Optimization**: Touch-friendly interface:
  - Large touch targets
  - Smooth touch gestures
  - Responsive design for all screen sizes

### Performance & Optimization (Could Have)
- [ ] **Lazy Loading**: Map resources load only when component is visible
- [ ] **Debounced Updates**: Coordinate updates are debounced to prevent performance issues
- [ ] **Map Presets**: Option to switch between map layers (OSM, Satellite, Terrain)
- [ ] **Reverse Geocoding**: Optional display of approximate address from coordinates

## Technical Implementation

### Component Location
- **File**: `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/app/Filament/Forms/Components/LeafletMarkerMapInput.php`
- **View**: `/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/views/filament/forms/components/leaflet-marker-map-input.blade.php`

### Integration with CreateTicketWizardWidget
The widget already uses the LeafletMarkerMapInput component:
```php
LeafletMarkerMapInput::make('location_map')
    ->defaultCenter(41.9028, 12.4964)
    ->defaultZoom(13)
    ->mapHeight('340px'),
```

### Required Enhancements

#### 1. Enhanced Geolocation
```javascript
// Improved geolocation with better UX
navigator.geolocation.getCurrentPosition(
    (position) => {
        // Success: animate to location
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        
        // Animate map movement
        map.flyTo([lat, lng], 16, {
            duration: 1.5
        });
        
        // Update marker with animation
        marker.setLatLng([lat, lng]).bindPopup('La tua posizione').openPopup();
        
        // Update coordinates with debouncing
        debouncedUpdateCoordinates(lat, lng);
        
        // Show success message
        showNotification('Posizione trovata!', 'success');
    },
    (error) => {
        // Improved error handling
        handleGeolocationError(error);
    },
    {
        enableHighAccuracy: true,
        timeout: 15000,
        maximumAge: 300000 // 5 minutes
    }
);
```

#### 2. Visual Feedback Enhancements
```css
/* Loading states */
.leaflet-marker-map-input.loading .loading-overlay {
    display: flex;
}

/* Dragging state */
.leaflet-marker-map-input .leaflet-marker-icon.dragging {
    opacity: 0.8;
    transform: scale(1.2);
}

/* Precision circle */
.precision-circle {
    border: 2px dashed #007bff;
    border-radius: 50%;
    pointer-events: none;
}
```

#### 3. Accessibility Improvements
```javascript
// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.target === mapElement) {
        switch(e.key) {
            case 'ArrowUp':
                moveMarker(0, 0.001);
                break;
            case 'ArrowDown':
                moveMarker(0, -0.001);
                break;
            case 'ArrowLeft':
                moveMarker(-0.001, 0);
                break;
            case 'ArrowRight':
                moveMarker(0.001, 0);
                break;
        }
    }
});

// Screen reader announcements
function announceCoordinates(lat, lng) {
    const announcement = `Coordinate: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
    const announcer = document.getElementById('screen-announcer');
    if (announcer) {
        announcer.textContent = announcement;
    }
}
```

### Dependencies
- Leaflet 1.9.4 (current)
- Debounce utility (lodash.debounce or custom implementation)
- Intersection Observer API (for lazy loading)

### Files to Modify

1. **Component PHP**: Enhance LeafletMarkerMapInput with new options
2. **Component View**: Add loading states, error handling, accessibility features
3. **JavaScript**: Improve interactivity and user feedback
4. **CSS**: Add styles for loading states and visual feedback

## Testing Scenarios

### Scenario 1: Successful Geolocation
1. User clicks "Use My Location"
2. System requests permission
3. User grants permission
4. Map centers on user location
5. Marker is placed at coordinates
6. Coordinate fields are updated

### Scenario 2: Permission Denied
1. User clicks "Use My Location"
2. System requests permission
3. User denies permission
4. System shows error message with alternative options
5. User can still manually place marker

### Scenario 3: Manual Placement
1. User clicks on map
2. Marker is placed at clicked location
3. Coordinate fields are updated
4. Map centers on new location

### Scenario 4: Mobile Experience
1. User accesses on mobile device
2. Touch targets are large enough
3. Touch gestures work smoothly
4. Map is responsive to screen size

## Performance Considerations

- **Bundle Size**: Keep additional JavaScript under 20KB
- **Memory Usage**: Clean up event listeners on component destroy
- **Network Requests**: No external requests after initial load
- **Render Performance**: Use requestAnimationFrame for animations

## Security Considerations

- **Geolocation**: Only request with user permission
- **Coordinate Validation**: Validate all input coordinates
- **XSS Protection**: Sanitize all user inputs
- **Privacy**: Don't store location data unnecessarily

## Success Metrics

### User Experience
- Time to first map interaction < 2 seconds
- Geolocation success rate > 90%
- User satisfaction score > 4.5/5
- Accessibility compliance 100%

### Technical Metrics
- Component load time < 500ms
- Memory usage < 10MB
- Coordinate update latency < 100ms
- No JavaScript errors in console

## Related Stories
- GEO-2024-002: Add reverse geocoding to display address
- GEO-2024-003: Implement map presets and themes
- GEO-2024-004: Add location sharing functionality

## Definition of Done
- [ ] All acceptance criteria met
- [ ] Tests passing (unit and integration)
- [ ] Accessibility audit completed
- [ ] Performance benchmarks met
- [ ] Documentation updated
- [ ] Code reviewed and approved
- [ ] Deployed to staging