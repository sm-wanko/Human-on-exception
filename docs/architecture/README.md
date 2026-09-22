# Architecture

This directory documents the architecture **chosen by the repository using Human-on-Exception**.

Human-on-Exception itself does not require Clean Architecture, Laravel, React, repositories, use-case classes, or any particular layering scheme.

The files currently included here document the Laravel + TypeScript **sample implementation**.

Adopters should keep, simplify, replace, or delete these sample rules and encode architecture appropriate to their own project.

Architecture docs should capture cross-feature boundaries such as:

- service/layer/module ownership
- dependency direction
- data ownership
- shared vs domain-local responsibilities
- cross-service communication
- cache/job/event architecture
- prohibited coupling

Do not create architecture documentation for patterns the project does not actually use.

Project coding conventions belong in `docs/rules/project-conventions.md` or linked language-specific rule files.
