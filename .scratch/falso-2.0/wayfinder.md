# FALSO 2.0 Delivery Decision Map & Architecture Graph

```mermaid
flowchart TD
  subgraph Phase 1: Ingestion & Archive
    T1["TICKET-01: Historical Archive Migration & 301 Permalinks Engine"]
    T2["TICKET-02: REST Claims Ingestion with Rate Limiting & Nonce Barrier"]
  end

  subgraph Phase 2: Processing & Intelligence
    T3["TICKET-03: Make.com / AI Webhook Pipeline with HMAC-SHA256 Auth"]
    T4["TICKET-04: Multi-Tier Role RBAC (Investigator, Fact-Checker, Contributor)"]
  end

  subgraph Phase 3: Editorial & Publishing
    T5["TICKET-05: ClaimReview Schema.org Generator (Google Fact Check Standard)"]
    T6["TICKET-06: Editorial CPTs, Libyan Regional Taxonomies & Fast UI Blocks"]
  end

  subgraph Phase 4: Quality & Verification
    T7["TICKET-07: E2E Playwright Journey Suite & Axe-Core Accessibility Gate"]
  end

  T1 --> T2
  T2 --> T3
  T3 --> T4
  T4 --> T5
  T5 --> T6
  T6 --> T7
```

## Decisions & Boundaries
1. Zero Historical Breakage: Legacy news article URLs from FALSO.LY must map 1:1 via database-level rewrite rules or canonical lookups.
2. Human-in-the-Loop Guarantee: AI scoring outputs (sentiment, hate speech score, entity recognition) are stored strictly as private post meta (`_falso_ai_*`), never as auto-published verdict fields.
3. Google Fact Check Explorer Compliant: Every published investigation automatically embeds a compliant JSON-LD `ClaimReview` graph.
4. Security & Isolation: Public REST API endpoints have rate-limiting barriers. Webhooks from external automation (Make.com) require strict HMAC-SHA256 header validation.
