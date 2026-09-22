from __future__ import annotations

import re
import sys
from pathlib import Path
from urllib.parse import unquote

ROOT = Path(__file__).resolve().parents[1]
FLOW_DIR = ROOT / "docs" / "flow"
PACK_DIR = ROOT / "docs" / "ai" / "packs"
CORE_INDEX = ROOT / "docs" / "testing" / "core-features.md"

FLOW_ID_RE = re.compile(r"\*\*Flow ID\*\*:\s*`([A-Z0-9_]+)`")
PACK_RE = re.compile(r"\*\*Pack\*\*:\s*`([^`]+)`")
TEST_ID_RE = re.compile(r"([A-Z0-9_]+-(?:SYS|FE)-\d{3})")
MD_LINK_RE = re.compile(r"\[[^\]]*\]\(([^)]+)\)")

SOURCE_SUFFIXES = {
    ".py", ".go", ".ts", ".tsx", ".js", ".jsx",
    ".rs", ".java", ".kt", ".rb", ".php",
}
SKIP_LINK_PREFIXES = ("http://", "https://", "mailto:", "#")


def fail(msg: str, errors: list[str]) -> None:
    errors.append(msg)


def read_text(path: Path) -> str:
    return path.read_text(encoding="utf-8")


def source_files() -> list[Path]:
    result: list[Path] = []
    for path in ROOT.rglob("*"):
        if not path.is_file():
            continue
        if any(part in {".git", "vendor", "node_modules"} for part in path.parts):
            continue
        if "docs" in path.parts:
            continue
        if path.suffix in SOURCE_SUFFIXES:
            result.append(path)
    return result


def executable_text() -> str:
    chunks: list[str] = []
    for path in source_files():
        try:
            chunks.append(read_text(path))
        except UnicodeDecodeError:
            pass
    return "\n".join(chunks)


def check_markdown_links(errors: list[str]) -> None:
    for path in ROOT.rglob("*.md"):
        if any(part in {".git", "vendor", "node_modules"} for part in path.parts):
            continue
        text = read_text(path)
        for raw in MD_LINK_RE.findall(text):
            target = raw.strip().split("#", 1)[0].strip()
            if not target or target.startswith(SKIP_LINK_PREFIXES):
                continue
            target = unquote(target)
            resolved = (path.parent / target).resolve()
            try:
                resolved.relative_to(ROOT.resolve())
            except ValueError:
                continue
            if not resolved.exists():
                fail(
                    f"{path.relative_to(ROOT)}: broken local markdown link -> {raw}",
                    errors,
                )


def main() -> int:
    errors: list[str] = []
    impl_text = executable_text()
    source_ids = set(TEST_ID_RE.findall(impl_text))

    if not CORE_INDEX.exists():
        fail("missing docs/testing/core-features.md", errors)
        core_text = ""
    else:
        core_text = read_text(CORE_INDEX)

    flow_files = sorted(FLOW_DIR.glob("*.md"))
    if not flow_files:
        fail("no docs/flow/*.md found", errors)

    documented_ids: set[str] = set()

    for flow in flow_files:
        text = read_text(flow)
        flow_match = FLOW_ID_RE.search(text)
        if not flow_match:
            fail(f"{flow.relative_to(ROOT)}: missing **Flow ID**", errors)
            continue

        flow_id = flow_match.group(1)
        stem = flow.stem
        flow_test_ids = set(TEST_ID_RE.findall(text))
        documented_ids.update(flow_test_ids)

        pack_match = PACK_RE.search(text)
        if not pack_match:
            fail(f"{flow.relative_to(ROOT)}: missing **Pack**", errors)
            pack_name = None
        else:
            pack_name = pack_match.group(1)
            pack = PACK_DIR / f"{pack_name}.md"
            if not pack.exists():
                fail(f"{flow.relative_to(ROOT)}: pack not found: {pack.relative_to(ROOT)}", errors)
            else:
                pack_text = read_text(pack)
                if flow_id not in pack_text:
                    fail(f"{pack.relative_to(ROOT)}: does not mention Flow ID {flow_id}", errors)

        if flow_id not in core_text:
            fail(f"{flow.relative_to(ROOT)}: Flow ID {flow_id} missing from core-features index", errors)
        if pack_name and pack_name not in core_text:
            fail(f"{flow.relative_to(ROOT)}: Pack {pack_name} missing from core-features index", errors)

        for quadrant in ("ui", "validation", "db"):
            peer = ROOT / "docs" / quadrant / f"{stem}.md"
            if not peer.exists():
                fail(f"{flow.relative_to(ROOT)}: missing {peer.relative_to(ROOT)}", errors)
                continue
            peer_text = read_text(peer)
            peer_flow = FLOW_ID_RE.search(peer_text)
            if not peer_flow:
                fail(f"{peer.relative_to(ROOT)}: missing **Flow ID**", errors)
            elif peer_flow.group(1) != flow_id:
                fail(
                    f"{peer.relative_to(ROOT)}: Flow ID {peer_flow.group(1)} != {flow_id}",
                    errors,
                )

        for test_id in sorted(flow_test_ids):
            if test_id not in source_ids:
                fail(
                    f"{flow.relative_to(ROOT)}: planned test ID not found in executable source: {test_id}",
                    errors,
                )

    for test_id in sorted(source_ids - documented_ids):
        fail(f"executable source contains undocumented Flow test ID: {test_id}", errors)

    check_markdown_links(errors)

    if errors:
        print("Repository survey FAILED")
        for error in errors:
            print(f"- {error}")
        return 1

    print(
        "Repository survey OK: "
        f"{len(flow_files)} flow(s), "
        f"{len(documented_ids)} documented test ID(s), "
        f"{len(source_ids)} executable test ID reference(s)"
    )
    return 0


if __name__ == "__main__":
    sys.exit(main())
