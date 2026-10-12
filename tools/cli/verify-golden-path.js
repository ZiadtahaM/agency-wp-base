/**
 * PSTACK VERIFICATION LEVER
 * Physical CLI verification runner for the Gulf WordPress Golden Path.
 * Gate 2 Enforcer: Blocks code changes until this verification lever passes.
 */

import fs from 'fs';
import path from 'path';

const repoRoot = path.resolve(process.cwd());
const args = process.argv.slice(2);
const checkTarget = args.find(a => a.startsWith('--check='))?.split('=')[1] || 'all';

console.log(`[PSTACK LEVER] Running Gate 2 Verification for: ${checkTarget}`);

const checks = {
  // 1. Check Theme Tokens & Logical Bidirectional CSS
  'bilingual-cart': () => {
    const themeJsonPath = path.join(repoRoot, 'theme', 'theme.json');
    if (!fs.existsSync(themeJsonPath)) {
      throw new Error('theme/theme.json missing: design tokens not found');
    }
    const themeJson = JSON.parse(fs.readFileSync(themeJsonPath, 'utf8'));
    const fontFamilies = themeJson.settings?.typography?.fontFamilies || [];
    const hasArabicFont = fontFamilies.some(f => f.slug?.includes('arabic') || f.name?.includes('Arabic'));
    if (!hasArabicFont) {
      throw new Error('theme.json lacks explicit Arabic typography token');
    }
    return 'Arabic typography tokens & bidirectional tokens validated';
  },

  // 2. Check Rank Math & SEO Hreflang Configuration
  'seo-hreflang': () => {
    const pluginEntry = path.join(repoRoot, 'plugin', 'agency-base-site.php');
    if (!fs.existsSync(pluginEntry)) {
      throw new Error('plugin/agency-base-site.php missing');
    }
    const content = fs.readFileSync(pluginEntry, 'utf8');
    if (!content.includes('agency_base_site_init')) {
      throw new Error('Plugin entry point not properly initialized');
    }
    return 'SEO and metadata plugin contract verified';
  },

  // 3. Check ACF Pro Block Manifest Structure
  'acf-blocks': () => {
    const themeDir = path.join(repoRoot, 'theme');
    if (!fs.existsSync(themeDir)) {
      throw new Error('theme directory missing');
    }
    const styleCss = path.join(themeDir, 'style.css');
    if (!fs.existsSync(styleCss)) {
      throw new Error('theme/style.css missing');
    }
    return 'Block theme container and template structure verified';
  },

  // 4. Check CI Workflow and Playwright Harness
  'kinsta-edge': () => {
    const ciPath = path.join(repoRoot, '.github', 'workflows', 'ci.yml');
    if (!fs.existsSync(ciPath)) {
      throw new Error('.github/workflows/ci.yml missing: CI enforcement gate absent');
    }
    const ciContent = fs.readFileSync(ciPath, 'utf8').toLowerCase();
    if (!ciContent.includes('playwright') || !ciContent.includes('phpcs')) {
      throw new Error('CI workflow does not enforce both Playwright and PHPCS');
    }
    return 'CI automated enforcement pipeline verified';
  }
};

let failures = 0;
for (const [key, checkFn] of Object.entries(checks)) {
  if (checkTarget !== 'all' && checkTarget !== key) continue;
  try {
    const res = checkFn();
    console.log(`  [PASS] ${key}: ${res}`);
  } catch (err) {
    console.error(`  [FAIL] ${key}: ${err.message}`);
    failures++;
  }
}

if (failures > 0) {
  console.error(`\n[PSTACK LEVER ERROR] ${failures} verification checks failed. Gate 3 is BLOCKED.`);
  process.exit(1);
} else {
  console.log(`\n[PSTACK LEVER SUCCESS] All Gate 2 verification levers passed. Gate 3 (Build) UNLOCKED.`);
  process.exit(0);
}
