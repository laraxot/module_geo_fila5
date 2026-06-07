// Get address from coordinates
$address = LocationService::getAddress(41.9028, 12.4964);
```

### Map Components
```php
use Modules\Geo\Filament\MapPicker;

// In Filament form
MapPicker::make('location')
    ->defaultLocation(41.9028, 12.4964)
    ->zoom(12);
```

## UI/UX Best Practices

### Map Components
- Always show loading state
- Provide clear error messages
- Use appropriate zoom levels
- Add map controls (zoom, fullscreen)
- Implement responsive design
- Add accessibility features

### Performance Optimization
- Lazy load map scripts
- Cache API responses
- Use web workers for heavy computations
- Optimize map markers
- Implement debouncing for search

## Troubleshooting

### Common Issues
1. **Maps not loading**
   - Verify API key
   - Check browser console for errors
   - Verify domain restrictions

2. **Slow performance**
   - Reduce number of markers
   - Implement clustering
   - Use caching

3. **UI glitches**
   - Check CSS conflicts
   - Verify component lifecycle
   - Test on multiple devices

## Examples

### Basic Map Integration
```php
use Modules\Geo\Filament\MapComponent;

MapComponent::make()
    ->center(41.9028, 12.4964)
    ->markers([
        ['lat' => 41.9028, 'lng' => 12.4964, 'title' => 'Rome']
    ]);
```

### Advanced Usage
```php
// Custom map styles
$styles = [
    // Custom style configuration
];

MapComponent::make()
    ->styles($styles)
    ->controls(['zoom', 'fullscreen'])
    ->interactive(true);
```

## Changelog
See GitHub repository for full changelog.
---
module: theme
topic: comprehensive-guide
canonical: ../../../Themes/docs/shared-components/COMPREHENSIVE_GUIDE.md
---

See canonical documentation: ../../../Themes/docs/shared-components/COMPREHENSIVE_GUIDE.md