from pathlib import Path
ROOT=Path(__file__).resolve().parents[1]
errors=[]
for flow in (ROOT/"docs/flow").glob("*.md"):
    if flow.name=="README.md": continue
    db=ROOT/"docs/db"/flow.name
    if not db.exists(): errors.append(f"missing: {db}")
if errors: raise SystemExit("\n".join(errors))
print("DB docs: OK")
