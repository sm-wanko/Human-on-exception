from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
FLOW_RE=re.compile(r"Flow ID:\s*([A-Z0-9_]+)")

def main():
    ap=argparse.ArgumentParser(); ap.add_argument("--out", required=True); args=ap.parse_args()
    out=Path(args.out); out.mkdir(parents=True, exist_ok=True)
    errors=[]
    for flow in (ROOT/"docs/flow").glob("*.md"):
        if flow.name=="README.md": continue
        text=flow.read_text()
        m=FLOW_RE.search(text)
        if not m: errors.append(f"{flow}: Flow ID missing"); continue
        for d in ("ui","validation","db"):
            peer=ROOT/"docs"/d/flow.name
            if not peer.exists(): errors.append(f"{flow.name}: missing docs/{d}/{flow.name}")
    (out/"summary.md").write_text("# Flow scope matrix survey\n\n"+("\n".join(f"- {e}" for e in errors) if errors else "- Gap 0"),encoding="utf-8")
    if errors: raise SystemExit("\n".join(errors))

if __name__=="__main__": main()
