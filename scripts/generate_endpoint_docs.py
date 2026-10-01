from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
ROUTE_RE=re.compile(r"Route::(get|post|patch|put|delete)\('([^']+)'")
TARGET=ROOT/"docs/endpoint/API一覧.md"

def render():
    routes=ROUTE_RE.findall((ROOT/"apps/backend/routes/api.php").read_text())
    lines=["# API 一覧","","Laravel route から生成。手編集しない。","", "| method | path |","|---|---|"]
    for method,path in routes:
        lines.append(f"| {method.upper()} | `/api{path}` |")
    return "\n".join(lines)+"\n"

def main():
    ap=argparse.ArgumentParser(); ap.add_argument("--check", action="store_true"); args=ap.parse_args()
    expected=render()
    if args.check:
        if not TARGET.exists() or TARGET.read_text()!=expected:
            raise SystemExit("docs/endpoint/API一覧.md is stale; run make docs")
        print("endpoint docs: OK")
        return
    TARGET.parent.mkdir(parents=True,exist_ok=True)
    TARGET.write_text(expected)
    print("endpoint docs updated")

if __name__=="__main__": main()
