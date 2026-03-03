# Seo - Product Requirements Document (PRD)

> **Version**: 1.0.0
> **Last Updated**: 2026-03-03
> **Status**: Approved
> **Owner**: Seo Module Team

## 1. Purpose & Vision
The Seo module provides a comprehensive **search engine optimization framework** for the Laraxot ecosystem. it enables dynamic management of meta tags, social share information, sitemaps, and robots.txt, ensuring maximum visibility for public-facing application pages.

## 2. Problem Statement
Web applications need:
- Dynamic meta tags (title, description, keywords) for every page.
- Social media optimization (OpenGraph, Twitter cards).
- Automated sitemap generation.
- Control over crawling through robots.txt.
- Friendly URL management.

## 3. Target Users
| User | Role | Needs |
|------|------|-------|
| **Marketing Manager** | SEO Specialist | Optimize page metadata, track visibility. |
| **End User** | Visitor | Better search results and social share previews. |
| **Developer** | Module Builder | Standardized way to inject SEO tags into headers. |

## 4. Scope
### In Scope
- Management of meta tags for any model or static page.
- OpenGraph and Twitter card metadata.
- Automated and dynamic XML sitemaps.
- robots.txt management.
- Integration with Blade templates for header injection.

### Out of Scope
- Keyword ranking tracking (delegated to external tools like Ahrefs/Semrush).
- Content quality analysis (AI-assisted features are future phase).

## 5. Functional Requirements (Prioritized)

### P0: Metadata Foundation (Must-have)
- **FR-001: Dynamic Metadata Management**: Assign and edit custom titles, descriptions, and keywords for any route or Eloquent resource via Filament.
- **FR-002: Social Graph Optimization**: Centralized management of OpenGraph and Twitter card metadata, including share images and specific descriptions.
- **FR-005: Header Injection Logic**: Standardized Blade components to inject optimized SEO tags into the `<head>` section of any theme.

### P1: Indexing & Crawling (Important)
- **FR-003: Dynamic Sitemap Engine**: Automated generation of XML sitemaps including all public-facing module resources.
- **FR-004: Robots.txt Control**: Administrative interface to manage `robots.txt` content and crawling directives.

### P2: Advanced Visibility (Nice-to-have)
- **FR-006: Schema.org Structured Data**: Automated generation of JSON-LD structured data for personnel, organizations, and events.
- **FR-007: AI Metadata Suggestions**: Automated generation of SEO titles and descriptions based on page content analysis.

## 6. Non-Functional Requirements & Agnostic Design

### Agnostic Design Principles
- **Agnostic SEO Service**: Seo provides the metadata delivery layer; it MUST NOT be aware of the specific business domain of the pages it tags.
- **Interoperability**: Provides a polymorphic relationship that allows ANY model in ANY module to become "SEO-enabled" by attaching the SEO trait.
- **Independence**: Metadata generation is decoupled from the content creation lifecycle to avoid performance overhead.

### Performance & Safety
- **NFR-001: Performance**: Metadata resolution and injection MUST add < 1ms to the total page load time.
- **NFR-002: Standards Compliance**: Strict adherence to current OpenGraph, Twitter, and Schema.org protocols.
- **NFR-003: Type Safety**: 100% PHPStan Level 10 compliance.

## 7. Technical Architecture
### Dependencies
- **Xot**: Base infrastructure.
- **UI**: Components for header injection.
### Data Model
- SEO table (polymorphic) to link metadata to any subject model.
### Integration Points
- Applied to `User` profiles, `Performance` reports (if public), and custom landing pages.

## 8. User Experience
- Simple SEO tab on every relevant Filament resource.
- Live preview of how the result might look in Google.

## 9. Success Metrics & KPIs
| Metric | Target | Measurement |
|--------|--------|-------------|
| SEO Coverage | 100% Public Pages | Audit of public routes. |
| Sitemap Validity | Zero Errors | Search Console report. |
| PHPStan Compliance | Level 10 | Static analysis. |

## 10. Risks & Assumptions
### Assumptions
- All public pages are reachable by crawlers.
- Meta tags are the primary SEO mechanism.
### Risks
| Risk | Impact | Mitigation |
|------|--------|------------|
| Duplicate content | Medium | Canonical tag support. |
| Incorrect indexing | High | Warning system for indexing disabled pages. |

## 11. Dependencies & Constraints
- Must stay up-to-date with changing search engine guidelines.

## 12. Release Plan
### Phase 1: Core Tagging (Stable)
- Meta and Social tag management. ✅
- robots.txt editor. ✅
### Phase 2: Automated Sitemaps (Planned)
- Fully dynamic sitemap engine.
- Schema.org structured data support.

## 13. References
- [roadmap.md](roadmap.md)
