import { createRequire } from 'module';
import path from 'path';

const require = createRequire(import.meta.url);
const { chromium } = require('D:/hermes/hermes-agent/node_modules/playwright');

const BASE_URL = 'http://127.0.0.1:8890';
const SCREENSHOT_DIR = path.resolve('tests/screenshots');

async function runHumanE2ESuite() {
  console.log('=== STARTING HUMAN-SIMULATION E2E VERIFICATION SUITE ===');
  console.log(`Target Platform: ${BASE_URL}\n`);

  const browser = await chromium.launch({
    executablePath: 'D:/hermes/ms-playwright/chromium-1234/chrome-win64/chrome.exe',
    headless: true,
  });

  const context = await browser.newContext({
    viewport: { width: 1280, height: 800 },
    locale: 'ar-SA',
    userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36'
  });

  const page = await context.newPage();

  try {
    // -------------------------------------------------------------
    // JOURNEY 1: Homepage Navigation & Citizen Community Feed
    // -------------------------------------------------------------
    console.log('[STEP 1] Human visitor lands on Homepage (الرئيسية)...');
    await page.goto(`${BASE_URL}/`, { waitUntil: 'networkidle' });

    const htmlDir = await page.getAttribute('html', 'dir');
    const htmlLang = await page.getAttribute('html', 'lang');
    console.log(`  -> HTML Direction: ${htmlDir} | Language: ${htmlLang}`);
    if (htmlDir !== 'rtl') throw new Error(`Expected dir="rtl", got "${htmlDir}"`);

    const pageTitle = await page.title();
    console.log(`  -> Page Title: "${pageTitle}"`);

    const headerLogo = await page.textContent('.logo');
    console.log(`  -> Brand Header: "${headerLogo?.trim()}"`);

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '1-homepage.png') });
    console.log('  [PASS] Screenshot saved: 1-homepage.png\n');

    // -------------------------------------------------------------
    // JOURNEY 2: Submitting a Citizen Claim through the Web Form
    // -------------------------------------------------------------
    console.log('[STEP 2] Human clicks "أرسل ادعاءً" to report disinformation...');
    await page.click('nav a.btn-submit');
    await page.waitForURL(`${BASE_URL}/submit`);

    const formHeading = await page.textContent('h1');
    console.log(`  -> Form Heading: "${formHeading?.trim()}"`);

    console.log('  -> Typing claim content in Arabic...');
    await page.fill('#claimText', 'ادعاء متداول على فيسبوك يفيد بقطع إمدادات مياه النهر الصناعي عن طرابلس');
    await page.fill('#sourceUrl', 'https://facebook.com/fake-post-libya-today');
    await page.selectOption('#region', 'طرابلس');

    console.log('  -> Clicking submit button ("إرسال للتحقق")...');
    await page.click('button[type="submit"]');

    // Wait for the dynamic AJAX result alert box to appear
    const resultBox = page.locator('#resultBox');
    await resultBox.waitFor({ state: 'visible', timeout: 5000 });

    const resultText = await resultBox.textContent();
    console.log(`  -> Submission Result Alert:\n     "${resultText?.trim()}"`);

    if (!resultText?.includes('تم استلام الادعاء بنجاح')) {
      throw new Error('Submission confirmation message not found in alert box!');
    }

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '2-claim-submitted-success.png') });
    console.log('  [PASS] Screenshot saved: 2-claim-submitted-success.png\n');

    // -------------------------------------------------------------
    // JOURNEY 3: Inspecting a Published Fact-Check Investigation
    // -------------------------------------------------------------
    console.log('[STEP 3] Human opens a published Fact-Check Investigation...');
    await page.click('nav a:has-text("أحدث التحقيقات")');
    await page.waitForURL(`${BASE_URL}/investigations/mitiga-airport-claim`);

    const verdictBadge = page.locator('.badge-verdict');
    await verdictBadge.waitFor({ state: 'visible' });
    const verdictText = await verdictBadge.textContent();
    console.log(`  -> Verdict Badge: [${verdictText?.trim()}]`);

    const investigationTitle = await page.textContent('h1');
    console.log(`  -> Investigation Title: "${investigationTitle?.trim()}"`);

    const evidenceItems = await page.locator('.evidence-box ul li').allTextContents();
    console.log(`  -> Evidence Items (${evidenceItems.length} recorded):`);
    evidenceItems.forEach((item, i) => console.log(`     ${i + 1}. ${item.trim()}`));

    // Inspect Schema.org ClaimReview JSON-LD embedded in the live DOM
    const schemaScript = await page.locator('script[type="application/ld+json"]').textContent();
    if (!schemaScript) throw new Error('Schema.org JSON-LD script not found on investigation page!');

    const schemaObj = JSON.parse(schemaScript);
    console.log('\n  -> Live Schema.org Validation:');
    console.log(`     @type: ${schemaObj['@type']}`);
    console.log(`     claimReviewed: "${schemaObj.claimReviewed}"`);
    console.log(`     ratingValue: ${schemaObj.reviewRating?.ratingValue} (${schemaObj.reviewRating?.alternateName})`);
    console.log(`     publisher: ${schemaObj.author?.name}`);

    if (schemaObj['@type'] !== 'ClaimReview' || schemaObj.reviewRating?.ratingValue !== '1') {
      throw new Error('ClaimReview schema structure does not match Google Fact Check standards!');
    }

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '3-investigation-view.png') });
    console.log('  [PASS] Screenshot saved: 3-investigation-view.png\n');

    // -------------------------------------------------------------
    // JOURNEY 4: Mobile Viewport & RTL Layout Boundary Check
    // -------------------------------------------------------------
    console.log('[STEP 4] Testing Mobile Experience (iPhone 14, 390x844)...');
    await page.setViewportSize({ width: 390, height: 844 });
    await page.reload({ waitUntil: 'networkidle' });

    // Ensure no horizontal scroll blowout
    const isOverflowing = await page.evaluate(() => {
      return document.documentElement.scrollWidth > document.documentElement.clientWidth;
    });
    console.log(`  -> Mobile Horizontal Scroll Overflow: ${isOverflowing ? 'FAIL (Horizontal Overflow)' : 'PASS (Clean RTL Wrap)'}`);

    if (isOverflowing) {
      throw new Error('Mobile viewport has horizontal layout overflow!');
    }

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '4-mobile-rtl-view.png') });
    console.log('  [PASS] Screenshot saved: 4-mobile-rtl-view.png\n');

    console.log('=== ALL HUMAN JOURNEYS PASSED WITH ZERO ERRORS ===');
  } finally {
    await browser.close();
  }
}

runHumanE2ESuite().catch(err => {
  console.error('\n[HUMAN E2E SUITE FAILED]:', err);
  process.exit(1);
});
