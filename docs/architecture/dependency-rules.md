# Dependency Rules

These are **sample dependency rules** for the included Laravel + TypeScript example, not universal Human-on-Exception requirements.

## Backend example

Allowed:

```text
Http → Application
Infrastructure → Application ports/read models
```

Disallowed:

```text
Application → Http
Application → Infrastructure
Infrastructure → Http
```

A Domain layer, when a project genuinely needs one, should remain framework-independent.

## Frontend example

Allowed:

```text
Page → Hook → API
Page → Presentation
Presentation → feature types / pure utilities
```

Disallowed:

```text
Presentation → direct network call
API client → React component
shared lib → feature-specific page
```

## Read-model rule

List/summary and detail shapes may differ deliberately.

Do not widen every list query/API response because a detail screen needs more data.

## Enforcement

A real project should replace/adapt these rules and add static dependency/import checks when documentation alone is insufficient.
