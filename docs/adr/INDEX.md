# Geo ADR index

This is the machine-readable inventory of architecture decisions owned by the **Geo** module.

An ADR records a difficult-to-reverse or surprising choice with a real trade-off. It states context, decision drivers, considered options, consequences, and a repeatable confirmation. A new decision supersedes an old one; it does not silently rewrite history.

## Decisions

- [0001-map-components-lit-light-dom](0001-map-components-lit-light-dom.md)
- [0002-geocoding-preferred-provider-with-fallback](0002-geocoding-preferred-provider-with-fallback.md)
- [0003-osm-proxy-tile-nominatim](0003-osm-proxy-tile-nominatim.md)
- [0004-no-service-geo-integrations](0004-no-service-geo-integrations.md)
- [0005-route-cache-includes-proxy](0005-route-cache-includes-proxy.md)

Stub superseded (punta al canonico): [geo-uses-proxy-for-osm](geo-uses-proxy-for-osm.md) → `0003-osm-proxy-tile-nominatim.md`.

## Authoring

Use the shared template and rules in [Xot ADR standards](../../../Xot/docs/adr/README.md). Do not create an ADR for a local implementation detail or an unverified hypothesis.
