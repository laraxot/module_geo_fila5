---
name: Wiki Search Accessibility and UX
description: Accessibility features, keyboard navigation, and UX improvements for wiki search
type: how-to
related: [wiki-search-guide.md, wiki-search-performance.md]
---

# Wiki Search Accessibility and UX

Make wiki search accessible and user-friendly for all users, including those using assistive technologies.

## Quick Start

```bash
# Use accessible output format
./docs/scripts/wiki/accessible-search.sh "your query"

# Get help with keyboard shortcuts
./docs/scripts/wiki/accessible-search.sh --help

# Verbose mode with explanations
./docs/scripts/wiki/accessible-search.sh -v "testing"
```

---

## Accessibility Features

### Screen Reader Support

All wiki search tools are compatible with screen readers:

**Supported Screen Readers:**
- NVDA (Windows)
- JAWS (Windows)
- VoiceOver (macOS)
- TalkBack (Android)
- Narrator (Windows)

**Features:**
- Descriptive output format
- Clear section headings
- Semantic HTML structure (with HTML output)
- ARIA labels for interactive elements
- Text-only output (no visual-only information)

### Using Accessible Search Format

```bash
# Default: accessible format (screen reader optimized)
./docs/scripts/wiki/accessible-search.sh "context-mode"
```

**Accessible format output includes:**
- Result count announcements
- Clear section headers
- Readable result structure
- Actionable suggestions

### HTML Output with ARIA

For web integration with full ARIA support:

```bash
./docs/scripts/wiki/accessible-search.sh --format html "testing"
```

**ARIA Features:**
- `role="region"` for search results container
- `aria-label="Search results"` for result list
- `role="article"` for individual results
- Semantic HTML structure
- High contrast styling support

---

## Keyboard Navigation

### Keyboard Shortcuts

Search results support full keyboard navigation:

| Key | Action |
|-----|--------|
| `j` | Jump to next result |
| `k` | Jump to previous result |
| `Enter` | View result details |
| `?` | Show help |
| `q` | Quit search |
| `Tab` | Navigate to next interactive element |
| `Shift+Tab` | Navigate to previous element |

### Keyboard-Only Navigation

Use wiki search entirely with keyboard:

```bash
# 1. Run search
./docs/scripts/wiki/accessible-search.sh "testing"

# 2. Press 'j' to move through results (no mouse needed)
# 3. Press 'Enter' to view selected result
# 4. Press 'q' to return to search
```

### Tab Order

Results are ordered for logical tab navigation:

1. Search input field
2. First result title
3. First result link
4. Next result title
5. ... (continuing through all results)
6. Help button
7. Back button

---

## Enhanced Error Messages

Clear, actionable error messages help all users recover from issues.

### No Results Found

```
No results found for your search.

Try:
- Using more specific search terms
- Searching for related concepts
- Using semantic search for related ideas
```

### Invalid Query

```
Invalid search query: [details]

Valid query formats:
- Simple terms: "testing"
- Phrases: "semantic search"
- Multiple terms: "event sourcing append only"
```

### Query Too Broad

```
Your query is very broad (234 results).

Try:
- Adding more specific terms
- Using module-specific search
- Filtering by document type
```

---

## High Contrast and Display Support

### High Contrast Mode

All search output works in high contrast mode:

**Supported modes:**
- Windows High Contrast
- macOS Increase Contrast
- Linux high contrast themes
- Terminal high contrast settings

### Color Not Required

No information is conveyed by color alone:

- ✓ "✓ Success" (includes text)
- ✗ "✗ Error" (includes text)
- Uses text indicators, not color

### Responsive Display

Formats adapt to terminal width:

```bash
# 80 column terminal
./docs/scripts/wiki/accessible-search.sh "query"

# 120 column terminal (same tool, auto-adapts)
./docs/scripts/wiki/accessible-search.sh "query"
```

---

## Accessible Output Formats

### Plain Text (Default)

Most accessible format for screen readers:

```bash
./docs/scripts/wiki/accessible-search.sh "testing"
```

**Benefits:**
- Zero visual complexity
- Perfect for screen readers
- Works on all terminals
- Easy to copy/paste

### HTML with ARIA

For web-based access with full semantic markup:

```bash
./docs/scripts/wiki/accessible-search.sh --format html "testing"
```

**Benefits:**
- Full ARIA support
- Semantic HTML structure
- Accessible CSS styling
- Browser navigation support

### JSON (Programmatic)

For accessibility tools and plugins:

```bash
./docs/scripts/wiki/accessible-search.sh --format json "testing"
```

**Benefits:**
- Structured data for screen readers
- Accessible to automation tools
- Platform-independent
- Custom formatting possible

---

## Mobile Accessibility

### Mobile-Friendly Output

Search results are optimized for mobile:

**Features:**
- Touch-friendly result sizes (min 44x44px)
- Readable font size (16px minimum)
- Single column layout
- Clear section spacing

### Touch Navigation

On mobile devices with screen readers:

```bash
# Result is read aloud
./docs/scripts/wiki/accessible-search.sh "testing"

# Swipe to navigate results
# Double-tap to select result
# Shake device for help menu
```

### Voice Control

Use voice control to search (with screen reader):

```
"Accessible search testing strategies"
# System opens search with that query
```

---

## Cognitive Accessibility

### Simple Language

All help text uses simple, clear language:

**Avoid:**
- Technical jargon without explanation
- Complex sentences
- Ambiguous instructions

**Use:**
- Direct, simple statements
- One instruction per line
- Examples for clarity

### Clear Structure

Well-organized output with clear hierarchy:

```
Query: Testing strategies
=====================================
[Heading level 1]

Result 1: First article title
[Heading level 2]
Path: docs/wiki/how-to/testing.md
Type: Guide

Result 2: Second article title
[Heading level 2]
...
```

### Focus Indicators

Clear visual focus indicators for keyboard navigation:

- Inverse video for selected result
- Clear outline in HTML mode
- Audible announcement in screen reader

---

## Testing Accessibility

### Automated Testing

Test accessibility with tools:

```bash
# Test screen reader compatibility
# (Requires NVDA, JAWS, or VoiceOver)
./docs/scripts/wiki/accessible-search.sh "test query"

# Test with HTML output and accessibility validator
./docs/scripts/wiki/accessible-search.sh --format html "test" > test.html
# Open in web accessibility tool
```

### Manual Testing

Test with actual assistive technology:

1. **Screen Reader Testing:**
   - Use NVDA (free) or JAWS
   - Navigate through results using arrow keys
   - Verify all content is read correctly

2. **Keyboard Testing:**
   - Unplug mouse
   - Navigate using Tab/Shift+Tab only
   - Verify all functions are keyboard accessible

3. **High Contrast Testing:**
   - Enable Windows High Contrast mode
   - Verify all text is readable
   - Check for color-dependent information

4. **Mobile Testing:**
   - Test on actual mobile device
   - Use device screen reader (TalkBack/VoiceOver)
   - Test with keyboard (Bluetooth keyboard)

### Accessibility Checklist

- [ ] All search results readable by screen reader
- [ ] Keyboard navigation works without mouse
- [ ] High contrast mode is readable
- [ ] Error messages are clear and actionable
- [ ] Help text is in simple language
- [ ] Mobile results are touch-friendly
- [ ] No time limits on interactions
- [ ] No flashing or animation (distracting)
- [ ] All information is text-based (not visual-only)
- [ ] ARIA labels are present in HTML output

---

## Verbose Mode for Learning

Use verbose mode for detailed explanations:

```bash
./docs/scripts/wiki/accessible-search.sh -v "testing"
```

**Verbose output includes:**
- Explanation of what search is doing
- Suggestions for refining search
- Tips for better results
- Help with using keyboard shortcuts

---

## Integration with Assistive Technologies

### NVDA Integration

Using NVDA screen reader:

```bash
# NVDA reads search query aloud
./docs/scripts/wiki/accessible-search.sh "context-mode"

# NVDA announces each result
# Use arrow keys to navigate
# Press Enter to select
```

### IDE Integration (Accessible)

Use wiki search in accessible IDE mode:

```bash
# VS Code: Terminal accessible mode
# Extension reads output aloud

./docs/scripts/wiki/accessible-search.sh "pattern"
```

### Custom Accessibility Setup

For users with specific needs:

```bash
# Combine tools for custom accessibility
# Example: Large print + screen reader

# Increase font size
./docs/scripts/wiki/accessible-search.sh "topic" | \
  sed 's/^/  /' | \
  less -S
```

---

## Best Practices for Accessibility

### ✓ DO

- **Use accessible search format** — it's optimized for screen readers
- **Test with real assistive tech** — simulators miss issues
- **Provide keyboard alternatives** — don't rely on mouse only
- **Use clear, simple language** — helps everyone
- **Provide verbose explanations** — especially for complex features
- **Test on real mobile devices** — not just desktop

### ✗ DON'T

- **Use color as only indicator** — add text labels too
- **Hide important information** — including in "help" text
- **Use complex sentences** — simple is better
- **Assume screen readers work perfectly** — test with real users
- **Skip alt text for important info** — it's essential
- **Create time-limited interactions** — some users need more time

---

## Common Accessibility Issues and Solutions

### Issue: Screen Reader Doesn't Read Results

**Problem:** Results aren't spoken by screen reader

**Solutions:**
1. Use accessible-search.sh instead of wiki-search
2. Ensure screen reader is set to "verbose" mode
3. Check that terminal supports screen reader
4. Try HTML output format with browser screen reader

### Issue: Can't Navigate with Keyboard

**Problem:** Tab key doesn't work as expected

**Solutions:**
1. Make sure search is using accessible format
2. Verify terminal supports keyboard input
3. Try different terminal (some have keyboard issues)
4. Use HTML output with browser keyboard nav

### Issue: High Contrast Mode is Unreadable

**Problem:** Text doesn't show in high contrast mode

**Solutions:**
1. Ensure terminal supports high contrast
2. Try different terminal color scheme
3. Use HTML output with high contrast CSS
4. Increase font size manually

### Issue: Text Is Too Small

**Problem:** Can't read output on screen

**Solutions:**
1. Increase terminal font size
2. Use less/more for paged output
3. Reduce results with --limit flag
4. Use HTML output with larger CSS fonts

---

## Accessibility Resources

### External Resources

- [Web Content Accessibility Guidelines (WCAG)](https://www.w3.org/WAI/standards-guidelines/wcag/)
- [ARIA Authoring Practices Guide](https://www.w3.org/WAI/ARIA/apg/)
- [NVDA Screen Reader](https://www.nvaccess.org/)
- [WebAIM: Web Accessibility In Mind](https://webaim.org/)

### Internal Documentation

- [wiki-search-guide.md](./wiki-search-guide.md) — Basic search usage
- [wiki-search-performance.md](./wiki-search-performance.md) — Performance optimization
- [How to contribute accessible docs](../sources/)

---

## Feedback and Improvements

If you find accessibility issues:

1. **Describe the issue:** What assistive tech? What terminal?
2. **Provide steps to reproduce:** How can we recreate it?
3. **Suggest a solution:** What would help you?
4. **Report it:** Create an issue or contact the team

---

**Last Updated:** 2026-04-29  
**Status:** Active  
**Accessibility Standard:** WCAG 2.1 Level AA  
**Related Story:** Story 2.1 (QMD Search Integration)
