# Story: Geolocalizzazione "Usa la tua posizione" — segnalazione-crea Step 2

## Status: Draft

## Epic
**Epic 1**: Design Comuni Visual Parity — Segnalazione Flow

## Story
As a citizen reporting a service disruption at `/it/tests/segnalazione-crea`,
I want to tap "Usa la tua posizione" to automatically fill the location field with my GPS-derived address,
so that I don't have to manually type the address of the disruption site.

---

## Acceptance Criteria

### AC1: Geolocation Button Fills Location Input
- **Given** I am on step 2 (Dati) of the segnalazione wizard
- **When** I click "Usa la tua posizione"
- **And** I grant browser location permission
- **Then** the location/address input field is populated with my reverse-geocoded address
- **And** the address comes from Nominatim (OpenStreetMap) reverse geocoding

### AC2: Geolocation Error Handling
- **Given** I click "Usa la tua posizione"
- **When** the browser denies location permission OR geolocation fails
- **Then** I see a user-friendly error message (NOT a browser alert)
- **And** the location input remains unchanged
- **And** the error message explains what to do manually

### AC3: Geolocation Unsupported Browser
- **Given** my browser doesn't support the Geolocation API
- **When** I click "Usa la tua posizione"
- **Then** I see a message explaining that geolocation is not supported
- **And** I'm told to enter the address manually

### AC4: URL Step Navigation (step=2)
- **Given** I visit `/it/tests/segnalazione-crea?step=2` directly
- **When** the page loads
- **Then** step 2 (Dati) is displayed as the active step
- **And** the stepper highlights step 2 as "active"
- **And** step 1 (Privacy) shows as "confirmed"

### AC5: GDPR Compliance Before Geolocation
- **Given** I haven't yet accepted the privacy policy
- **When** I attempt to use geolocation on step 2
- **Then** I'm prompted to accept privacy first (since location is personal data)

---

## Dev Technical Guidance — REFERENCE ANALYSIS

### Reference HTML (segnalazione-02-dati.html)

```html
<div class="form-group">
  <label for="luogo">Cerca un luogo*</label>
  <input type="text" class="form-control" id="luogo" name="luogo"
         placeholder="Es. Roma, Via del Corso" required
         data-element="feedback-service-location">
  <a class="btn btn-link position-relative" href="#"
     data-element="feedback-service-geolocation">
    <svg class="icon icon-sm me-1" aria-hidden="true">
      <use href=".../sprites.svg#it-location"></use>
    </svg>
    <span>Usa la tua posizione</span>
  </a>
</div>
```

### Our Current Implementation

File: `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` (step 2)

```blade
<div class="link-wrapper mt-3">
  <a class="list-item active icon-left" href="#">
    <span class="list-item-title-icon-wrapper">
      <svg class="icon icon-sm icon-primary mb-1"><use href="...#it-map-marker"></use></svg>
      <span class="list-item-title t-primary">{{ __('fixcity::segnalazione.fields.use_my_location.label') }}</span>
    </span>
  </a>
</div>
```

**Issues:**
1. Link does nothing — it's a dead `<a href="#">`
2. No `data-element` attributes for accessibility
3. No Alpine.js `@click` handler for geolocation
4. Input field above is `type="text"` with id `address` — needs to be targetable

### Required Implementation Pattern

#### Alpine.js Geolocation Handler

```blade
{{-- Add x-data to the parent container --}}
<div x-data="{
  locationLoading: false,
  locationError: '',
  async getLocation() {
    this.locationLoading = true;
    this.locationError = '';

    if (!navigator.geolocation) {
      this.locationError = '{{ __('fixcity::segnalazione.geolocation.unsupported.label') }}';
      this.locationLoading = false;
      return;
    }

    navigator.geolocation.getCurrentPosition(
      async (position) => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;
        try {
          const res = await fetch(
            'https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lon + '&format=json&accept-language={{ app()->getLocale() }}',
            { headers: { 'User-Agent': 'FixCity/1.0 (segnalazione disservizio)' } }
          );
          const data = await res.json();
          if (data && data.display_name) {
            // Fill the address input
            const input = document.getElementById('address');
            if (input) input.value = data.display_name;
            // Also update Livewire model if possible
            @this.set('address', data.display_name);
          } else {
            this.locationError = '{{ __('fixcity::segnalazione.geolocation.not_found.label') }}';
          }
        } catch (e) {
          this.locationError = '{{ __('fixcity::segnalazione.geolocation.error.label') }}';
        }
        this.locationLoading = false;
      },
      (error) => {
        this.locationLoading = false;
        if (error.code === 1) {
          this.locationError = '{{ __('fixcity::segnalazione.geolocation.permission_denied.label') }}';
        } else if (error.code === 2) {
          this.locationError = '{{ __('fixcity::segnalazione.geolocation.unavailable.label') }}';
        } else {
          this.locationError = '{{ __('fixcity::segnalazione.geolocation.timeout.label') }}';
        }
      },
      { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
    );
  }
}">
```

#### Updated Button HTML

```blade
<div class="link-wrapper mt-3">
  <a class="list-item active icon-left" href="#"
     data-element="feedback-service-geolocation"
     @click.prevent="getLocation()"
     :class="{ 'opacity-50 pointer-events-none': locationLoading }"
     :aria-label="'{{ __('fixcity::segnalazione.geolocation.use_location.aria.label') }}'">
    <span class="list-item-title-icon-wrapper">
      <svg class="icon icon-sm icon-primary mb-1" aria-hidden="true">
        <use x-show="!locationLoading" href="{{ $sprite }}#it-map-marker"></use>
        <svg x-show="locationLoading" class="icon icon-sm icon-primary mb-1 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <circle cx="12" cy="12" r="10" stroke-width="2" stroke-dasharray="31.4 31.4" stroke-linecap="round"/>
        </svg>
      </svg>
      <span class="list-item-title t-primary">{{ __('fixcity::segnalazione.fields.use_my_location.label') }}</span>
    </span>
  </a>
  <div x-show="locationError" x-text="locationError" class="text-danger small mt-2" x-cloak></div>
</div>
```

### File Paths to Modify

1. **Wizard blade template (geolocation logic):**
   - `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`

2. **Translations (new geolocation keys):**
   - `Modules/Fixcity/lang/it/segnalazione.php`
   - `Modules/Fixcity/lang/en/segnalazione.php`

3. **CSS (spinner animation if needed):**
   - Already covered by Tailwind `animate-spin`

### Translation Keys Needed

```php
// it/segnalazione.php
'geolocation' => [
    'use_location' => [
        'aria' => ['label' => 'Usa la tua posizione per compilare automaticamente il campo indirizzo'],
    ],
    'unsupported' => ['label' => 'La geolocalizzazione non è supportata dal tuo browser. Inserisci l\'indirizzo manualmente.'],
    'permission_denied' => ['label' => 'Permesso di geolocalizzazione negato. Consenti l\'accesso alla posizione nelle impostazioni del browser e riprova.'],
    'unavailable' => ['label' => 'Servizio di geolocalizzazione non disponibile. Inserisci l\'indirizzo manualmente.'],
    'timeout' => ['label' => 'Timeout nella richiesta di geolocalizzazione. Riprova o inserisci l\'indirizzo manualmente.'],
    'not_found' => ['label' => 'Indirizzo non trovato. Inserisci l\'indirizzo manualmente.'],
    'error' => ['label' => 'Errore nella geolocalizzazione. Inserisci l\'indirizzo manualmente.'],
],
```

```php
// en/segnalazione.php
'geolocation' => [
    'use_location' => [
        'aria' => ['label' => 'Use your location to automatically fill the address field'],
    ],
    'unsupported' => ['label' => 'Geolocation is not supported by your browser. Please enter the address manually.'],
    'permission_denied' => ['label' => 'Location permission denied. Please allow location access in your browser settings and try again.'],
    'unavailable' => ['label' => 'Location service unavailable. Please enter the address manually.'],
    'timeout' => ['label' => 'Geolocation request timed out. Please try again or enter the address manually.'],
    'not_found' => ['label' => 'Address not found. Please enter the address manually.'],
    'error' => ['label' => 'Geolocation error. Please enter the address manually.'],
],
```

### Step Navigation via URL (?step=2)

The wizard uses Livewire `$currentStep` state. To support `?step=N`:

**Widget PHP:**
```php
// In CreateTicketWizardWidget.php mount() method
public function mount(): void
{
    $step = request()->query('step');
    if ($step && is_numeric($step) && $step >= 1 && $step <= 3) {
        // Only allow navigation to steps that are completed or current
        if ((int)$step <= $this->currentStep) {
            $this->currentStep = (int)$step;
        }
    }
    // ... existing logic
}
```

**Stepper links:**
Make each step in the stepper header clickable (for completed steps):
```blade
@foreach($steps as $index => $stepLabel)
    <li class="{{ ... }}">
        @if($index + 1 < $this->currentStep)
            <a href="{{ url(app()->getLocale() . '/tests/segnalazione-crea?step=' . ($index + 1)) }}" class="text-decoration-none">
                {{ $stepLabel }}
            </a>
        @else
            {{ $stepLabel }}
        @endif
    </li>
@endforeach
```

### Nominatim API Notes

- **Free, no API key required**
- Rate limit: 1 request/second (OK for single use)
- Requires User-Agent header (per Nominatim policy)
- GDPR: User must consent to location sharing
- Response format: `{ "display_name": "Via Roma 1, Milano, MI, Italia", ... }`

---

## Tasks / Subtasks

### Task 1: Add Geolocation Alpine.js Handler (AC: 1, 2, 3, 5)
- [ ] Read `ticket-create-wizard.blade.php` step 2 location section
- [ ] Add `x-data` with `getLocation()` method to the address card container
- [ ] Wire up the "Usa la tua posizione" link with `@click.prevent="getLocation()"`
- [ ] Add loading state (spinner icon swap)
- [ ] Add error display area with `x-show="locationError"`
- [ ] Use `@this.set('address', ...)` to update Livewire model
- [ ] Test with browser permission granted → address filled
- [ ] Test with browser permission denied → error shown
- [ ] Test without geolocation support → unsupported message shown

### Task 2: Add Geolocation Translation Keys (AC: 1, 2, 3)
- [ ] Add `geolocation.*` keys to `lang/it/segnalazione.php`
- [ ] Add `geolocation.*` keys to `lang/en/segnalazione.php`
- [ ] Verify all keys render correctly in blade

### Task 3: Enable URL Step Navigation (AC: 4)
- [ ] Read `CreateTicketWizardWidget.php` mount() method
- [ ] Add `?step=N` query parameter support in mount
- [ ] Validate step number is within valid range (1-3)
- [ ] Only allow navigation to step <= currentStep (can't skip ahead)
- [ ] Test: visit `/it/tests/segnalazione-crea?step=2` → step 2 active
- [ ] Test: visit `/it/tests/segnalazione-crea?step=1` → step 1 active
- [ ] Test: visit `/it/tests/segnalazione-crea?step=5` → defaults to step 1

### Task 4: Make Stepper Steps Clickable for Completed Steps
- [ ] Read stepper header in `ticket-create-wizard.blade.php`
- [ ] Wrap completed step labels in `<a>` tags linking to `?step=N`
- [ ] Current step and future steps remain non-clickable
- [ ] Test clicking completed step navigates correctly

### Task 5: Test and Verify (All AC)
- [ ] Test geolocation on step 2 — address fills correctly
- [ ] Test geolocation denial — friendly error message
- [ ] Test `?step=2` URL — correct step displayed
- [ ] Test `?step=1` URL — privacy step displayed
- [ ] Test stepper links work for completed steps
- [ ] Test on mobile viewport (375px) — geolocation button visible and functional
- [ ] Test language switching — geolocation error messages translate

---

## Risk Assessment

### Implementation Risks
- **Primary Risk**: Nominatim API rate limiting or downtime
- **Mitigation**: Add timeout handling, graceful fallback to manual input
- **Verification**: Test with network throttling in DevTools

### Privacy/GDPR Risks
- **Risk**: Geolocation collects personal data
- **Mitigation**: Only trigger after user clicks button (explicit consent), no automatic tracking
- **Note**: Privacy checkbox on step 1 should cover this

### Rollback Plan
- Git commit before changes
- Remove Alpine x-data handler if geolocation causes issues

### Safety Checks
- [ ] Geolocation only fires on explicit user click
- [ ] No location data sent to server without user action
- [ ] Error messages don't expose technical details
- [ ] Address input still works manually if geolocation fails

---

## Dev Notes

### Reference Pages
- Reference: `https://italia.github.io/design-comuni-pagine-statiche/sito/segnalazione-02-dati.html`
- The reference is a static demo — geolocation doesn't actually work, but the HTML structure and intent are clear

### Nominatim API
- Endpoint: `https://nominatim.openstreetmap.org/reverse?lat={lat}&lon={lon}&format=json`
- Requires User-Agent header
- Free, no API key
- GDPR compliant (no tracking)

### Browser Geolocation API
- `navigator.geolocation.getCurrentPosition(success, error, options)`
- Requires HTTPS in production (localhost works)
- Returns `{ coords: { latitude, longitude, accuracy } }`
- Error codes: 1=permission denied, 2=unavailable, 3=timeout

### File Paths
- Widget view: `Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php`
- Widget PHP: `Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php`
- Translations: `Modules/Fixcity/lang/{locale}/segnalazione.php`

---

## Testing

### Functional Testing
1. Click "Usa la tua posizione" → allow permission → address field fills
2. Click "Usa la tua posizione" → deny permission → error shown
3. Visit `?step=2` → step 2 active, stepper shows step 1 confirmed
4. Visit `?step=1` → privacy step active
5. Click step 1 link in stepper (when on step 2+) → returns to privacy

### Visual Testing
1. Test at 375px — button visible, error message readable
2. Test at 768px — layout matches reference
3. Loading spinner visible during geolocation request

---

## Definition of Done

- [ ] All Tasks and Subtasks marked [x]
- [ ] Geolocation fills address field on permission granted
- [ ] Geolocation shows friendly error on permission denied
- [ ] Geolocation shows unsupported message in old browsers
- [ ] `?step=2` URL navigates to step 2 correctly
- [ ] `?step=1` URL navigates to step 1 correctly
- [ ] Completed steps in stepper are clickable
- [ ] Translations work for IT and EN
- [ ] No console errors in browser
- [ ] GDPR compliance maintained (location only on explicit click)
