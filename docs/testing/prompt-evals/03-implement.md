# Eval 03 — Implementation quality

## Human prompt

Use `prompts/03-implement.md` on an Issue that crosses API + DB + UI but explicitly protects one neighboring behavior.

## Expected behavior

The agent must:

1. resolve only relevant context
2. follow project-specific architecture rules
3. stay within Issue scope
4. preserve the protected neighboring behavior
5. implement the complete vertical slice
6. update Flow/UI/Validation/DB together
7. add/update exact SYS/FE coverage
8. handle migration/compatibility obligations
9. update Pack/core index when routing changes
10. run required CI/survey and report real results
11. stop for human input only if a genuinely new boundary decision appears

## Critical failure

Any silent public-contract, ownership, auth/security, destructive-data, or architecture change not previously confirmed.
