---
name: Wiki Search Troubleshooting Guide
description: Common issues, diagnostics, and solutions for wiki-search and related tools
type: how-to
related: [wiki-search-guide.md, wiki-search-performance.md, wiki-search-accessibility.md]
---

# Wiki Search Troubleshooting Guide

Diagnose and resolve common issues with wiki-search, accessible-search, and related tools.

---

## Quick Diagnostics

### Verify Installation

```bash
# Check wiki-search is executable
ls -la ./docs/scripts/wiki/wiki-search

# Test basic functionality
./docs/scripts/wiki/wiki-search --help

# Verify supporting tools
./docs/scripts/wiki/cache-manager.sh --help
./docs/scripts/wiki/benchmark-search.sh --help
./docs/scripts/wiki/accessible-search.sh --help
```

### Check Project Setup

```bash
# Verify QMD is installed
which qmd

# Check QMD collections are indexed
qmd status

# List indexed collections
qmd status --format json | grep -o '"collection":"[^"]*"'
```

---

## Common Issues and Solutions

### Issue: "No results found" for valid queries

**Symptoms:**
- Search returns no results even for common topics
- Query seems reasonable but yields 0 matches

**Diagnostic steps:**
1. Verify QMD collections are indexed: `qmd status`
2. Check if collection is empty: `qmd query "test" --collection root`
3. Try with simpler terms: `./docs/scripts/wiki/wiki-search "test"`
4. Check if files exist: `find docs/wiki -name "*.md" | wc -l`

**Solutions:**
- **Problem: Collections not indexed** → Run QMD indexing: `qmd index docs/wiki/`
- **Problem: Wrong search scope** → Use module filter: `./docs/scripts/wiki/wiki-search --module gdpr "consent"`
- **Problem: Query too specific** → Simplify query: use fewer keywords, remove technical terms
- **Problem: Semantic index incomplete** → Rebuild index: `qmd index docs/wiki/ --rebuild`

---

### Issue: Search takes too long (> 2000ms)

**Symptoms:**
- Keyword search slow (expected < 2000ms)
- Semantic search very slow (expected < 2000ms)
- Performance degrades over time

**Diagnostic steps:**
1. Benchmark performance: `./docs/scripts/wiki/benchmark-search.sh`
2. Check cache hit rate: `./docs/scripts/wiki/cache-manager.sh stats`
3. Monitor system resources: `top`, `free -h`
4. Profile QMD performance: `time qmd query "testing"`

**Solutions:**
- **Problem: Cache not warmed** → Pre-warm cache: `./docs/scripts/wiki/cache-manager.sh warm`
- **Problem: Too many results** → Limit results: `./docs/scripts/wiki/wiki-search --limit 5 "query"`
- **Problem: System overload** → Run search off-peak, reduce concurrent searches
- **Problem: Large index** → Split collections by module: `./docs/scripts/wiki/wiki-search --module gdpr "consent"`
- **Problem: Semantic index slow** → Use keyword search instead: `./docs/scripts/wiki/wiki-search --keyword "pattern"`

---

### Issue: Cache not working

**Symptoms:**
- Cache hit rate low (< 50%)
- Same query takes same time every time
- Cache directory empty

**Diagnostic steps:**
1. Check cache status: `./docs/scripts/wiki/cache-manager.sh stats`
2. Verify cache directory exists: `ls -la .cache/wiki-search/`
3. Check cache is writable: `touch .cache/wiki-search/test.tmp`
4. Monitor cache during search: `./docs/scripts/wiki/cache-manager.sh monitor &`

**Solutions:**
- **Problem: Cache not initialized** → Initialize: `./docs/scripts/wiki/cache-manager.sh init`
- **Problem: Cache expired** → Clear and reinit: `./docs/scripts/wiki/cache-manager.sh clear && ./docs/scripts/wiki/cache-manager.sh init`
- **Problem: Insufficient disk space** → Free up space: `du -sh .cache/wiki-search/`
- **Problem: Permission denied** → Fix permissions: `chmod -R u+w .cache/wiki-search/`
- **Problem: Cache not warming** → Manually warm: `./docs/scripts/wiki/cache-manager.sh warm`

---

### Issue: Accessibility features not working

**Symptoms:**
- Screen reader doesn't read results
- Keyboard shortcuts don't work
- High contrast mode unreadable
- ARIA labels missing

**Diagnostic steps:**
1. Test with accessible-search: `./docs/scripts/wiki/accessible-search.sh "test"`
2. Check HTML output has ARIA: `./docs/scripts/wiki/accessible-search.sh --format html "test" | grep aria`
3. Verify keyboard navigation: Use Tab key (unplug mouse first)
4. Test with screen reader enabled

**Solutions:**
- **Problem: Using wiki-search instead of accessible-search** → Use accessible version: `./docs/scripts/wiki/accessible-search.sh "query"`
- **Problem: Screen reader not verbose enough** → Use verbose mode: `./docs/scripts/wiki/accessible-search.sh -v "query"`
- **Problem: HTML output not accessible** → Use plain text instead: `./docs/scripts/wiki/accessible-search.sh "query"` (default)
- **Problem: Terminal doesn't support ARIA** → Use browser with HTML output: `./docs/scripts/wiki/accessible-search.sh --format html "query" > results.html`
- **Problem: Colors not readable** → Use text output (no color), increase font size: `./docs/scripts/wiki/accessible-search.sh "query" | less -S`

---

### Issue: Module filtering not working

**Symptoms:**
- `--module gdpr` returns results from all modules
- Module filter ignored
- No filtering effect

**Diagnostic steps:**
1. List available modules: `find laravel/Modules -maxdepth 1 -type d`
2. Check module has documentation: `ls -la laravel/Modules/GDPR/docs/wiki/`
3. Verify module in QMD collections: `qmd status`

**Solutions:**
- **Problem: Module name incorrect case** → Use correct case: `./docs/scripts/wiki/wiki-search --module gdpr "query"` (lowercase)
- **Problem: Module not indexed** → Index module docs: `qmd index laravel/Modules/GDPR/docs/wiki/`
- **Problem: Module docs empty** → Add documentation to module: Create `.md` files in `laravel/Modules/GDPR/docs/wiki/`
- **Problem: Spelling error** → Check module path: `ls laravel/Modules/ | grep -i gdpr`

---

### Issue: Related pages not found

**Symptoms:**
- `--related` flag returns no backlinks
- Cross-references not discovered
- Relationship analysis empty

**Diagnostic steps:**
1. Test wiki-relations directly: `./docs/scripts/wiki/wiki-relations "docs/wiki/how-to/wiki-search-guide.md"`
2. Check page references other pages: `grep -r "\[\[" docs/wiki/`
3. Verify semantic similarity works: `./docs/scripts/wiki/wiki-search "context-mode" --related`

**Solutions:**
- **Problem: No explicit references** → Add [[wiki links]] to pages: `[[ Page Name ]]`
- **Problem: Semantic index not built** → Index documents: `qmd index docs/wiki/ --semantic`
- **Problem: --related not implemented** → Check feature availability: `./docs/scripts/wiki/wiki-search --help`
- **Problem: Wrong query format** → Use correct syntax: `./docs/scripts/wiki/wiki-search --related "query"`

---

### Issue: Help output not showing

**Symptoms:**
- `--help` flag produces no output
- Usage information missing
- Commands unresponsive

**Diagnostic steps:**
1. Check script exists: `ls -la ./docs/scripts/wiki/wiki-search`
2. Check script is executable: `[ -x ./docs/scripts/wiki/wiki-search ] && echo "executable"`
3. Check bash version: `bash --version`
4. Run directly with bash: `bash ./docs/scripts/wiki/wiki-search --help`

**Solutions:**
- **Problem: Script not executable** → Make executable: `chmod +x ./docs/scripts/wiki/wiki-search`
- **Problem: Wrong path** → Use full path: `./docs/scripts/wiki/wiki-search --help`
- **Problem: Bash missing** → Install bash: `apt-get install bash` (Linux) or `brew install bash` (Mac)
- **Problem: Script corrupted** → Verify syntax: `bash -n ./docs/scripts/wiki/wiki-search`

---

### Issue: Tests failing

**Symptoms:**
- `test-suite.sh` shows failing tests
- Some test categories fail, others pass
- Performance tests timeout

**Diagnostic steps:**
1. Run tests with verbose output: `bash -x ./docs/scripts/wiki/test-suite.sh`
2. Check individual test: `./docs/scripts/wiki/wiki-search --help`
3. Review test output: `cat _bmad-output/test-results/*`

**Solutions:**
- **Problem: wiki-search not found** → Verify path: `ls ./docs/scripts/wiki/wiki-search`
- **Problem: Permission denied** → Make executable: `chmod +x ./docs/scripts/wiki/*.sh`
- **Problem: Performance test timeout** → Check system load: `uptime`
- **Problem: Cache test fails** → Clear cache: `./docs/scripts/wiki/cache-manager.sh clear`

---

## Performance Troubleshooting

### Slow Keyword Search

**Check:**
```bash
# Time a single keyword search
time ./docs/scripts/wiki/wiki-search "testing"

# Compare against SLA (should be < 2000ms)
time ./docs/scripts/wiki/wiki-search "testing" > /dev/null
```

**If > 2000ms:**
1. Check system load: `uptime`
2. Check disk I/O: `iostat 1 5`
3. Reduce results: `--limit 5`
4. Use simpler query (fewer words)
5. Run cache warm: `./docs/scripts/wiki/cache-manager.sh warm`

### Slow Semantic Search

**Check:**
```bash
time ./docs/scripts/wiki/wiki-search "query" --semantic
```

**If > 2000ms:**
1. Semantic search is inherently slower
2. Use keyword search if faster needed
3. Reduce result limit
4. Check if embedding index is available
5. Monitor cache hit rate

### Degrading Performance Over Time

**Cause:** Cache grows or index becomes stale

**Fix:**
1. Clear cache: `./docs/scripts/wiki/cache-manager.sh clear`
2. Rebuild index: `qmd index docs/wiki/ --rebuild`
3. Reinitialize cache: `./docs/scripts/wiki/cache-manager.sh init`
4. Monitor disk space: `df -h`

---

## Debugging Commands

### Enable Verbose Output

```bash
# Most scripts support -v or --verbose
./docs/scripts/wiki/wiki-search -v "query"
./docs/scripts/wiki/accessible-search.sh -v "query"
```

### Debug Environment

```bash
# Show script configuration
export DEBUG=1
./docs/scripts/wiki/wiki-search "query"

# Check script version/location
which wiki-search
ls -la $(which wiki-search)

# Verify dependencies
qmd --version
bash --version
```

### Test Search Directly

```bash
# Test QMD directly
qmd query "testing"

# Test with specific collection
qmd query "testing" --collection root

# Show QMD status
qmd status
```

---

## Getting Help

### Information to include when reporting issues:

1. **System info:**
   ```bash
   uname -a
   bash --version
   which qmd && qmd --version
   ```

2. **Reproduction steps:**
   ```bash
   ./docs/scripts/wiki/wiki-search "your query"
   # [describe what happens]
   ```

3. **Expected vs actual:**
   - Expected: [what should happen]
   - Actual: [what actually happened]

4. **Test output:**
   ```bash
   ./docs/scripts/wiki/test-suite.sh 2>&1 | tee debug-output.txt
   ```

5. **Performance metrics:**
   ```bash
   ./docs/scripts/wiki/benchmark-search.sh
   ./docs/scripts/wiki/cache-manager.sh stats
   ```

### Resources

- [Wiki Search Guide](./wiki-search-guide.md) — Basic usage
- [Wiki Search Performance](./wiki-search-performance.md) — Performance tuning
- [Wiki Search Accessibility](./wiki-search-accessibility.md) — Accessibility features
- [Semantic Search Guide](./semantic-search-and-related-pages.md) — Advanced search

---

## Performance Reference

| Operation | Target | Typical | Acceptable |
|-----------|--------|---------|-----------|
| Keyword search | < 2000ms | 200-500ms | 1500-2000ms |
| Semantic search | < 2000ms | 500-1500ms | 1500-2000ms |
| Module search | < 1000ms | 100-300ms | 800-1000ms |
| Cache hit | > 80% | 85-95% | 70-80% |

---

## Advanced Debugging

### Trace Execution

```bash
# Run with bash trace (verbose)
bash -x ./docs/scripts/wiki/wiki-search "query" 2>&1 | head -50

# Monitor system calls
strace ./docs/scripts/wiki/wiki-search "query" 2>&1 | grep -i "open\|read\|write" | head -20
```

### Profile Search

```bash
# Time each component
time qmd query "testing"        # QMD time
time cat .cache/wiki-search/*.json | wc -l  # Cache time
time grep -r "testing" docs/wiki/  # Filesystem time
```

### Monitor Resources

```bash
# Watch during search
watch -n 0.1 'ps aux | grep wiki-search'

# Check memory usage
./docs/scripts/wiki/wiki-search "query" &
ps -o pid,vsz,rss,comm -p $!
```

---

**Last Updated:** 2026-04-29  
**Status:** Active  
**Related Story:** Story 2.1 (QMD Search Integration)
