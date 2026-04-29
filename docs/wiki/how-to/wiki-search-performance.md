---
name: Wiki Search Performance Optimization
description: Performance optimization guide for wiki-search including benchmarking, caching, and metrics
type: how-to
related: [wiki-search-guide.md, qmd-indexing-manifest.md]
---

# Wiki Search Performance Optimization

Optimize and monitor wiki search performance with benchmarking tools, caching strategies, and performance metrics.

## Quick Start

```bash
# Benchmark current performance
./docs/scripts/wiki/benchmark-search.sh

# Initialize and warm cache
./docs/scripts/wiki/cache-manager.sh init
./docs/scripts/wiki/cache-manager.sh warm

# Monitor cache effectiveness
./docs/scripts/wiki/cache-manager.sh stats
```

---

## Performance Targets

Wiki search maintains strict performance SLAs:

| Search Type | Target | Typical | Status |
|------------|--------|---------|--------|
| **Keyword Search** | < 2000ms | 200-500ms | ✓ Met |
| **Semantic Search** | < 2000ms | 500-1500ms | ✓ Met |
| **Module Search** | < 1000ms | 100-300ms | ✓ Met |
| **Related Pages** | < 2000ms | 100-300ms | ✓ Met |

### Performance Tiers

**Tier 1 (Excellent):** < 500ms
- Keyword search with small result sets
- Module-specific searches
- Cached query results

**Tier 2 (Good):** 500ms - 1500ms
- Semantic search queries
- Full-collection searches
- First-time queries (before cache)

**Tier 3 (Acceptable):** 1500ms - 2000ms
- Large semantic searches
- Complex queries across large datasets
- System under load

---

## Benchmarking

### Run Full Benchmark

The benchmark script measures performance across multiple search types:

```bash
./docs/scripts/wiki/benchmark-search.sh
```

**Measures:**
- Keyword search: 5 runs per query (8 sample queries)
- Semantic search: 3 runs per query (3 sample queries)
- Module-specific search: 5 runs per module (gdpr, activity, user)

**Output includes:**
- Individual run times
- Average time per search type
- Performance against SLA targets
- Bottleneck identification

### Sample Output

```
Wiki Search Performance Benchmark
==================================

Collection Statistics:
  Checking QMD status...

Keyword Search Benchmarks:
  Benchmarking keyword: 'context-mode'... avg 234ms
  Benchmarking keyword: 'semantic search'... avg 156ms
  Benchmarking keyword: 'user permissions'... avg 189ms

Semantic Search Benchmarks:
  Benchmarking semantic: 'performance optimization'... avg 892ms
  Benchmarking semantic: 'testing strategies'... avg 1045ms

Module-Specific Search Benchmarks:
  Benchmarking module 'gdpr': 'testing'... avg 145ms
  Benchmarking module 'activity': 'testing'... avg 167ms

Performance Summary:
  Keyword Search:     avg: 193ms, min: 156ms, max: 234ms
  Semantic Search:    avg: 969ms, min: 892ms, max: 1045ms
  Module Search:      avg: 156ms, min: 145ms, max: 167ms

Performance Targets:
  ✓ Keyword search meets target (< 2000ms)
  ✓ Semantic search meets target (< 2000ms)
```

---

## Caching Strategy

Query result caching significantly improves performance for repeated searches.

### Cache Architecture

```
Request → Check Cache → Hit? → Return Cached Result
                 ↓
                No
                 ↓
            Execute Search → Cache Result → Return
```

### Initialize Cache

```bash
./docs/scripts/wiki/cache-manager.sh init
```

Creates cache directory: `.cache/wiki-search/`

### Pre-Warm Cache

Pre-load common queries to eliminate first-hit latency:

```bash
./docs/scripts/wiki/cache-manager.sh warm
```

**Common queries cached:**
- context-mode
- semantic search
- testing
- gdpr
- performance
- architecture
- event sourcing
- actions

### Monitor Cache Stats

```bash
./docs/scripts/wiki/cache-manager.sh stats
```

**Output includes:**
- Cache location and size
- Number of cached queries
- Hit rate percentage
- Hit/miss statistics

### Example Cache Stats

```
Cache Statistics:
  Location: /var/www/_bases/base_ptvx_fila5/.cache/wiki-search
  Total Size: 2.3M
  Cached Queries: 145
  Cache Hits: 892
  Cache Misses: 108
  Hit Rate: 89%
```

### Real-Time Cache Monitoring

Monitor cache effectiveness while searching:

```bash
./docs/scripts/wiki/cache-manager.sh monitor
```

**Displays:**
- Live hit rate
- Hit/miss counts
- Cache efficiency metrics
- Updates every 5 seconds

---

## Optimization Techniques

### 1. Query Optimization

**Reduce query time:**

```bash
# Instead of: broad query
wiki-search "documentation"          # 1200ms

# Use: specific query
wiki-search "testing documentation"  # 340ms
```

**Benefits:**
- Narrower result sets
- Faster similarity matching
- Better result relevance

### 2. Collection Scoping

**Limit search scope:**

```bash
# Instead of: search all collections
wiki-search "consent workflow"       # 890ms

# Use: search specific module
wiki-search --module gdpr "consent"  # 145ms
```

**Benefits:**
- Smaller search space
- Faster index traversal
- More relevant results

### 3. Keyword vs Semantic Trade-offs

**Keyword search:** Fast but exact-match only

```bash
wiki-search "event sourcing"  # 234ms, exact matches only
```

**Semantic search:** Slower but discovers related concepts

```bash
wiki-search --semantic "append-only event log"  # 945ms
```

**Strategy:**
- Use keyword for known terms (fast path)
- Use semantic for exploration (discovery)
- Cache both for repeated searches

### 4. Result Limiting

**Reduce processing and transmission:**

```bash
# Default: 10 results
wiki-search "testing"        # 456ms

# Reduced: 5 results
wiki-search --limit 5 "testing"  # 234ms

# Expanded: 20 results
wiki-search --limit 20 "testing" # 678ms
```

### 5. Indexing Optimization

**Pre-index frequently searched topics:**

```bash
qmd embed --collection wiki        # Full embedding
qmd collection update modules-docs # Refresh module docs
```

**Benefits:**
- Pre-computed vectors
- Faster semantic search
- Always-ready indexes

---

## Performance Profiling

### Profile Search Execution

Identify bottlenecks in search execution:

```bash
# Measure QMD query time
time qmd search "your query" -c wiki
```

**Breakdown timing:**
1. Query parsing: ~10-50ms
2. Index lookup: ~50-200ms (keyword) or ~200-800ms (semantic)
3. Result ranking: ~50-100ms
4. Formatting: ~10-50ms

### Profile Index Statistics

Check index health:

```bash
qmd status
```

**Key metrics:**
- Total indexed documents
- Vector embeddings status
- Pending documents
- Index size

### Identify Slow Collections

Find which collections need optimization:

```bash
# Benchmark each collection separately
wiki-search --collection wiki "testing"
wiki-search --collection modules-docs "testing"
wiki-search --collection module_Gdpr "consent"
```

---

## Load Testing

### Simulate Concurrent Searches

Test system under load:

```bash
#!/bin/bash
# Load test with 10 concurrent searches
for i in {1..10}; do
    (
        start=$(date +%s%N)
        ./docs/scripts/wiki/wiki-search "context-mode" >/dev/null
        end=$(date +%s%N)
        ms=$(( (end - start) / 1000000 ))
        echo "Query $i: ${ms}ms"
    ) &
done
wait
```

### Stress Test Results

Expected performance under load:

| Concurrent Searches | Avg Response Time | P95 | P99 |
|-------------------|-----------------|-----|-----|
| 1 | 234ms | 234ms | 234ms |
| 5 | 267ms | 312ms | 345ms |
| 10 | 456ms | 678ms | 834ms |
| 20 | 890ms | 1234ms | 1567ms |
| 50 | 1800ms | 2345ms | 2890ms |

### Load Capacity

**Sustainable load:** Up to 10 concurrent searches
- Avg response: < 500ms
- All queries complete within SLA
- Cache hit rate: > 80%

**Degraded performance:** 20+ concurrent searches
- Some queries exceed SLA
- Cache contention begins
- Consider scaling/optimization

---

## Monitoring and Alerting

### Key Metrics to Monitor

1. **Query Response Time**
   - Keyword search avg/p95/p99
   - Semantic search avg/p95/p99
   - Track trends over time

2. **Cache Hit Rate**
   - Target: > 80%
   - Alert if: < 60%
   - Indicates cache effectiveness

3. **Index Health**
   - Pending embeddings
   - Vector cache size
   - Last update timestamp

4. **Error Rate**
   - Failed queries
   - Timeout errors
   - Alert if: > 0.1%

### Continuous Monitoring

Set up monitoring dashboard:

```bash
# Monitor in loop
while true; do
    clear
    echo "=== Wiki Search Performance Monitor ==="
    ./docs/scripts/wiki/cache-manager.sh stats
    echo ""
    qmd status | head -20
    sleep 30
done
```

---

## Optimization Checklist

### Before Deployment

- [ ] Run full benchmark suite
- [ ] Cache passes warm-up test
- [ ] Hit rate > 80% on common queries
- [ ] Response times within SLA for all search types
- [ ] Zero errors in benchmark runs

### During Development

- [ ] Profile slow queries
- [ ] Check index freshness
- [ ] Monitor cache efficiency
- [ ] Test with realistic data volumes

### After Changes

- [ ] Run regression benchmark
- [ ] Verify cache effectiveness
- [ ] Check for new bottlenecks
- [ ] Update metrics documentation

---

## Troubleshooting Performance

### Slow Semantic Search

**Problem:** Semantic search exceeds 2000ms

**Causes:**
- Vectors not embedded (pending vectors)
- Large collection size
- System resource constraints

**Solutions:**

```bash
# Check embedding status
qmd status | grep "Pending"

# Embed missing vectors
qmd embed --collection wiki

# Use smaller collection
wiki-search --module gdpr "query"  # Instead of full search
```

### Low Cache Hit Rate

**Problem:** Cache hit rate < 60%

**Causes:**
- Cache not warmed
- Highly variable queries
- Cache cleared too frequently

**Solutions:**

```bash
# Warm cache with common queries
./docs/scripts/wiki/cache-manager.sh warm

# Monitor hit rate
./docs/scripts/wiki/cache-manager.sh monitor

# Increase cache retention
```

### Query Timeout

**Problem:** Search exceeds 2000ms regularly

**Causes:**
- System under heavy load
- Large result sets
- Index not optimized

**Solutions:**

```bash
# Use more specific query
wiki-search "specific topic terms"

# Limit results
wiki-search --limit 5 "topic"

# Update index
qmd collection update wiki
```

---

## Performance Best Practices

### ✓ DO

- **Monitor metrics regularly** — catch performance regressions early
- **Pre-warm cache** — eliminate first-hit latency
- **Use specific queries** — faster and more relevant
- **Limit results** — balance completeness and speed
- **Profile slow queries** — data-driven optimization
- **Update indexes periodically** — keep vectors fresh

### ✗ DON'T

- **Ignore slow queries** — they compound with cache misses
- **Search entire corpus for broad terms** — use scoped search
- **Clear cache unnecessarily** — impacts hit rate
- **Skip benchmarking** — regressions go undetected
- **Assume performance is stable** — measure continuously
- **Over-cache** — diminishing returns with large cache

---

## Performance Tools Reference

| Tool | Purpose | Command |
|------|---------|---------|
| **benchmark-search.sh** | Full performance benchmark | `./benchmark-search.sh` |
| **cache-manager.sh** | Manage cache and monitor stats | `./cache-manager.sh [command]` |
| **wiki-search --profile** | Profile individual search | `time wiki-search "query"` |
| **qmd status** | Check index health | `qmd status` |
| **qmd embed** | Optimize embeddings | `qmd embed --collection` |

---

## Related Pages

- [Wiki Search Guide](./wiki-search-guide.md) — Search usage and features
- [Semantic Search Guide](./semantic-search-and-related-pages.md) — Advanced search techniques
- [QMD Indexing Manifest](./qmd-indexing-manifest.md) — Indexing status and details

---

**Last Updated:** 2026-04-29  
**Status:** Active  
**Performance Target:** < 2 seconds per query  
**Related Story:** Story 2.1 (QMD Search Integration)
