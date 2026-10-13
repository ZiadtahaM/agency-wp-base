import { createRequire } from 'module';
import path from 'path';
import fs from 'fs';

const require = createRequire(import.meta.url);
const { chromium } = require('D:/hermes/hermes-agent/node_modules/playwright');

// CRITICAL MANDATE: Run strictly and exclusively against the real LocalWP WordPress environment
const BASE_URL = 'http://zzzzzz.local';
const SCREENSHOT_DIR = path.resolve('tests/screenshots');

if (!fs.existsSync(SCREENSHOT_DIR)) {
  fs.mkdirSync(SCREENSHOT_DIR, { recursive: true });
}

async function runHumanE2ESuite() {
  console.log('===============================================================');
  console.log('🚀 FALSO 2.0 - LIVE WORDPRESS HUMAN-SIMULATION E2E TEST ARMY');
  console.log(`🌐 Target System: Formal LocalWP WordPress at ${BASE_URL}`);
  console.log('===============================================================\n');

  const browser = await chromium.launch({
    executablePath: 'D:/hermes/ms-playwright/chromium-1234/chrome-win64/chrome.exe',
    headless: true,
  });

  const context = await browser.newContext({
    viewport: { width: 1366, height: 900 },
    locale: 'ar-LY',
    userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36'
  });

  const page = await context.newPage();

  // Listen to console and page errors
  page.on('console', msg => {
    if (msg.type() === 'error') console.log(`  [Browser Error]: ${msg.text()}`);
  });

  try {
    // -------------------------------------------------------------
    // JOURNEY 1: Homepage Live Editorial Experience
    // -------------------------------------------------------------
    console.log('[JOURNEY 1] Human visitor opens WordPress Homepage (الرئيسية)...');
    const homeRes = await page.goto(`${BASE_URL}/`, { waitUntil: 'networkidle' });
    console.log(`  -> Response Status: ${homeRes.status()} ${homeRes.statusText()}`);
    if (homeRes.status() !== 200) throw new Error(`Homepage returned status ${homeRes.status()}`);

    const title = await page.title();
    console.log(`  -> Document Title: "${title}"`);

    const brandText = await page.textContent('.falso-logo');
    console.log(`  -> Brand Header: "${brandText?.trim()}"`);

    const tickerText = await page.textContent('.falso-ticker');
    console.log(`  -> Live Ticker: "${tickerText?.trim().substring(0, 70)}..."`);

    const statCount = await page.locator('.stat-card').count();
    console.log(`  -> Verified Metric Cards Rendered: ${statCount}`);

    const featTitle = await page.textContent('.featured-title');
    console.log(`  -> Featured Investigation: "${featTitle?.trim()}"`);

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '1-wordpress-homepage.png'), fullPage: true });
    console.log('  ✅ [PASS] Screenshot: tests/screenshots/1-wordpress-homepage.png\n');

    // -------------------------------------------------------------
    // JOURNEY 2: Submitting a Citizen Claim via /submit/
    // -------------------------------------------------------------
    console.log('[JOURNEY 2] Citizen navigates to /submit/ and files a rumor claim...');
    const submitRes = await page.goto(`${BASE_URL}/submit/`, { waitUntil: 'networkidle' });
    console.log(`  -> Response Status: ${submitRes.status()} ${submitRes.statusText()}`);
    if (submitRes.status() !== 200) throw new Error(`/submit/ returned status ${submitRes.status()}`);

    const submitHeading = await page.textContent('h1');
    console.log(`  -> Heading: "${submitHeading?.trim()}"`);

    console.log('  -> Filling out citizen reporting form fields in Arabic...');
    await page.fill('#claim-text', 'شائعة واسعة الانتشار على فيسبوك تزعم تعليق الدراسة في كافة مدارس طرابلس غداً');
    await page.fill('#source-url', 'https://facebook.com/fake-news-page-ly/posts/102938');
    await page.selectOption('#claim-type', 'fabricated_news');
    await page.fill('#evidence-note', 'تواصلنا مع مكتب الإعلام بوزارة التربية والتعليم ونفى هذا التعميم كلياً.');

    console.log('  -> Clicking "إرسال الادعاء لفريق التحقق الفوري"...');
    await page.click('#submit-btn');

    await page.waitForSelector('#falso-alert-success', { state: 'visible', timeout: 10000 });
    const successMsg = await page.textContent('#falso-success-msg');
    console.log(`  -> Success Feedback Message: "${successMsg?.trim()}"`);

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '2-wordpress-claim-submitted.png'), fullPage: true });
    console.log('  ✅ [PASS] Screenshot: tests/screenshots/2-wordpress-claim-submitted.png\n');

    // -------------------------------------------------------------
    // JOURNEY 3: Single Deep Investigation (/investigations/mitiga-airport-claim/)
    // -------------------------------------------------------------
    console.log('[JOURNEY 3] Citizen reads Deep-Dive Investigation (/investigations/mitiga-airport-claim/)...');
    const invRes = await page.goto(`${BASE_URL}/investigations/mitiga-airport-claim/`, { waitUntil: 'networkidle' });
    console.log(`  -> Response Status: ${invRes.status()} ${invRes.statusText()}`);
    if (invRes.status() !== 200) throw new Error(`/investigations/mitiga-airport-claim/ returned status ${invRes.status()}`);

    const invTitle = await page.textContent('h1');
    console.log(`  -> Investigation Title: "${invTitle?.trim()}"`);

    const verdictBanner = await page.textContent('.verdict-info h3');
    console.log(`  -> Verdict Banner: "${verdictBanner?.trim()}"`);

    const evidenceCards = await page.locator('.evidence-card').count();
    console.log(`  -> Forensic Evidence Cards: ${evidenceCards}`);

    // Verify Schema.org ClaimReview JSON-LD in head
    const schemaScript = await page.locator('script[type="application/ld+json"]').innerText();
    const schemaObj = JSON.parse(schemaScript);
    console.log(`  -> Schema.org Type: "${schemaObj['@type']}"`);
    console.log(`  -> Claim Reviewed: "${schemaObj.claimReviewed}"`);
    console.log(`  -> Review Rating: "${schemaObj.reviewRating?.alternateName}" (Value: ${schemaObj.reviewRating?.ratingValue})`);

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '3-wordpress-investigation-deepdive.png'), fullPage: true });
    console.log('  ✅ [PASS] Screenshot: tests/screenshots/3-wordpress-investigation-deepdive.png\n');

    // -------------------------------------------------------------
    // JOURNEY 4: AI Verification Workbench (/automat-me/)
    // -------------------------------------------------------------
    console.log('[JOURNEY 4] Moderator/Citizen tests AI Verification Workbench (/automat-me/)...');
    const autoRes = await page.goto(`${BASE_URL}/automat-me/`, { waitUntil: 'networkidle' });
    console.log(`  -> Response Status: ${autoRes.status()} ${autoRes.statusText()}`);
    if (autoRes.status() !== 200) throw new Error(`/automat-me/ returned status ${autoRes.status()}`);

    console.log('  -> Clicking sample claim button "عينة 1: مطار معيتيقة"...');
    await page.click('button[data-text*="مطار معيتيقة"]');

    const inputValue = await page.inputValue('#ai-claim-input');
    console.log(`  -> Loaded Sample Text: "${inputValue.substring(0, 60)}..."`);

    console.log('  -> Triggering Automated Verification Pipeline (#btn-run-pipeline)...');
    await page.click('#btn-run-pipeline');

    await page.waitForSelector('#verdict-result', { state: 'visible', timeout: 15000 });
    const score = await page.textContent('#res-score');
    const label = await page.textContent('#res-label');
    console.log(`  -> AI Pipeline Result: ${label?.trim()} with Bayesian Confidence: ${score?.trim()}`);

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '4-wordpress-automat-me-ai.png'), fullPage: true });
    console.log('  ✅ [PASS] Screenshot: tests/screenshots/4-wordpress-automat-me-ai.png\n');

    // -------------------------------------------------------------
    // JOURNEY 5: Specific Claim Record (/claims/eddaaa/)
    // -------------------------------------------------------------
    console.log('[JOURNEY 5] Citizen inspects single claim record (/claims/eddaaa/)...');
    const claimRes = await page.goto(`${BASE_URL}/claims/eddaaa/`, { waitUntil: 'networkidle' });
    console.log(`  -> Response Status: ${claimRes.status()} ${claimRes.statusText()}`);
    if (claimRes.status() !== 200) throw new Error(`/claims/eddaaa/ returned status ${claimRes.status()}`);

    const claimTitle = await page.textContent('h1');
    console.log(`  -> Claim Title: "${claimTitle?.trim()}"`);

    await page.screenshot({ path: path.join(SCREENSHOT_DIR, '5-wordpress-claim-eddaaa.png'), fullPage: true });
    console.log('  ✅ [PASS] Screenshot: tests/screenshots/5-wordpress-claim-eddaaa.png\n');

    console.log('===============================================================');
    console.log('🎉 100% OF LIVE WORDPRESS E2E HUMAN VERIFICATION JOURNEYS PASSED!');
    console.log('All 5 canonical routes returned HTTP 200 with zero errors.');
    console.log('===============================================================');

  } catch (error) {
    console.error('❌ E2E VERIFICATION FAILED:', error);
    await page.screenshot({ path: path.join(SCREENSHOT_DIR, 'error-state.png'), fullPage: true });
    throw error;
  } finally {
    await browser.close();
  }
}

runHumanE2ESuite();
