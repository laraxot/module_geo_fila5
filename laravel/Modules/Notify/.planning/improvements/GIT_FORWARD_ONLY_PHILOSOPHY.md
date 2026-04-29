# 🧘 Git Forward-Only Philosophy - The Zen

**Date**: 2026-03-30  
**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Principle**: Git goes ONLY forward, never back

---

## 🎯 The Philosophy (The Zen)

### Core Principle: Forward-Only

**WRONG** ❌:
```bash
git revert <commit>
git reset --hard HEAD~1
git checkout <old-commit>
```

**CORRECT** ✅:
```bash
# Study old version to understand WHY
git show <old-commit>
git log --follow <file>

# Document the reasoning
# Create NEW commit with improvement
git add <improved-file>
git commit -m "feat: Improve based on lessons from <old-commit>"
```

**Why?**
- ✅ **History is immutable**: Every commit tells a story
- ✅ **Learn from past**: Understand WHY, not just WHAT
- ✅ **Forward momentum**: Always improve, never regress
- ✅ **Collaboration**: Multiple AI agents can see evolution

---

## 📚 The Three Laws of Git

### 1. Study First, Act Second

**Before** making changes:
```bash
# 1. Read current version
cat <file>

# 2. Read history
git log --follow <file>

# 3. Read specific commit
git show <commit-hash>

# 4. Understand WHY
# - Why this structure?
# - Why this naming?
# - Why this pattern?
```

**Then** improve:
```bash
# Document understanding
cat > docs/why-<thing>.md << 'EOF'
# Why <thing> is done this way

## Historical Context
Commit <hash> (date) introduced this because...

## Current Understanding
This pattern exists because...

## Proposed Improvement
We can improve by...
EOF

# Create improvement
edit <file>
git add <file>
git commit -m "feat: Improve <thing> (based on <commit-hash>)"
```

### 2. Document Everything

**Every** decision documented:
```
docs/
├── why-blocks-use-json.md
├── why-pub_theme-namespace.md
├── why-multi-block-pages.md
└── why-forward-only-git.md
```

**Every** commit tells a story:
```bash
# WRONG: Vague commit
git commit -m "fix stuff"

# CORRECT: Story commit
git commit -m "feat: Implement BlockData auto-resolve view

Based on commit abc123 (2026-03-25) which introduced manual view specs.

IMPROVEMENT:
- Auto-resolve view from block type
- Convention: type '{type}' → view 'pub_theme::components.blocks.{type}.{type}'
- DRY: No view needed in JSON
- KISS: Simple convention

Reference: docs/why-block-view-convention.md"
```

### 3. Improve, Never Revert

**WRONG** ❌:
```bash
git revert abc123  # Reverts good work
git reset --hard   # Destroys history
```

**CORRECT** ✅:
```bash
# Study why abc123 was done
git show abc123

# Document understanding
cat > docs/why-abc123.md << 'EOF'
# Why commit abc123 was made

## Original Intent
This commit added manual view specs to JSON files because...

## Current Limitations
Now we see this is verbose and not DRY because...

## Proposed Improvement
Instead of reverting, we add auto-resolve logic...
EOF

# Create improvement commit
edit BlockData.php
git add BlockData.php
git commit -m "feat: Add auto-resolve to improve abc123"
```

---

## 🔄 Multi-Agent Collaboration

### Why Forward-Only Matters for AI Agents

**Scenario**: 5 AI agents working on same codebase

**Agent A** (Monday):
```bash
git commit -m "feat: Add manual view specs to JSON"
```

**Agent B** (Tuesday):
```bash
# WRONG: Reverts Agent A's work
git revert <commit-A>  # ❌ Conflict!
```

**Agent C** (Wednesday):
```bash
# CORRECT: Studies Agent A's work
git show <commit-A>
cat > docs/why-manual-views.md
# Then improves
git commit -m "feat: Add auto-resolve (improves commit-A)"  # ✅ Forward!
```

**Benefits**:
- ✅ **No conflicts**: Each agent builds on previous work
- ✅ **Shared learning**: All agents see evolution
- ✅ **Immutable history**: Can always trace decisions
- ✅ **Collaborative improvement**: Each agent adds value

---

## 📊 Real Example: BlockData Evolution

### Commit 1: Manual View Specs (2026-03-25)

```bash
commit abc123
Author: AI Agent A
Date:   2026-03-25

feat: Add view specs to JSON blocks

Added explicit view paths to all block JSON files.
Reason: Need to support custom views per block.

Files:
- tests.appuntamento-06-conferma.json (added view to 6 blocks)
```

**JSON**:
```json
{
    "type": "hero",
    "data": {
        "title": "Benvenuto",
        "view": "pub_theme::components.blocks.hero.hero"  // Manual
    }
}
```

### Commit 2: Study & Understand (2026-03-30)

```bash
commit def456
Author: AI Agent B
Date:   2026-03-30

docs: Document why manual view specs were added

Studied commit abc123 to understand reasoning:
- Needed custom view support
- Explicit is better than implicit (at the time)
- DRY wasn't priority then

Created: docs/why-manual-view-specs.md
```

### Commit 3: Improve Forward (2026-03-30)

```bash
commit ghi789
Author: AI Agent C
Date:   2026-03-30

feat: Implement BlockData auto-resolve view

Based on commit abc123 (manual specs) and docs/why-manual-view-specs.md

IMPROVEMENT:
- Auto-resolve view from type if not specified
- Convention: type → pub_theme::components.blocks.{type}.{type}
- DRY: No view needed in JSON (90% reduction)
- KISS: Simple convention
- Override: Can still specify view if needed

Reference: docs/why-block-view-convention.md
```

**JSON** (now DRY):
```json
{
    "type": "hero",
    "data": {
        "title": "Benvenuto"
        // ✅ Auto-resolved!
    }
}
```

---

## 🎯 DRY + KISS Compliance

### DRY (Don't Repeat Yourself)

✅ **Study once**: Read history, understand WHY  
✅ **Document once**: Single source of truth  
✅ **Improve forward**: Build on existing work  
✅ **No reverts**: Never duplicate effort

### KISS (Keep It Simple, Stupid)

✅ **Simple rule**: Git goes forward only  
✅ **Simple process**: Study → Document → Improve  
✅ **Simple commits**: Each tells a story  
✅ **Simple collaboration**: All agents follow same rule

---

## 📁 Documentation Structure

```
docs/
├── why-<thing>.md           # Why something was done
├── evolution/
│   └── <feature>.md         # How feature evolved
└── decisions/
    └── <decision>.md        # Decision records
```

### Example: `docs/why-manual-view-specs.md`

```markdown
# Why Manual View Specs Were Added

**Commit**: abc123 (2026-03-25)  
**Author**: AI Agent A

## Historical Context

At the time, we needed:
1. Custom view support per block
2. Explicit configuration
3. Flexibility for edge cases

## Decision Reasoning

We chose manual specs because:
- Explicit > Implicit (at the time)
- Needed to support custom overrides
- DRY wasn't priority then

## Current Understanding

Now we see:
- 90% of blocks use convention
- Manual specs are verbose
- Auto-resolve would be more DRY

## Proposed Improvement

Add auto-resolve with override support:
- Default: Auto-resolve from type
- Override: Specify view in JSON if needed
- Best of both worlds: DRY + flexible
```

---

## ✅ Checklist

### When Making Changes

- [ ] Study git history (`git log --follow`)
- [ ] Read relevant commits (`git show <hash>`)
- [ ] Understand WHY (not just WHAT)
- [ ] Document understanding (`docs/why-*.md`)
- [ ] Create improvement commit (forward-only)
- [ ] Reference old commits in message
- [ ] Update OpenViking with learnings

### When Seeing "Problems"

- [ ] Don't revert
- [ ] Don't reset
- [ ] Study why it was done
- [ ] Document reasoning
- [ ] Create improvement forward
- [ ] Reference original commit

### Multi-Agent Collaboration

- [ ] Read other agents' commits
- [ ] Understand their reasoning
- [ ] Build on their work
- [ ] Document evolution
- [ ] Never revert other agents

---

## 📚 Related Documentation

| Document | Location |
|----------|----------|
| **Block View Convention** | `.planning/improvements/BLOCK_VIEW_CONVENTION_PHILOSOPHY.md` |
| **BlockData Auto-Resolve** | `.planning/improvements/BLOCKDATA_AUTO_RESOLVE_IMPLEMENTATION.md` |
| **Multi-Agent Collaboration** | `docs/MULTI_AGENT_COLLABORATION.md` |

---

**Status**: ✅ **PHILOSOPHY DOCUMENTED**  
**Principle**: Git goes forward only  
**Process**: Study → Document → Improve  
**DRY + KISS**: Learn from past, improve forward

**The Zen of Git Forward-Only! 🧘**
