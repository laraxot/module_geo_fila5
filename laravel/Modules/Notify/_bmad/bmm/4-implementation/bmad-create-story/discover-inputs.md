# Discover Inputs Protocol

**Objective:** Intelligently load project files (whole or sharded) based on the workflow's Input Files configuration.

**Prerequisite:** Only execute this protocol if the workflow defines an Input Files section. If no input file patterns are configured, skip this entirely.

---

## Step 1: Parse Input File Patterns

- Read the Input Files table from the workflow configuration.
- For each input group (prd, architecture, epics, ux, etc.), note the **load strategy** if specified.

## Step 2: Load Files Using Smart Strategies

For each pattern in the Input Files table, work through the following substeps in order:

### 2a: Try Sharded Documents First

If a sharded pattern exists for this input, determine the load strategy (defaults to **FULL_LOAD** if not specified), then apply the matching strategy:

### Token-Aware Loading Rule

Before loading any file, prefer the smallest strategy that still answers the workflow need:

1. Read index/manifest first when available.
2. Load only the shard or section that matches the current story, module, dependency, or cited source hint.
3. Avoid full-file loads unless the document is short, unsharded, or ambiguity remains after targeted reads.
4. Stop expanding context once the story has enough information to implement safely.

#### FULL_LOAD Strategy

Load ALL files in the sharded directory. Use this for PRD, Architecture, UX, brownfield docs, or whenever the full picture is needed.

1. Use the glob pattern to find ALL `.md` files (e.g., `{planning_artifacts}/*architecture*/*.md`).
2. Load EVERY matching file completely.
3. Concatenate content in logical order: `index.md` first if it exists, then alphabetical.
4. Store the combined result in a variable named `{pattern_name_content}` (e.g., `{architecture_content}`).

#### SELECTIVE_LOAD Strategy

Load a specific shard using a template variable. Example: used for epics with `{{epic_num}}`.

1. Check for template variables in the sharded pattern (e.g., `{{epic_num}}`).
2. If the variable is undefined, ask the user for the value OR infer it from context.
3. Resolve the template to a specific file path.
4. Load that specific file.
5. Store in variable: `{pattern_name_content}`.

#### STORY_SLICE Strategy

Load only the story slice and nearby supporting context, not the entire epic corpus.

1. Resolve the epic/story identifiers from workflow variables.
2. If sharded epics exist, load the shard for the current epic only.
3. Inside that shard or whole file, extract only:
   - the current story
   - immediate dependencies / prerequisites
   - source hints
   - the smallest epic summary needed for business context
4. Do not load unrelated epics or distant stories unless they are explicitly referenced.
5. Store the extracted slice in `{pattern_name_content}`.

#### INDEX_GUIDED Strategy

Load index.md, analyze the structure and description of each doc in the index, then intelligently load relevant docs.

Use best judgment, but stay relevance-first. Load documents that are plausibly needed for safe implementation; do not expand to low-probability material by default.

1. Load `index.md` from the sharded directory.
2. Parse the table of contents, links, and section headers.
3. Analyze the workflow's purpose and objective.
4. Identify which linked/referenced documents are likely relevant.
   - *Example:* If the workflow is about authentication and the index shows "Auth Overview", "Payment Setup", "Deployment" -- load the auth docs, consider deployment docs, skip payment.
5. Load only identified relevant documents.
6. Store combined content in variable: `{pattern_name_content}`.

**When in doubt, check the index/source hints first**. Only expand further if a missing requirement, dependency, or ambiguity remains.

---

After applying the matching strategy, mark the pattern as **RESOLVED** and move to the next pattern.

### 2b: Try Whole Document if No Sharded Found

If no sharded matches were found OR no sharded pattern exists for this input:

1. Attempt a glob match on the "whole" pattern (e.g., `{planning_artifacts}/*prd*.md`).
2. If matches are found, prefer the smallest matching file. If the file is large, use targeted section reads instead of loading it completely.
3. Store content in variable: `{pattern_name_content}` (e.g., `{prd_content}`).
4. Mark pattern as **RESOLVED** and move to the next pattern.

### 2c: Handle Not Found

If no matches were found for either sharded or whole patterns:

1. Set `{pattern_name_content}` to empty string.
2. Note in session: "No {pattern_name} files found" -- this is not an error, just unavailable. Offer the user a chance to provide the file.

## Step 3: Report Discovery Results

List all loaded content variables with file counts. Example:

```
OK Loaded {prd_content} from 5 sharded files: prd/index.md, prd/requirements.md, ...
OK Loaded {architecture_content} from 1 file: Architecture.md
OK Loaded {epics_content} from selective load: epics/epic-3.md
-- No ux_design files found
```

This gives the workflow transparency into what context is available.
