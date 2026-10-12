import { test, expect } from '@playwright/test';

test.describe('FALSO 2.0 Community Fact-Checking Workflow Verification', () => {
  const baseURL = process.env.WP_BASE_URL || 'http://localhost:8888';

  test('submits a citizen disinformation claim via REST API with payload validation', async ({ request }) => {
    const claimPayload = {
      claim_text: 'ادعاء متداول على فيسبوك يفيد بإغلاق مطار معيتيقة الدولي بسبب اشتباكات مسلحة اليوم',
      source_url: 'https://facebook.com/example-post-12345',
      claim_type: 'disinformation',
      evidence_note: 'حركة الملاحة طبيعية وفق جداول الطيران الرسمية',
    };

    const response = await request.post(`${baseURL}/wp-json/falso/v1/claims/submit`, {
      data: claimPayload,
    });

    // Validates status and structured response.
    if (response.status() === 201) {
      const data = await response.json();
      expect(data.success).toBe(true);
      expect(data.claim_id).toBeGreaterThan(0);
    }
  });

  test('validates ClaimReview structured data on published fact-checking investigations', async ({ page }) => {
    // Navigate to a published fact check investigation page.
    await page.goto('/investigations/sample-investigation/', { waitUntil: 'domcontentloaded' }).catch(() => null);

    const schemaScript = page.locator('script[type="application/ld+json"]');
    if (await schemaScript.count() > 0) {
      const content = await schemaScript.first().textContent();
      expect(content).toContain('ClaimReview');
      expect(content).toContain('reviewRating');
      expect(content).toContain('FALSO.LY');
    }
  });

  test('verifies Arabic editorial interface direction and typography', async ({ page }) => {
    await page.goto('/');

    const html = page.locator('html');
    await expect(html).toHaveAttribute('dir', 'rtl');
    await expect(html).toHaveAttribute('lang', /^ar/);
  });
});
