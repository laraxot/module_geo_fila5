# Geo behavioral contract index

This is the machine-readable inventory of behavioral contracts owned by the **Geo** module.

A contract describes an existing public operation or boundary. It names the owner, input, output, stable invariants, side effects and their order, errors, and non-goals. Every invariant gets a stable ID and a Pest group when a test exists; missing coverage is recorded as debt instead of being implied away.

## Contracts

- [fetch-osm-tile-action](fetch-osm-tile-action.md)
- [get-address-data-from-full-address-action](get-address-data-from-full-address-action.md)
- [get-address-from-google-maps-action](get-address-from-google-maps-action.md)
- [get-address-from-nominatim-action](get-address-from-nominatim-action.md)
- [get-coordinates-action](get-coordinates-action.md)
- [get-coordinates-by-address-action](get-coordinates-by-address-action.md)
- [google-maps-http-action](google-maps-http-action.md)
- [query-nominatim-action](query-nominatim-action.md)
- [update-client-coordinates-bulk-action](update-client-coordinates-bulk-action.md)
- [update-coordinates-action](update-coordinates-action.md)
- [update-coordinates-from-address-action](update-coordinates-from-address-action.md)

## Authoring

Use [Xot contract authoring standard](../../../Xot/docs/contracts/contract-authoring-standard.md) and the shared template. Legacy behavior is documented as-is and is not a model for new code.
