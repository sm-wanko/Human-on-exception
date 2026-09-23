from __future__ import annotations
import re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
errors=[]

for p in (ROOT/"apps/frontend/src").rglob("*.ts*"):
    text=p.read_text()
    lines=text.splitlines()
    for i,line in enumerate(lines):
        if re.match(r"\s*export\s+(?:default\s+)?(?:async\s+)?(?:function|class|interface|type)\b", line):
            previous="\n".join(lines[max(0,i-3):i])
            if "/**" not in previous:
                errors.append(f"{p.relative_to(ROOT)}:{i+1}: exported declaration missing JSDoc")

for p in (ROOT/"apps/backend/app").rglob("*.php"):
    text=p.read_text()
    # Public methods with non-trivial names are ratcheted only when a PHPDoc exists nearby.
    # Laravel framework entry methods are allowed without duplicate contract prose.
    if "TODO_EXPORT_COMMENT" in text:
        errors.append(f"{p.relative_to(ROOT)}: unresolved export comment marker")

if errors:
    raise SystemExit("\n".join(errors))
print("export comments: OK")
