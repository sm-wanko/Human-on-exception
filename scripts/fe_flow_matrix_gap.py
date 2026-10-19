from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
ID=re.compile(r"([A-Z0-9_]+-FE-\d{3})")

def claimed_ids(text, pattern):
    result=set()
    skip=False
    fence=None
    for line in text.splitlines():
        marker=re.match(r"^ {0,3}(```+|~~~+)", line.rstrip())
        if marker:
            token=marker.group(1)[0]
            fence=None if fence==token else token
            if not skip:
                result.update(pattern.findall(line))
            continue
        if fence:
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

def ids(paths):
    result=set()
    for p in paths:
        try: text=p.read_text()
        except UnicodeDecodeError: continue
        if p.parent == (ROOT/"docs/flow"):
            result.update(claimed_ids(text, ID))
            continue
        result.update(ID.findall(text))
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
