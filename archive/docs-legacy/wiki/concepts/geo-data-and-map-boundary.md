---
title: "Geo Data and Map Boundary"
type: concept
module: Geo
sources:
  - "../../../README.md"
  - "../../../00-INDEX.md"
confidence: high
created: 2026-10-14
updated: 2026-10-14
tags: [geo, geojson, geocoding, lit, map, fixcity]
related:
  - "../../../../Fixcity/docs/wiki/concepts/ticket-domain-and-public-flow-boundary.md"
  - "../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md"
  - "../../../../../../bmad-output/docs-architecture/ownership.md"
status: draft
qmd: "geo data and map boundary geo"
---

# Geo data and map boundary

`Modules/Geo` owns coordinate data, geocoding actions, validation and reusable map
payloads. A module or theme may consume the contract, but must not reimplement
geocoding or change coordinate order locally.

## Stable contracts

- GeoJSON coordinates are `[longitude, latitude]`.
- Server actions handle geocoding/reverse geocoding and validate payload integrity.
- Lit map components consume the prepared dataset in the browser; they do not
  become the source of truth for ticket filtering.
- Sixteen owns map presentation and CSS integration; Fixcity owns the ticket
  semantics and authorization of the records shown.

## Evidence discipline

Document provider, request context, fallback and privacy impact for every new
geocoding integration. Do not claim a visual fix from source inspection alone:
link the relevant browser evidence and viewport.

## References

- [Fixcity ticket/public-flow boundary](../../../../Fixcity/docs/wiki/concepts/ticket-domain-and-public-flow-boundary.md)
- [Sixteen legal-consent UI boundary](../../../../../Themes/Sixteen/docs/wiki/concepts/legal-consent-ui-boundary.md)
- [Documentation ownership](../../../../../../bmad-output/docs-architecture/ownership.md)

