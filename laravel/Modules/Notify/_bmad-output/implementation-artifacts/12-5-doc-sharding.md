# Story 12.5: Documentation Sharding & Reorganization

**Status:** 🏗️ **Draft**
**Epic:** [[EPIC-12: Documentation]]
**Story ID:** `STORY-12.5`
**Goal:** Improve context efficiency by sharding massive documentation files into smaller, semantically organized modules in `.agents/docs/`.

---

## 🎯 Objective
Split `AGENTS.md` (201K), `QWEN.md`, `CLAUDE.md`, and `GEMINI.md` into smaller files to prevent context window pollution and ensure agents only load relevant instructions.

---

## 📋 Scope
- **Source Files:**
    - `AGENTS.md` (Priority: High - 201K)
    - `QWEN.md`
    - `CLAUDE.md`
    - `laravel/GEMINI.md`
- **Destination:** `.agents/docs/` (new subdirectory structure)
- **Linking:** Create bidirectional relative links between the new shards and a central index.

---

## ✅ Acceptance Criteria
1. [ ] **No Content Loss:** All instructions and rules from the source files must be preserved in the shards.
2. [ ] **Small File Sizes:** Shards should generally be < 10KB where possible.
3. [ ] **Logical Organization:** Shards must be grouped by module, technology (e.g., Tailwind, PHP, Laravel), or agent type.
4. [ ] **Bidirectional Links:** Every shard must link back to its parent index, and the index must link to all shards.
5. [ ] **Relative Paths:** Use relative paths (e.g., `../docs/shard.md`) to ensure portability.
6. [ ] **Clean Root:** Original massive files should be reduced to simple pointers or removed if redundant.

---

## 🛠️ Technical Tasks
1. **Infrastructure:**
    - Create `.agents/docs/` and subdirectories (e.g., `core/`, `laravel/`, `skills/`).
2. **Sharding `AGENTS.md`:**
    - Identify logical sections (e.g., Agent Skill definitions, Project Context, Rules).
    - Use `bmad-shard-doc` or manual splitting to create shards.
3. **Sharding `GEMINI.md` & `QWEN.md`:**
    - Extract technology-specific rules (Tailwind v4, Livewire 4, etc.) into separate files.
4. **Linking & Indexing:**
    - Create/Update `.agents/docs/README.md` as the Master Index.
    - Add "Parent Reference" links to the top of every shard.
5. **Validation:**
    - Verify all links work.
    - Check that no critical rules were lost.

---

## 🔗 References
- [[EPIC-12: Documentation]]
- [Project Master Index](docs/MODULE_DOCS_INDEX.md)
