import { test, expect } from '@playwright/test';

const baseUrl = process.env.PLAYWRIGHT_BASE_URL ?? 'http://127.0.0.1:8000';

/**
 * STORY-094 — legenda tipologie sulla mappa.
 */
test.describe('map-lit legend', () => {
    test.use({
        geolocation: { latitude: 44.4949, longitude: 11.3426 },
        permissions: ['geolocation'],
        viewport: { width: 1280, height: 900 },
    });

    test('shows legend items from loaded ticket types', async ({ page }) => {
        test.setTimeout(120000);

        await page.goto(`${baseUrl}/it/#`, { waitUntil: 'load', timeout: 90000 });

        await expect
            .poll(
                async () =>
                    page.evaluate(() => document.querySelector('map-lit#block-map')?._allFeatures?.length ?? 0),
                { timeout: 90000 },
            )
            .toBeGreaterThan(0);

        const legend = page.locator('map-lit#block-map .geo-map-legend');
        await expect(legend).toBeVisible({ timeout: 15000 });

        const itemCount = await legend.locator('.geo-map-legend-item').count();
        expect(itemCount).toBeGreaterThan(0);

        const firstColor = legend.locator('.geo-map-legend-color').first();
        await expect(firstColor).toBeVisible();
        const bg = await firstColor.evaluate((el) => getComputedStyle(el).backgroundColor);
        expect(bg).not.toBe('rgba(0, 0, 0, 0)');
    });
});
