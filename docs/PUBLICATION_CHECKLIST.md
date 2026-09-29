# Publication checklist / 公開前チェックリスト

This is a **release checklist, not evidence that the checks have passed**. Keep the repository private until the owner has made the disclosure and licensing decisions below. Completing this document never changes repository visibility.

この文書は公開前の確認項目であり、実施済みの証明ではない。公開権限・ライセンスを所有者が決めるまでは非公開を維持する。

## Decisions requiring repository-owner authorization / 所有者判断

- [ ] **License**: decide whether to grant reuse, modification, and redistribution rights and under which terms. No license is chosen or granted by this checklist. If no license is granted, explain that publicly viewable source is not automatically open source.
- [ ] **Source-project references**: review [workflow-conformance.md](./testing/workflow-conformance.md) and Git history for references to the originating private repository, repository ID, commits, PR/Issue numbers, internal project terminology, and workflow details. Determine what can be disclosed with the appropriate authority. Do not merely delete current text and assume older commits are hidden.
- [ ] **Experiment disclosure**: decide whether separate experiment PRs and their review discussions may be public; they can contain unmerged code, defects, discussions, or links to other sources.
- [ ] **Visibility**: explicitly approve changing this repository from private to public **only after** the checks below. The current PR is not authorization to change visibility.

## Technical publication checks / 技術的な確認

- [ ] Inspect **all reachable Git history**, branches, tags, PR commits, workflows and relevant releases for passwords, tokens, access keys, personal data, internal URLs, proprietary material, and secrets in removed files. Scan current files and history with an appropriate secret scanner; manually assess results.
- [ ] Verify `.env` and other local secret files remain untracked. `.env.example` and Docker Compose currently use development-only database credentials and a fixed local application key: document them as **local-only**, and never use them in an internet-facing deployment.
- [ ] Confirm repository settings, allowed actions, branch protection, workflows, external integrations, and contributor access are appropriate for public visibility. Do not assume a file's presence means an AI reviewer ran.
- [ ] Check documentation links and file references on the **intended release commit**. The `main` teaching sample and unmerged experiment PRs must not be presented as one merged application.
- [ ] Run `make lint`, `make test`, `make survey`, and applicable docs generation/consistency checks against the intended release commit in a supported environment; record commands, results and commit SHA. A successful docs-only inspection is not a substitute for these runs.
- [ ] Confirm the app is presented as an educational local example, not a production-ready authenticated multi-user service. Recheck default exposed ports and example credentials before any deployment or public demo.
- [ ] Recheck license notices for included code/dependencies and remove material not authorized for redistribution.

## Snapshot-specific notes / 現状メモ

- `main` contains the intentionally unauthenticated Task CRUD teaching example.
- PR #6 and PR #7 are separate unmerged implementation experiments; PR #8 proposes independent review/SoT rule improvements. Recheck these states at publication time.
- [workflow-conformance.md](./testing/workflow-conformance.md) currently includes source-repository identifiers and concrete source PR/Issue/commit references. **This PR deliberately preserves the evidence until its owner decides the publication scope.**
- No license has been selected here; no repository visibility change, history-wide secret scan, or runtime/CI verification is claimed by this documentation-only change.
