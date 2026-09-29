#!/usr/bin/env python3
"""Generate human-readable Markdown reports from PHPUnit JUnit or Vitest JSON."""

from __future__ import annotations

import argparse
import json
from pathlib import Path
import xml.etree.ElementTree as ET


def status_icon(status: str) -> str:
    return {"pass": "✅", "fail": "❌", "skip": "⏭"}.get(status, "•")


def write_report(title: str, rows: list[dict[str, object]], output: Path) -> None:
    passed = sum(1 for r in rows if r["status"] == "pass")
    failed = sum(1 for r in rows if r["status"] == "fail")
    skipped = sum(1 for r in rows if r["status"] == "skip")
    duration = sum(float(r.get("duration", 0.0) or 0.0) for r in rows)

    lines = [
        f"# {title}",
        "",
        "## Summary",
        f"- Total: {len(rows)}",
        f"- ✅ Pass: {passed}",
        f"- ❌ Fail: {failed}",
        f"- ⏭ Skip: {skipped}",
        f"- ⏱ Duration: {duration:.2f}s",
        "",
        "## Failed cases",
        "",
    ]

    failures = [r for r in rows if r["status"] == "fail"]
    if failures:
        for row in failures:
            detail = str(row.get("detail", "")).strip().replace("\n", " ")
            lines.append(f"- `{row['id']}` — {detail or row['name']}")
    else:
        lines.append("- None")

    lines += ["", "## Cases", "", "| Status | ID | Test | Duration |", "|---|---|---|---:|"]
    for row in rows:
        test_id = str(row["id"]).replace("|", "\\|")
        name = str(row["name"]).replace("|", "\\|")
        lines.append(
            f"| {status_icon(str(row['status']))} | `{test_id}` | {name} | {float(row.get('duration', 0.0) or 0.0):.2f}s |"
        )

    output.parent.mkdir(parents=True, exist_ok=True)
    output.write_text("\n".join(lines) + "\n", encoding="utf-8")


def parse_phpunit(path: Path) -> list[dict[str, object]]:
    root = ET.parse(path).getroot()
    rows: list[dict[str, object]] = []
    for case in root.iter("testcase"):
        classname = case.attrib.get("class", "")
        name = case.attrib.get("name", "")
        test_id = f"{classname}::{name}" if classname else name
        failure = case.find("failure")
        error = case.find("error")
        skipped = case.find("skipped")
        if failure is not None or error is not None:
            node = failure if failure is not None else error
            status = "fail"
            detail = (node.text or node.attrib.get("message", "")) if node is not None else ""
        elif skipped is not None:
            status = "skip"
            detail = skipped.attrib.get("message", "") or (skipped.text or "")
        else:
            status = "pass"
            detail = ""
        rows.append(
            {
                "id": test_id,
                "name": name,
                "status": status,
                "duration": float(case.attrib.get("time", 0) or 0),
                "detail": detail,
            }
        )
    return rows


def parse_vitest(path: Path) -> list[dict[str, object]]:
    data = json.loads(path.read_text(encoding="utf-8"))
    rows: list[dict[str, object]] = []
    for suite in data.get("testResults", []):
        file_name = suite.get("name", "")
        for assertion in suite.get("assertionResults", []):
            raw_status = assertion.get("status", "")
            status = {"passed": "pass", "failed": "fail", "pending": "skip", "skipped": "skip", "todo": "skip"}.get(
                raw_status, "fail"
            )
            full_name = assertion.get("fullName") or assertion.get("title") or "unknown"
            failure_messages = assertion.get("failureMessages") or []
            rows.append(
                {
                    "id": f"{file_name}::{full_name}",
                    "name": full_name,
                    "status": status,
                    "duration": float(assertion.get("duration") or 0) / 1000,
                    "detail": " ".join(str(x) for x in failure_messages),
                }
            )
    return rows


def main() -> int:
    parser = argparse.ArgumentParser()
    parser.add_argument("--format", choices=["phpunit", "vitest"], required=True)
    parser.add_argument("--input", type=Path, required=True)
    parser.add_argument("--output", type=Path, required=True)
    parser.add_argument("--title", required=True)
    args = parser.parse_args()

    rows = parse_phpunit(args.input) if args.format == "phpunit" else parse_vitest(args.input)
    write_report(args.title, rows, args.output)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
