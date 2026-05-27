---
title: "Standard Markdown & Second Brain — Scrittura e Denominazione"
module: "ptvx-project"
type: rule
status: approved
tags: [markdown, second-brain, naming, yaml, front-matter, atomic-notes, para, agents]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - "./naming-conventions-markdown.md"
  - "./00-TRIGGER_MAP.md"
  - "../how-to/github-issue-agent-discipline.md"
  - "../concepts/markdown-note-minimum-standard.md"
  - "../concepts/second-brain-operating-model.md"
qmd: "standard markdown second brain naming front matter atomic notes mandatory"
---

# Standard Markdown & Second Brain — Scrittura e Denominazione

> **MANDATORY RULE.** Every AI agent creating or modifying `.md` files in this repository MUST strictly follow this standard. It is designed to transform the codebase documentation into a durable "Second Brain" (Hackernoon Tip 020).

## 1. Filename Conventions (The Law of Naming)

Consistency in filenames is crucial for discovery and automation.

| Rule | Requirement | Example |
| :--- | :--- | :--- |
| **Casing** | Strictly **lowercase** | `auth-guide.md`, not `AuthGuide.md` |
| **Separator** | Use **hyphens (`-`)** (kebab-case) | `project-roadmap.md`, not `project_roadmap.md` |
| **No Dates** | Never include **years** (`20xx`) or ISO dates (`YYYY-MM-DD`) in filenames | Month-only tokens (`november`, `gennaio`) are OK without year; use `created`/`updated` in YAML for chronology |
| **Length** | 2-5 descriptive words | `filament-resource-zen-pattern.md` |
| **Exceptions** | `README.md`, `INDEX.md`, `CHANGELOG.md`, `00-TRIGGER_MAP.md` | Keep as is for tool compatibility |

### 1.1 Legacy filenames (date nel filename) — migrazione obbligatoria

Se esiste un file `.md` con una data nel **filename** (es. `*-2026-05-27.md`), non creare eccezioni:

- **Creare** il file canonico senza data (kebab-case) **nella stessa cartella `docs/` esistente**.
- **Migrare** il contenuto nel canonico, mantenendo front matter e link relativi.
- **Convertire** il file datato in uno stub `deprecated` con solo:
  - front matter `status: deprecated`
  - link al file canonico (`[nome.md](nome.md)`)
  - nota: “non aggiungere date nel filename; usare `created/updated` nel front matter”

Obiettivo: un solo owner e un solo entrypoint per concetto (DRY), senza rompere backlink storici.

## 2. File Structure (Atomic & Structured)

Every file must be **Atomic**: one concept, one rule, or one procedure per file. If a file covers multiple unrelated topics, split it.

### 2.1 YAML Front Matter (Mandatory)

Every `.md` file MUST start with a YAML block.

```yaml
---
title: "Human Readable Title"
type: "concept | rule | how-to | memory | source | index"
tags: [tag1, tag2]
created: YYYY-MM-DD
updated: YYYY-MM-DD
status: "draft | approved | deprecated"
related:
  - "./relative-path-to-other.md"
qmd: "search keywords for qmd tool"
---
```

### 2.2 Content Body

1. **H1 Header**: Matches `title` in YAML.
2. **Summary/Intent**: A short blockquote explaining *why* this file exists.
3. **Sections (H2/H3)**: Structured, concise content. Use tables and lists over long paragraphs.
4. **References/Related**: At the end, list related files using **relative markdown links**.

## 3. Second Brain Integration (PARA)

We organize documentation by **Actionability**, not just subject.

| Layer | Repo Path | Purpose |
| :--- | :--- | :--- |
| **Projects** | `docs/chat/`, GitHub Issues | Active, short-term work. |
| **Areas** | `docs/wiki/rules/`, `docs/wiki/concepts/` | Ongoing standards and knowledge. |
| **Resources** | `docs/wiki/sources/`, `docs/raw/` | Reference materials, external articles. |
| **Archives** | Git History | We do not use "archive" folders. Git is our archive. |

## 4. Operational Requirements for Agents

1. **GitHub Issues first (audit trail)** — mandatory with **no exception** for “wiki-only” or “Markdown-only” work: verify `git remote -v` → `provtv/base_ptv_fila5_mono`; run `gh issue list --repo provtv/base_ptv_fila5_mono --search "<topic>" --state all` before substantive edits; end the task with an issue comment (+ `docs/wiki/log.md` line when relevant). Canonical how-to: [github-issue-agent-discipline](../how-to/github-issue-agent-discipline.md). Typical anchor issue: **`#124`**.
2. **Search First**: Before creating a file, use `qmd search` or `grep` to ensure the topic isn't already covered. **DRY (Don't Repeat Yourself)**.
3. **Update, Don't Duplicate**: If an existing file is relevant but incomplete, update it instead of creating a new one.
4. **Link Everything**: Use the `related` field in YAML to build a knowledge graph.
5. **Relative Links**: NEVER use absolute paths (except fully qualified `https://` when needed externally). Repo links use relatives (e.g. `../rules/standard.md`).
6. **Verify**: After creating/renaming, ensure all links are valid.

## 5. Checklist for Definition of Done

- [ ] **`git remote -v` verified** and **`gh issue list` / audit trail executed** (`provtv/base_ptv_fila5_mono`); closing comment filed on **`#124` or scoped issue**.
- [ ] Filename is lowercase-kebab-case.
- [ ] No dates or underscores in filename.
- [ ] YAML front matter is present and valid.
- [ ] File is Atomic (one main topic).
- [ ] Links are relative and functional.
- [ ] `00-TRIGGER_MAP.md` or `INDEX.md` is updated if the file is a new entry point.

---
**References:**

- [GitHub Issue ↔ Wiki (agent discipline)](../how-to/github-issue-agent-discipline.md)
- [Second Brain Operating Model](../concepts/second-brain-operating-model.md)
- [HackerNoon Tip 020](https://hackernoon.com/ai-coding-tip-020-create-a-second-brain)
- [Project Naming Conventions](./naming-conventions.md)
