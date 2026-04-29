# NotebookLM Integration Guide - FixCity Improvements

**Purpose**: Use NotebookLM for source-grounded research on FixCity improvement opportunities

---

## Documents to Upload

Upload these documents to NotebookLM in order:

1. **Improvement Plan** (PRIMARY)
   - File: `.planning/improvements/FIXCITY_IT_IMPROVEMENT_PLAN.md`
   - Purpose: Master improvement roadmap

2. **Research Summary**
   - File: `.planning/improvements/RESEARCH_SUMMARY.md`
   - Purpose: Quick reference

3. **Project Context**
   - File: `.planning/PROJECT.md`
   - Purpose: Overall project state

4. **Research Background**
   - File: `.planning/research/FIXCITY_PROJECT_RESEARCH_SUMMARY.md`
   - Purpose: Technical deep dive

5. **Guidelines**
   - File: `AGENTS.md`
   - Purpose: Development standards

6. **Module PRDs** (SELECTED)
   - `laravel/Modules/Fixcity/docs/prd.json`
   - `laravel/Modules/User/docs/prd.json`
   - `laravel/Modules/Cms/docs/prd.json`
   - `laravel/Themes/Sixteen/docs/prd.json`

---

## Research Questions

### Category 1: Current State Analysis

**Q1.1**: "What are the top 3 critical issues facing FixCity based on the improvement plan?"

**Expected Answer**:
1. Test coverage gap (40% → 85%)
2. Performance bottlenecks (TTFB 780ms → 200ms)
3. Translation incompleteness (~60% → 100%)

**Q1.2**: "What is the current technical stack and what are its strengths?"

**Expected Answer**:
- Laravel 12 + Filament 5 + Tailwind 4
- Strengths: PHPStan Level 10, modular, AGID-compliant

**Q1.3**: "What documentation issues exist and how should they be resolved?"

**Expected Answer**:
- 15,101+ markdown files, chaos, duplicates
- Solution: Consolidate roadmaps (16→2-3), remove temporal strings, create master index

---

### Category 2: Improvement Prioritization

**Q2.1**: "Which P0 improvements have the highest ROI and why?"

**Expected Answer**:
1. Eager loading (8h effort, 50% TTFB improvement)
2. Test syntax fixes (4h effort, unblocks CI/CD)
3. Accessibility quick wins (12h effort, legal compliance)

**Q2.2**: "What are the dependencies between P1 improvements?"

**Expected Answer**:
- P1.1 (Query optimization) → Requires P0.3 (Eager loading)
- P1.3 (Citizen dashboard) → Requires P1.4 (Notifications)
- P1.5 (Auto-assignment) → Requires Geo module completion

**Q2.3**: "Which improvements should be deferred to Phase 3 and why?"

**Expected Answer**:
- P3 items (dark mode, social sharing, forum) - low ROI
- P2.13-P2.15 (AI/ML features) - require data maturity
- P3.8 (API marketplace) - premature optimization

---

### Category 3: Execution Strategy

**Q3.1**: "What is the optimal phase ordering and why?"

**Expected Answer**:
- Phase 0: Foundation (fix blockers first)
- Phase 1: Performance + Core features (highest value)
- Phase 2: Advanced features (differentiation)
- Phase 3: Innovation (competitive advantage)

**Q3.2**: "Which AI tools are best suited for each task category?"

**Expected Answer**:
- Research/Docs → Qwen (strength: synthesis)
- Architecture/Performance → Claude (strength: systems thinking)
- Frontend/UX → Cursor (strength: rapid prototyping)
- Tests → Copilot (strength: pattern generation)
- Implementation → Ralph Loop (strength: autonomous execution)

**Q3.3**: "What are the risks and how should they be mitigated?"

**Expected Answer**:
- Documentation overwhelm → Incremental cleanup
- Test coverage stall → Focus on critical paths
- Performance regression → Baseline metrics
- Multi-agent conflicts → GitHub coordination

---

### Category 4: Success Metrics

**Q4.1**: "How should FixCity measure improvement success?"

**Expected Answer**:
- Technical: Coverage %, TTFB ms, queries count
- Business: Active users, tickets/month, satisfaction score
- Developer: CI/CD pass rate, deploy time, onboarding time

**Q4.2**: "What are industry benchmarks for these metrics?"

**Expected Answer**:
- Test coverage: 80%+ (standard), 90%+ (excellent)
- TTFB: <200ms (good), <100ms (excellent)
- WCAG: AA compliance (legal requirement for public sector)

**Q4.3**: "Which metrics matter most to citizens?"

**Expected Answer**:
- Resolution time (days to fix issue)
- Communication (notification frequency)
- Ease of use (mobile experience)
- Transparency (status tracking)

---

### Category 5: Italian Localization

**Q5.1**: "What tone of voice should FixCity use for Italian translations?"

**Expected Answer**:
- Citizen-facing: Informale ma professionale (tu)
- Admin-facing: Formale (Lei)
- Error messages: Chiaro, costruttivo, non colpevolizzante
- Success messages: Positivo, confermativo

**Q5.2**: "Which modules have the biggest translation gaps?"

**Expected Answer**:
- Fixcity: Ticket types, priorities, statuses
- User: Profile fields, roles, permissions
- Cms: Navigation, content blocks
- Notify: Email templates

**Q5.3**: "What are AGID requirements for Italian public sector websites?"

**Expected Answer**:
- WCAG 2.1 AA compliance
- Italian language primary
- Bootstrap Italia design system
- Accessibility declaration
- Privacy/GDPR compliance

---

## NotebookLM Workflow

### Step 1: Upload Documents
1. Open NotebookLM
2. Create new notebook: "FixCity Improvements"
3. Upload documents in order (see list above)
4. Wait for processing (2-3 minutes)

### Step 2: Ask Questions
1. Start with Category 1 (current state)
2. Move to Category 2 (prioritization)
3. Explore Category 3 (execution)
4. Validate Category 4 (metrics)
5. Deep dive Category 5 (localization)

### Step 3: Validate Answers
1. Cross-reference with source documents
2. Check against actual codebase
3. Verify with web research if needed
4. Flag any inconsistencies

### Step 4: Extract Insights
1. Copy key insights to clipboard
2. Update improvement plan with new findings
3. Store insights in OpenViking
4. Create action items in GitHub issues

### Step 5: Iterate
1. Ask follow-up questions
2. Request clarification on ambiguous points
3. Explore alternative approaches
4. Generate summaries for stakeholders

---

## Example Session

**Session Goal**: Validate P0 prioritization

**Questions**:
1. "What are the top 5 P0 improvements by ROI?"
2. "Which P0 improvement is most critical and why?"
3. "What happens if we defer P0.2 (translations) to Phase 1?"
4. "Are there any P0 improvements that should be P1?"

**Expected Insights**:
- P0.1 (test syntax) is prerequisite for all testing
- P0.3 (eager loading) has highest performance ROI
- P0.2 (translations) is legal requirement for Italian public sector
- P0.4 (accessibility) is also legal requirement (WCAG AA)

**Action Items**:
- Start with P0.1 immediately (Ralph Loop)
- Parallelize P0.2 + P0.3 (Qwen + Claude)
- P0.4 requires manual testing (schedule early)
- P0.5 can run concurrently (documentation team)

---

## Output Format

For each question, NotebookLM should provide:

```markdown
## Question
[Your question here]

## Answer
[Source-grounded answer with citations]

## Sources
- Document 1 (page/section)
- Document 2 (page/section)

## Confidence
HIGH / MEDIUM / LOW

## Follow-up Questions
1. [Related question 1]
2. [Related question 2]
```

---

## Tips for Best Results

1. **Be Specific**: "What are the top 3 P0 improvements?" not "What improvements?"
2. **Ask for Sources**: Always request citations to source documents
3. **Challenge Answers**: "Are you sure? Show me the source"
4. **Request Summaries**: "Summarize this in 3 bullet points"
5. **Compare Perspectives**: "How does the improvement plan differ from the PRD?"

---

## Common Pitfalls

❌ **Too Vague**: "Tell me about FixCity"
✅ **Specific**: "What are the top 3 performance bottlenecks?"

❌ **Yes/No Questions**: "Is test coverage important?"
✅ **Open-ended**: "Why is test coverage critical for FixCity?"

❌ **Ignoring Sources**: Accepting answers without citations
✅ **Verify**: "Which document mentions this? Show me the section"

❌ **Single Question**: Asking one question and stopping
✅ **Iterate**: Follow-up with "Why?", "What if?", "How?"

---

## Integration with Other Tools

### OpenViking
```bash
# Store NotebookLM insights
openviking add --type=notebooklm-insight \
  --file="notebooklm-session-2026-03-30.md" \
  --tags="improvement,research,prioritization"
```

### GitHub Issues
```markdown
## NotebookLM Research Finding

**Source**: NotebookLM session 2026-03-30
**Question**: "What are the top 3 P0 improvements by ROI?"
**Answer**: [Summary]
**Action**: [What to do]

**Closes**: #123
```

### BMAD PRD
```bash
# Create PRD based on NotebookLM insight
/bmad-create-prd
# Context: NotebookLM validated this as high-ROI
# Source: notebooklm-session-2026-03-30.md
```

---

## Session Templates

### Template 1: Discovery Session
**Goal**: Understand current state
**Duration**: 30 minutes
**Questions**: Category 1 (Current State)

### Template 2: Prioritization Session
**Goal**: Validate improvement priorities
**Duration**: 45 minutes
**Questions**: Category 2 (Prioritization) + Category 3 (Execution)

### Template 3: Metrics Session
**Goal**: Define success criteria
**Duration**: 30 minutes
**Questions**: Category 4 (Success Metrics)

### Template 4: Localization Session
**Goal**: Italian translation strategy
**Duration**: 45 minutes
**Questions**: Category 5 (Italian Localization)

---

## Next Steps

1. **Today**: Upload documents to NotebookLM
2. **Tomorrow**: Run Discovery Session (Category 1)
3. **This Week**: Run all 5 category sessions
4. **Next Week**: Update improvement plan with insights
5. **Ongoing**: Use NotebookLM for Q&A during execution

---

**Created**: 2026-03-30
**Updated**: 2026-03-30
**Maintained By**: AI Research Team
