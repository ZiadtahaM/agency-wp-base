# FEATURE MAP (PSTACK GULF WORDPRESS GOLDEN PATH)

## Golden Path Boundary Contract
Stack: WPML + WooCommerce Multilingual + Rank Math + ACF Pro & Native Blocks + Kinsta (Riyadh `me-riyadh-1` / Dubai `me-dubai-1`)
Runner: Docker wp-env + Playwright bilingual journeys + GitHub Actions CI

---

## Gated Feature Matrix

### [FEATURE-01] Bilingual Commerce & Cart State Invariant
- **Gate 1 (Map)**: User journeys across AR (RTL) and EN (LTR) for WooCommerce cart, checkout, emails, and localized currencies (SAR, AED).
- **Gate 2 (Lever)**: `tools/cli/verify-golden-path.js --check=bilingual-cart`
- **Gate 3 (Build)**: Custom block theme (`theme/`) with logical CSS properties + WPML configuration (`wpml-config.xml`).

### [FEATURE-02] Rank Math SEO & Multilingual Hreflang Contract
- **Gate 1 (Map)**: Localized sitemaps, OpenGraph cards, Product and Organization JSON-LD schemas, and bidirectional hreflang tags.
- **Gate 2 (Lever)**: `tools/cli/verify-golden-path.js --check=seo-hreflang`
- **Gate 3 (Build)**: Site plugin (`plugin/`) hook into Rank Math schema graph ensuring dual-language entity resolution.

### [FEATURE-03] ACF Pro Blocks & Native Block Integrity
- **Gate 1 (Map)**: Custom editorial sections using `acf_register_block_type()` or `block.json`, preserving core WordPress blocks for baseline content.
- **Gate 2 (Lever)**: `tools/cli/verify-golden-path.js --check=acf-blocks`
- **Gate 3 (Build)**: Block manifests under `theme/blocks/` with PHP render templates and zero client-side React compilation overhead.

### [FEATURE-04] Kinsta Regional Staging Probe & CWV Latency Gate
- **Gate 1 (Map)**: Latency and Core Web Vitals targets from Riyadh and Dubai edge nodes. p75 LCP <= 2.5s, INP <= 200ms, CLS <= 0.1.
- **Gate 2 (Lever)**: `tools/cli/verify-golden-path.js --check=kinsta-edge`
- **Gate 3 (Build)**: CDN cache-control headers, WebP/AVIF srcset delivery, zero jQuery runtime dependencies.
