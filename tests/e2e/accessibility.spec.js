import { test, expect } from '@playwright/test';
import AxeBuilder from '@axe-core/playwright';

test.describe('Accessibility Quality Gate (WCAG 2.2 AA Smoke Scan)', () => {
  const routes = ['/', '/ar/'];

  for (const route of routes) {
    test(`scans route ${route} for serious and critical accessibility violations`, async ({ page }) => {
      await page.goto(route);

      const accessibilityScanResults = await new AxeBuilder({ page })
        .withTags(['wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa', 'wcag22aa'])
        .analyze();

      const violations = accessibilityScanResults.violations.filter(
        v => v.impact === 'critical' || v.impact === 'serious'
      );

      expect(violations).toEqual([]);
    });
  }
});
