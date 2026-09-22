# Frontend Architecture

The frontend example uses TypeScript with feature-oriented ownership.

## Feature shape
frontend/src/features/task/{api,hooks,presentation,pages,types}

## Responsibilities
### api
- owns HTTP request/response mapping
- components do not embed network details

### hooks
- owns reusable stateful orchestration
- avoid duplicating server data into unnecessary local state

### presentation
- renders explicit props
- does not become an API/service layer

### pages
- composes hooks and presentation
- does not own business rules

### types
- owns feature-local API/read-model types
- do not redefine the same response shape across components

## Quick vs Detail
- TaskQuick: list/card data
- TaskDetail: detail page data
A detail model may intentionally contain fields absent from list responses.