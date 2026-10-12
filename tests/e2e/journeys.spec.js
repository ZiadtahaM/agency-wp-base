import { test, expect } from '@playwright/test';

test.describe('Bilingual User Journeys and GCC Invariants', () => {
  test('verifies English to Arabic language switch and RTL layout mirroring', async ({ page }) => {
    await page.goto('/');

    const arSwitch = page.locator('[data-testid="lang-switch-ar"], a[hreflang="ar"]');
    if (await arSwitch.isVisible()) {
      await arSwitch.click();
    } else {
      await page.goto('/ar/');
    }

    const html = page.locator('html');
    await expect(html).toHaveAttribute('dir', 'rtl');
    await expect(html).toHaveAttribute('lang', /^ar/);
  });

  test('validates localized lead form submission in Arabic', async ({ page }) => {
    await page.goto('/ar/contact/');

    const form = page.locator('form[data-testid="lead-form"]');
    if (await form.isVisible()) {
      await page.fill('input[name="full_name"]', 'سالم المنصوري');
      await page.fill('input[name="phone"]', '+966501234567');
      await page.fill('input[name="email"]', 'salem@example.com');
      await page.fill('textarea[name="message"]', 'طلب استشارة بخصوص المشروع الجديد');

      await page.click('button[type="submit"]');

      const confirmation = page.locator('[data-testid="form-success"]');
      await expect(confirmation).toBeVisible();
    }
  });

  test('validates international phone formatting in WhatsApp direct links', async ({ page }) => {
    await page.goto('/ar/');

    const whatsappLink = page.locator('a[href*="wa.me"], a[href*="api.whatsapp.com"]');
    if (await whatsappLink.count() > 0) {
      const href = await whatsappLink.first().getAttribute('href');
      expect(href).toMatch(/(wa\.me|api\.whatsapp\.com\/send\?phone=)\d{10,15}/);
    }
  });
});
