from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
LITERAL_ID=re.compile(r"([A-Z0-9_]+-SYS-\d{3})")
PHP_FUNC_ID=re.compile(r"function\s+test_([A-Z0-9_]+)_SYS_(\d{3})")

def _fence_run(line):
    match=re.match(r"^ {0,3}(`{3,}|~{3,})(.*)$", line.rstrip())
    if not match:
        return None
    marks, rest=match.group(1), match.group(2)
    return marks[0], len(marks), rest

def claimed_ids(text, pattern):
    result=set()
    skip=False
    fence=None
    for line in text.splitlines():
        run=_fence_run(line)
        if fence:
            char, length=fence
            if run and run[0]==char and run[1]>=length and run[2].strip()=="":
                fence=None
            if not skip:
                result.update(pattern.findall(line))
            continue
        if run and not (run[0]=="`" and "`" in run[2]):
            fence=(run[0], run[1])
            if not skip:
                result.update(pattern.findall(line))
            continue
        heading=re.match(r"^ {0,3}(#{1,6})[ \t]+(.*)$", line)
        if heading:
            level=len(heading.group(1))
            title=re.sub(r"\s+#+\s*$", "", heading.group(2).strip()).strip()
            if level==2 and title=="未検証事項・矛盾":
                skip=True
                continue
            if skip and level<=2:
                skip=False
        if skip:
            continue
        result.update(pattern.findall(line))
    return result

def doc_ids():
    result=set()
    for p in (ROOT/"docs/flow").glob("*.md"):
        result.update(claimed_ids(p.read_text(), LITERAL_ID))
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
