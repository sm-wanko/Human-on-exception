from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
LITERAL_ID=re.compile(r"([A-Z0-9_]+-SYS-\d{3})")
PHP_FUNC_ID=re.compile(r"function\s+test_([A-Z0-9_]+)_SYS_(\d{3})")

def doc_ids():
    result=set()
    for p in (ROOT/"docs/flow").glob("*.md"):
        result.update(LITERAL_ID.findall(p.read_text()))
    return result

def test_ids():
    result=set()
    for p in (ROOT/"apps/backend/tests").rglob("*.php"):
        text=p.read_text()
        result.update(LITERAL_ID.findall(text))
        for flow,num in PHP_FUNC_ID.findall(text):
            result.add(f"{flow}-SYS-{num}")
    return result

def main():
    ap=argparse.ArgumentParser(); ap.add_argument("--out", required=True); args=ap.parse_args()
    out=Path(args.out); out.mkdir(parents=True, exist_ok=True)
    doc=doc_ids(); test=test_ids()
    a=sorted(doc-test); b=sorted(test-doc)
    lines=["# SIT matrix gap","",f"- docs only: {len(a)}",f"- tests only: {len(b)}"]
    if a: lines+=["","## Gap A"]+[f"- {x}" for x in a]
    if b: lines+=["","## Gap B"]+[f"- {x}" for x in b]
    (out/"summary.md").write_text("\n".join(lines),encoding="utf-8")
    if a or b: raise SystemExit("SIT matrix gap")

if __name__=="__main__": main()
