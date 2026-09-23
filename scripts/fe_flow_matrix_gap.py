from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
ID=re.compile(r"([A-Z0-9_]+-FE-\d{3})")

def ids(paths):
    result=set()
    for p in paths:
        try: result.update(ID.findall(p.read_text()))
        except UnicodeDecodeError: pass
    return result

def main():
    ap=argparse.ArgumentParser(); ap.add_argument("--out", required=True); args=ap.parse_args()
    out=Path(args.out); out.mkdir(parents=True, exist_ok=True)
    doc=ids((ROOT/"docs/flow").glob("*.md"))
    test=ids((ROOT/"apps/frontend/src").rglob("*.test.ts*"))
    a=sorted(doc-test); b=sorted(test-doc)
    lines=["# FE matrix gap","",f"- docs only: {len(a)}",f"- tests only: {len(b)}"]
    if a: lines+=["","## Gap A"]+[f"- {x}" for x in a]
    if b: lines+=["","## Gap B"]+[f"- {x}" for x in b]
    (out/"summary.md").write_text("\n".join(lines),encoding="utf-8")
    if a or b: raise SystemExit("FE matrix gap")

if __name__=="__main__": main()
