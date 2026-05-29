import { test, expect } from '@playwright/test';

test.describe('Segnalazioni elenco — marker icon parity (TicketTypeEnum)', () => {
  test.beforeEach(async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8000/it/tests/segnalazioni-elenco', {
      waitUntil: 'domcontentloaded',
      timeout: 30000,
    });

    test.skip(response === null || !response.ok(), 'App non raggiungibile su :8000');

    await page.waitForSelector('map-lit', { timeout: 10000 });
    await page.waitForSelector('.leaflet-container', { timeout: 25000 });
  });

  test('marker con type_icon_url espone glifo img nel DOM', async ({ page }) => {
    const status = await page.locator('map-lit').evaluate((el) => {
      const markers = Array.isArray(el._allMarkers) ? el._allMarkers : [];
      const withIcon = markers.filter((m) => m.options?.typeIconUrl);
      const samples = withIcon.slice(0, 5).map((m) => ({
        type: m.options.typeValue,
        typeIcon: m.options.typeIcon,
        typeIconUrl: m.options.typeIconUrl,
        typeColor: m.options.typeColor,
      }));

      return {
        total: markers.length,
        withIconUrl: withIcon.length,
        samples,
      };
    });

    if (status.total === 0) {
      test.skip(true, 'Nessun marker nel dataset — rigenerare tickets.json');
    }

    if (status.withIconUrl === 0) {
      test.skip(true, 'GeoJSON senza type_icon_url — eseguire GenerateTicketsJsonAction');
    }

    expect(status.withIconUrl).toBeGreaterThan(0);

    for (const sample of status.samples) {
      const img = page.locator(
        `.geo-map-marker-glyph[src="${sample.typeIconUrl}"]`
      ).first();
      await expect(img).toHaveCount(1, { timeout: 5000 });
    }
  });

  test('almeno due tipi distinti hanno URL icona diversi', async ({ page }) => {
    const distinct = await page.locator('map-lit').evaluate((el) => {
      const markers = Array.isArray(el._allMarkers) ? el._allMarkers : [];
      const byType = new Map();

      markers.forEach((m) => {
        const t = m.options?.typeValue;
        const url = m.options?.typeIconUrl;
        if (t && url && !byType.has(t)) {
          byType.set(t, url);
        }
      });

      return [...byType.entries()];
    });

    if (distinct.length < 2) {
      test.skip(true, 'Servono almeno 2 tipi ticket con coordinate nel DB');
    }

    const urls = new Set(distinct.map(([, url]) => url));
    expect(urls.size).toBeGreaterThanOrEqual(2);
  });

  test('GeoJSON usa struttura type annidata con value, label, color, icon, iconUrl', async ({ request }) => {
    const res = await request.get('http://127.0.0.1:8000/data/tickets.json');
    test.skip(!res.ok(), 'tickets.json non disponibile');

    const data = await res.json();
    test.skip(!data.features || data.features.length === 0, 'Nessun ticket nel JSON');

    // Verifica primo feature abbia struttura annidata
    const first = data.features[0];
    expect(first.properties).toHaveProperty('type');
    expect(typeof first.properties.type).toBe('object');
    expect(first.properties.type).toHaveProperty('value');
    expect(first.properties.type).toHaveProperty('label');
    expect(first.properties.type).toHaveProperty('color');
    expect(first.properties.type).toHaveProperty('icon');
    expect(first.properties.type).toHaveProperty('iconUrl');

    // Verifica icon sia heroicon valido
    expect(first.properties.type.icon).toMatch(/^heroicon-o-[a-z-]+$/);
  });
});
