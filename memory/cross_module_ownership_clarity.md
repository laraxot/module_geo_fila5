---
name: cross-module-ownership-clarity
description: Avoid mixing module ownership references in policy docs; keep ownership definitions strictly module-scoped and cross‑module only when documented
metadata:
  type: feedback
---

**Rule:**  
When documenting ownership of duplicated logic or shared components, reference only the module that owns the component. Do not mention other modules unless there is an explicit, documented relationship, and clearly label the relationship (e.g., integration, shared‑surface). Avoid generic references like “ptv” or “sigma” within a module’s ownership description unless that module directly owns or integrates that piece.

**Why:**  
Mixing references creates confusion, leads to incorrect ownership assignments, and can cause circular dependencies. It also makes it harder for reviewers to understand responsibilities.

**How to apply:**  
- In policy documents, use the bucket matrix to map each piece of logic to a single owning module.  
- When describing ownership, cite the bucket and the owning module explicitly.  
- If a piece logically belongs to another module, reference it via a documented integration point or cross‑module agreement, not as a generic ownership.  
- Review policy drafts with the ownership matrix checklist before finalizing.