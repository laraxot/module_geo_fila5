# Geo Module Documentation

## Overview
The Geo module provides comprehensive geographic information system (GIS) capabilities for the Laraxot system. It offers geolocation services, mapping functionality, spatial data management, and location-based features.

## Key Features
- **Geocoding**: Convert addresses to coordinates and vice versa
- **Mapping**: Interactive maps with custom markers and overlays
- **Spatial Queries**: Location-based database queries and filters
- **Distance Calculations**: Calculate distances between locations
- **Geofencing**: Define geographic boundaries and triggers
- **Location Tracking**: Real-time location tracking and history

## Architecture
The module follows the Laraxot architecture principles:
- Extends Xot base classes
- Uses Filament for admin interface
- Implements proper service providers
- Follows DRY/KISS principles

## Supported Providers
1. **Google Maps**: Full integration with Google Maps Platform
2. **OpenStreetMap**: Open-source mapping platform
3. **Mapbox**: Custom map design and navigation
4. **HERE Technologies**: Enterprise mapping solutions
5. **Bing Maps**: Microsoft's mapping platform

## Core Components

### Models
- `Location` - Geographic location data
- `Geofence` - Defined geographic boundaries
- `Place` - Points of interest and places
- `Route` - Navigation routes and directions

### Resources
- `LocationResource` - Location management interface
- `GeofenceResource` - Geofence management resource
- `PlaceResource` - Place management interface
- `GeoDashboard` - Geographic dashboard

### Services
- `GeoService` - Core geographic operations
- `Geocoder` - Address and coordinate conversion
- `DistanceCalculator` - Distance calculation algorithms
- `MapRenderer` - Map rendering and display
- `GeofenceManager` - Geofence creation and management

## Implementation Guide

### Basic Geocoding
```php
// Initialize geocoder
$geocoder = app(Geocoder::class);

// Geocode an address
$coordinates = $geocoder->geocode('1600 Amphitheatre Parkway, Mountain View, CA');

// Reverse geocode coordinates
$address = $geocoder->reverseGeocode(37.4224764, -122.0842499);

// Batch geocoding
$addresses = [
    '1600 Amphitheatre Parkway, Mountain View, CA',
    '1 Infinite Loop, Cupertino, CA'
];
$results = $geocoder->batchGeocode($addresses);
```

### Distance Calculations
```php
// Calculate distance between two points
$distanceCalculator = app(DistanceCalculator::class);

$distance = $distanceCalculator->calculateDistance(
    37.4224764, -122.0842499,  // Point A (Google HQ)
    37.3318200, -122.0311800   // Point B (Apple HQ)
);

// Get distance in different units
$miles = $distanceCalculator->miles();
$kilometers = $distanceCalculator->kilometers();
$meters = $distanceCalculator->meters();
```

### Geofencing
```php
// Create a geofence
$geofenceManager = app(GeofenceManager::class);

$geofence = $geofenceManager->createGeofence([
    'name' => 'Office Area',
    'coordinates' => [
        [37.4224764, -122.0842499],
        [37.4224764, -122.0800000],
        [37.4200000, -122.0800000],
        [37.4200000, -122.0842499]
    ],
    'radius' => 100 // meters
]);

// Check if a point is within a geofence
if ($geofenceManager->isPointInGeofence($latitude, $longitude, $geofence)) {
    // User is within the geofence
    event(new UserEnteredGeofence($user, $geofence));
}
```

## Mapping Features

### Interactive Maps
- **Custom Markers**: Add custom icons and markers
- **Info Windows**: Display information when clicking markers
- **Overlays**: Add custom overlays and polygons
- **Controls**: Zoom, pan, and navigation controls
- **Layers**: Multiple map layers and tile sources

### Spatial Queries
```php
// Find locations within a radius
$nearbyLocations = Location::withinRadius($latitude, $longitude, $radiusInKm)->get();

// Find locations within a polygon
$polygonCoordinates = [
    [37.4224764, -122.0842499],
    [37.4224764, -122.0800000],
    [37.4200000, -122.0800000],
    [37.4200000, -122.0842499]
];

$locationsInPolygon = Location::withinPolygon($polygonCoordinates)->get();
```

## Location Tracking
1. **Real-time Tracking**: Live location updates
2. **Location History**: Store and retrieve location history
3. **Movement Analysis**: Analyze movement patterns
4. **Speed Calculation**: Calculate movement speed
5. **Direction Detection**: Determine direction of travel

## Performance Optimization
1. **Caching**: Cache geocoding results and map tiles
2. **Batch Processing**: Process multiple locations in batches
3. **Spatial Indexing**: Use database spatial indexes for queries
4. **Lazy Loading**: Load maps only when needed
5. **Compression**: Compress location data for storage

## Best Practices
1. **Rate Limiting**: Respect API rate limits for geocoding services
2. **Caching Strategy**: Implement smart caching for frequently accessed locations
3. **Privacy Considerations**: Handle location data securely and with user consent
4. **Accuracy Management**: Handle varying levels of location accuracy
5. **Error Handling**: Gracefully handle geocoding failures and timeouts

## Related Modules
- [Xot Module](../Xot/docs/index.md) - Core base classes
- [User Module](../User/docs/README.md) - User authentication and management
- [Activity Module](../Activity/docs/index.md) - Activity logging
- [Notify Module](../Notify/docs/index.md) - Notification system

## Troubleshooting
Common issues and solutions:
- Geocoding API quota exceeded
- Map rendering issues
- Location accuracy problems
- Geofence boundary errors