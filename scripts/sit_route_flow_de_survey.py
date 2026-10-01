from __future__ import annotations
import argparse, re
from pathlib import Path

ROOT=Path(__file__).resolve().parents[1]
FLOW_RE=re.compile(r"Flow ID:\s*([A-Z0-9_]+)")
ROUTE_RE=re.compile(r"Route::(get|post|patch|put|delete)\('([^']+)'")

def main():
    ap=argparse.ArgumentParser(); ap.add_argument("--out", required=True); args=ap.parse_args()
    out=Path(args.out); out.mkdir(parents=True, exist_ok=True)
    flows={}
    for p in (ROOT/"docs/flow").glob("*.md"):
        m=FLOW_RE.search(p.read_text())
        if m: flows[m.group(1)]=p.name
    routes=ROUTE_RE.findall((ROOT/"apps/backend/routes/api.php").read_text())
    report=["# Route / Flow survey","",f"- Flow count: {len(flows)}",f"- Route count: {len(routes)}",""]
    (out/"summary.md").write_text("\n".join(report), encoding="utf-8")

if __name__=="__main__": main()
