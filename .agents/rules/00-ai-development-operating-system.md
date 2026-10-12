# AI Development Operating System: WordPress Client Work

These instructions govern all development inside this repository. They take precedence over any machine-wide distributed-system mandates.

## 1. Architectural Scope and Boundaries
- This repository follows standard WordPress architecture: block theme conventions, theme.json, and custom site plugins.
- Do not introduce distributed datastores, message brokers, Redis requirements, BullMQ, event outbox tables, or multi-tenant database partitioning unless explicitly called for by client requirements.
- Business logic lives inside the site plugin (`plugin/`). Visual styling, templates, and design tokens live inside the block theme (`theme/`).
- Do not edit WordPress core files or third-party vendor directories.

## 2. WordPress Security and Data Integrity
- Check user capabilities with `current_user_can()` on all privileged administrative and REST endpoints.
- Enforce nonce verification (`check_ajax_referer()` or `wp_verify_nonce()`) on all state-changing requests.
- Sanitize all incoming data using standard WordPress helpers (`sanitize_text_field`, `sanitize_key`, `absint`).
- Escape all output at the point of rendering (`esc_html`, `esc_attr`, `esc_url`, `wp_kses_post`).
- Use prepared statements (`$wpdb->prepare()`) for all custom database queries. Never interpolate raw variables into SQL strings.

## 3. Bilingual RTL and Accessibility Invariants
- All layouts must be bidirectional. Use CSS logical properties (`margin-inline-start`, `padding-inline-end`, `inset-inline-start`) instead of left/right directional declarations.
- Wrap all translatable user-facing strings in WordPress i18n functions (`__()`, `_e()`, `_x()`, `_n()`) using the declared text domain.
- Ensure all interactive elements have visible focus indicators, semantic markup, and sufficient color contrast compliant with WCAG 2.2 AA.

## 4. Verification and Reporting Invariants
- A test or check only counts if the command was executed in this environment and the exit code was observed.
- Never report simulated, assumed, or placeholder test passes.
- Distinguish between automated tool results (PHPCS, PHPUnit, Playwright), manual verification passes, and unverified items.
