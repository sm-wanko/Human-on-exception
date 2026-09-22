# 04 — Review Findings

PR #<number> has review findings.

Follow `AGENTS.md` and the review/adjudication rule.

Evaluate every finding independently against current repository evidence.

- valid → fix, update tests/docs as required, run checks, reply, resolve
- false positive → do not change correct behavior; reply with concrete evidence
- genuinely ambiguous → stop only on that decision and ask me with options, impact, and your recommendation

After fixes, re-run affected verification and check for new contract/docs/test drift.

Handle all non-ambiguous findings autonomously.
