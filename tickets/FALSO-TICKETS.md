# FALSO 2.0 Open Architecture Tickets

## TICKET-01: Legacy Archive 301 Redirection & Permalinks Preservation
- **Owner**: Backend Architect
- **Status**: Ready
- **Specification**: Ensure all historical URLs (`https://falso.ly/archives/{id}`, `https://falso.ly/{postname}`) resolve with 301 permanent redirects to new investigation URLs, avoiding SEO indexing loss and maintaining historical trust.

## TICKET-02: Citizen Claims Intake REST API & Nonce Barrier
- **Owner**: API Engineer
- **Status**: Implemented (`falso-engine/includes/class-claim-api.php`)
- **Specification**: `POST /wp-json/falso/v1/claims/submit` with mandatory input sanitization, forced `pending` review status, rate limiting, and action hooks for async downstream alerts.

## TICKET-03: Make.com AI Triage Pipeline & HMAC Authentication
- **Owner**: Integration Specialist
- **Status**: Implemented (`falso-engine/includes/class-ai-webhook.php`)
- **Specification**: Secure incoming webhook receiving automated hate speech indicators, sentiment, and entity tags. Validates payload integrity via `X-Falso-Signature` using HMAC-SHA256 with constant-time string comparison (`hash_equals`).

## TICKET-04: Editorial RBAC & Human-in-the-Loop Capabilities
- **Owner**: Security & Core Engineer
- **Status**: Implemented (`falso-engine/falso-engine.php`)
- **Specification**: Distinct capability sets for `falso_investigator` (investigative rights, publishing) versus `falso_contributor` (draft submission only). Enforces that AI or community inputs cannot alter live verdicts without verified editorial sign-off.

## TICKET-05: Schema.org ClaimReview Fact Check Engine
- **Owner**: SEO & Structured Data Specialist
- **Status**: Implemented (`falso-engine/includes/class-schema-claimreview.php`)
- **Specification**: Dynamic JSON-LD output containing `@type: ClaimReview`, mapping Arabic ratings (`صحيح`, `زائف`, `مضلل`) to Google Fact Check Explorer standards (1 to 5 numeric scale) with canonical publication attribution.

## TICKET-06: Libyan Regional Fact-Checking Taxonomies & Fast Blocks
- **Owner**: Frontend Architect
- **Status**: Implemented (`falso-engine/includes/class-post-types.php`)
- **Specification**: Taxonomies for regional geographic filtering (`falso_region`: طرابلس, بنغازي, مصراتة, سبها, الجنوب, الشرق, الغرب) with bidirectional RTL layout and zero jQuery frontend dependencies.

## TICKET-07: E2E Playwright Army Tester Suite & Axe-Core Quality Gate
- **Owner**: Test Lead
- **Status**: Implemented (`falso-engine/tests/falso-workflow.spec.js`)
- **Specification**: Automated browser and API journeys validating citizen claim creation, ClaimReview schema emission, RTL HTML direction flags, and WCAG 2.2 AA accessibility scans.
