# Issue Spec: Classic PHP WordPress Theme Refactor

## 1. Problem Statement
The current theme was scaffolded using the WordPress 6.x Full Site Editing (FSE) block standard with `templates/*.html` and `theme.json`. Traditional developers and reviewers expect the Classic PHP WordPress Theme hierarchy with pure PHP templates (`header.php`, `footer.php`, `front-page.php`, `single-*.php`), standard WordPress loop functions, and zero static HTML stubs. Furthermore, the Site Editor lacked editor stylesheet integration.

## 2. Public API / Data Boundary Contract
- Theme Hierarchy:
  - `style.css`: Theme metadata header and core CSS variables.
  - `functions.php`: Theme setup, asset enqueuing, custom post types, and editor styling.
  - `header.php`: Semantic `<head>`, `wp_head()`, navigation bar, and breaking ticker.
  - `footer.php`: Navigation columns, disclaimer, and `wp_footer()`.
  - `front-page.php`: Dynamic homepage querying `falso_investigation` records via `WP_Query`.
  - `single-falso_investigation.php`: Detailed fact-check view reading post meta (`_falso_verdict`, `_falso_region`, `_falso_claim_summary`).
  - `page-submit.php`: Interactive submission form with real `POST` handler storing pending claims in the database.
  - `page-automat-me.php`: Interactive AI triage workbench.
  - `index.php`: Canonical WordPress fallback loop.
- Data Layer:
  - Custom Post Types: `falso_investigation`, `falso_claim`.
  - Post Meta: `_falso_verdict` (fake, misleading, verified), `_falso_region`, `_falso_claim_summary`.

## 3. Acceptance Criteria Checklist
- [ ] AC 1: All `.html` files in `templates/` and `parts/` removed. Theme operates purely via PHP template files.
- [ ] AC 2: `header.php` and `footer.php` cleanly decoupled and called via `get_header()` and `get_footer()`.
- [ ] AC 3: `front-page.php` executes dynamic `WP_Query` on SQLite database to render live investigation cards.
- [ ] AC 4: `single-falso_investigation.php` displays custom metadata with verdict color coding and JSON-LD schema.
- [ ] AC 5: Both frontend (`wp_enqueue_scripts`) and Gutenberg block editor (`add_editor_style`, `enqueue_block_assets`) receive styling.
- [ ] AC 6: Local server on `http://localhost:8888` renders the classic PHP theme without fatal errors.

## 4. Blocked-By / Depends-On DAG
- Step 1: Write Classic Theme PHP files (`header.php`, `footer.php`, `functions.php`, `front-page.php`, `single-falso_investigation.php`, `index.php`, `page-submit.php`, `page-automat-me.php`).
- Step 2: Remove obsolete `templates/`, `parts/`, and `theme.json`.
- Step 3: Deploy to local WordPress root and repository.
- Step 4: Verify live execution and database query results.
