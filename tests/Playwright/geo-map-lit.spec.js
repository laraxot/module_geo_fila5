import { test, expect } from '@playwright/test';

const mapLit = (page) => page.locator('#segnalazioni-elenco-root map-lit#ticket-map');

test.describe('map-lit su /it (STORY-029)', () => {
  test.beforeEach(async ({ page }) => {
    const response = await page.goto('http://127.0.0.1:8000/it', {
      waitUntil: 'networkidle',
      timeout: 30000,
    });
    test.skip(response === null || !response.ok(), 'App non raggiungibile');

    await page.locator('.nav-tabs').getByRole('tab', { name: 'Mappa' }).click();
    await mapLit(page).waitFor({ state: 'visible', timeout: 15000 });
  });

  test('map-lit visibile con altezza minima', async ({ page }) => {
    const box = await mapLit(page).boundingBox();
    expect(box?.height ?? 0).toBeGreaterThan(300);
  });

  test('leaflet inizializza con tile', async ({ page }) => {
    const container = mapLit(page).locator('.leaflet-container');
    await expect(container).toBeVisible({ timeout: 10000 });
    await expect(mapLit(page).locator('.leaflet-tile').first()).toBeVisible({ timeout: 15000 });
  });

  test('marker da tickets.json', async ({ page }) => {
    await mapLit(page).locator('.leaflet-marker-icon').first().waitFor({ timeout: 15000 });
    const count = await mapLit(page).locator('.leaflet-marker-icon').count();
    expect(count).toBeGreaterThan(0);
  });

  test('cluster marker presente a zoom basso', async ({ page }) => {
    await mapLit(page).evaluate((el) => {
      if (el._map) {
        el._map.setZoom(6);
      }
    });
    await page.waitForTimeout(800);
    const cluster = mapLit(page).locator('.marker-cluster, .geo-cluster-wrapper');
    await expect(cluster.first()).toBeVisible({ timeout: 10000 });
  });

  test('filtro checkbox riduce marker visibili', async ({ page }) => {
    test.skip(true, 'Filtri sidebar: coperto da segnalazioni-elenco-filters-parity.spec.js');
  });

  test('responsive al resize viewport', async ({ page }) => {
    const before = await mapLit(page).locator('.leaflet-container').boundingBox();
    await page.setViewportSize({ width: 800, height: 600 });
    await page.waitForTimeout(500);
    const after = await mapLit(page).locator('.leaflet-container').boundingBox();
    expect(after?.width ?? 0).toBeGreaterThanOrEqual(Math.min(before?.width ?? 0, 700));
  });
});
