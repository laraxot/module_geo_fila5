<<<<<<< .merge_file_2ROhhE
---
title: "Rimando a contributing.md"
description: "Documento unificato: il contenuto canonico vive in contributing.md."
status: merged
tags: [merge, duplicato, case-only]
---

# Documento unificato

Questo file era un duplicato esatto che differiva solo per maiuscole/minuscole, in violazione della regola no-case-only-variations. Il contenuto canonico si trova in [contributing.md](./contributing.md).
=======
Contributing: policy issue-linking

Per evitare che modifiche non siano tracciate con issue GitHub, seguire queste regole locali e remote:

Local hooks (raccomandato):
1. Impostare hook locali in repository: `git config core.hooksPath .githooks`
2. Rendere eseguibili gli hook: `chmod +x .githooks/*`

Commit messages:
- Includere riferimento a issue nel messaggio: e.g. "Add STANDARD.md (Closes #123)" or include "Refs #123".

CI enforcement:
- La pipeline GitHub Actions verifica PR e commit; se non trovata una issue, creerà una issue automaticamente e commenterà la PR richiedendo aggiornamento.

Agents:
- Tutti gli agenti AI devono rispettare AGENTS_POLICY.md; le violazioni saranno bloccate dalla CI.

If you are an integrator: run `git config core.hooksPath .githooks` once after cloning to enable local checks.
>>>>>>> .merge_file_SmSMYw
