#!/usr/bin/env python3
from __future__ import annotations

import argparse
import re
from pathlib import Path

FIELDS = ("Total", "✅ Pass", "❌ Fail", "⏭ Skip", "⏱ Duration")

def read_summary(path: Path) -> dict[str, str]:
    text = path.read_text(encoding="utf-8") if path.exists() else ""
    out: dict[str, str] = {}
    for key in FIELDS:
        m = re.search(rf"^- {re.escape(key)}: (.+)$", text, re.MULTILINE)
        if m:
            out[key] = m.group(1)
    return out

def main() -> int:
    p = argparse.ArgumentParser()
    p.add_argument("--dir", type=Path, required=True)
    p.add_argument("--output", type=Path, required=True)
    args = p.parse_args()

    reports = [
        ("Backend Unit", args.dir / "backend-unit.md"),
        ("SIT", args.dir / "sit.md"),
        ("Frontend Vitest", args.dir / "vitest.md"),
        ("Frontend Integration", args.dir / "vitest-integration.md"),
    ]
    lines = [
        "# Test Summary",
        "",
        "| Group | Total | Pass | Fail | Skip | Duration | Report |",
        "|---|---:|---:|---:|---:|---:|---|",
    ]
    for label, path in reports:
        s = read_summary(path)
        lines.append(
            f"| {label} | {s.get('Total', '-')} | {s.get('✅ Pass', '-')} | {s.get('❌ Fail', '-')} | "
            f"{s.get('⏭ Skip', '-')} | {s.get('⏱ Duration', '-')} | [{path.name}](./{path.name}) |"
        )
    args.output.parent.mkdir(parents=True, exist_ok=True)
    args.output.write_text("\n".join(lines) + "\n", encoding="utf-8")
    return 0

if __name__ == "__main__":
    raise SystemExit(main())
