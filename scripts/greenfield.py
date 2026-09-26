#!/usr/bin/env python3
from __future__ import annotations

import argparse
import shutil
import subprocess
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
EXAMPLE_ID = "EXAMPLE_TASK_CRUD"
TRASH_ROOT = ROOT / ".trash" / "examples" / EXAMPLE_ID

ARCHIVE_PATHS = [
    "apps/backend/app/DTO/Task",
    "apps/backend/app/Http/Controllers/TaskController.php",
    "apps/backend/app/Http/Requests/TaskWriteRequest.php",
    "apps/backend/app/Models/Task.php",
    "apps/backend/app/Repositories/Task",
    "apps/backend/app/Services/Task",
    "apps/backend/database/migrations/2026_09_22_000001_create_tasks_table.php",
    "apps/backend/tests/System/TaskCrudSystemTest.php",
    "apps/frontend/src/api/task.ts",
    "apps/frontend/src/app/tasks",
    "apps/frontend/src/features/task",
    "apps/frontend/src/hooks/task",
    "apps/frontend/src/lib/task",
    "docs/ai/packs/task-crud.md",
    "docs/concept/task-crud.md",
    "docs/db/タスクCRUD.md",
    "docs/flow/タスクCRUD.md",
    "docs/testing/examples/task-crud-issue.md",
    "docs/testing/questions/task-crud.md",
    "docs/ui/タスクCRUD.md",
    "docs/validation/タスクCRUD.md",
]

SHARED_RESET = {
    "apps/backend/routes/api.php": """<?php

use Illuminate\\Support\\Facades\\Route;

// Greenfield: add API routes only after an accepted Issue / Flow contract exists.
""",
    "apps/frontend/src/app/page.tsx": """export default function HomePage() {
  return (
    <main>
      <h1>Human-on-Exception</h1>
      <p>Greenfield state. Start from prompts/01-define-greenfield.md.</p>
    </main>
  )
}
""",
    "docs/testing/core-features.md": """# コア機能 × Flow 束 × pack

AI が初期探索で読む索引。実装本文は書かず、**束・Flow ID・実装パス・pack**だけを持つ。

Greenfield 初期状態では bundle は 0 件。最初の Accepted Issue が Pack / Flow を作成した時点で追加する。

| # | 束 | Pack | Flow ID | 主な実装 |
|---|----|------|---------|----------|

## 束（pack）一覧

| Pack | Flow | 完了 |
|------|------|------|

Done 定義: [bundle-completion.md](./bundle-completion.md)
""",
    "docs/concept/README.md": """# Concept

プロダクトの目的・主要概念・意味の境界を置く。

Greenfield 初期状態では product concept は 0 件。人間の Intent と Answers をもとに、AI が必要な concept を作成する。

Development model: [README](../../README.md) / [AI execution contract](../rules/ai-workflow.md)
""",
    "docs/flow/README.md": """# Flow docs

機能ごとの current behavior / target contract を 4 点セットで管理する。

Greenfield 初期状態では Flow は 0 件。Accepted Issue から最初の Flow を作成する。

**Frontend Flow Contract**: [docs/testing/frontend-flow-contract.md](../testing/frontend-flow-contract.md)
""",
    "docs/testing/questions/README.md": """# Questions

人間の semantic authority が必要な意思決定だけを記録する。

Greenfield 初期状態では Questions は 0 件でもよい。[Questions template](../../templates/questions.md) と [AI execution contract](../../rules/ai-workflow.md) §2–3 に従い、AI が技術判断と意味判断を分離する。
""",
    "docs/transition/遷移定義.md": """# 画面遷移定義（正本）

Frontend App Router の画面遷移の正本。

Greenfield 初期状態では product route / edge は 0 件。Accepted Issue の UI 契約に応じて追加する。

## エッジ種別（kind）

| kind | 実装 |
|---|---|
| `push` | `router.push` |
| `link` | `Link` / href |

<!-- nodes -->

| route | label |
|---|---|

<!-- edges -->

| from | to | kind | condition |
|---|---|---|---|
""",
    "docs/endpoint/API一覧.md": """# API 一覧

Laravel route から生成。手編集しない。

| method | path |
|---|---|
""",
}

def parse_args() -> argparse.Namespace:
    parser = argparse.ArgumentParser()
    parser.add_argument("--dry-run", action="store_true")
    parser.add_argument("--confirm", action="store_true")
    return parser.parse_args()

def ensure_clean_worktree() -> None:
    try:
        result = subprocess.run(
            ["git", "status", "--porcelain", "--untracked-files=normal"],
            cwd=ROOT,
            check=True,
            capture_output=True,
            text=True,
        )
    except (FileNotFoundError, subprocess.CalledProcessError) as exc:
        raise SystemExit("greenfield requires a git working tree") from exc

    if result.stdout.strip():
        raise SystemExit(
            "greenfield aborted: working tree is not clean. "
            "Commit/stash current work, then retry."
        )

def existing_sources() -> list[str]:
    return [p for p in ARCHIVE_PATHS if (ROOT / p).exists()]

def print_plan() -> None:
    print(f"Greenfield conversion plan: {EXAMPLE_ID}")
    print("")
    print("Archive to ignored trash:")
    for relative in ARCHIVE_PATHS:
        status = "move" if (ROOT / relative).exists() else "already absent"
        print(f"  [{status}] {relative}")
    print("")
    print("Archive snapshot + reset shared active files:")
    for relative in SHARED_RESET:
        status = "snapshot/reset" if (ROOT / relative).exists() else "create neutral"
        print(f"  [{status}] {relative}")
    print("")
    print(f"Trash destination: {TRASH_ROOT.relative_to(ROOT)}/")
    print("Active target after conversion: Pack 0 / Flow 0 / product SYS 0 / product FE 0")
    print("Next prompt: prompts/01-define-greenfield.md")

def archive(relative: str) -> None:
    src = ROOT / relative
    if not src.exists():
        return
    dst = TRASH_ROOT / relative
    if dst.exists():
        raise SystemExit(f"greenfield aborted: trash destination already exists: {dst}")
    dst.parent.mkdir(parents=True, exist_ok=True)
    shutil.move(str(src), str(dst))
    print(f"archived {relative}")

def reset_shared(relative: str, content: str) -> None:
    src = ROOT / relative
    if src.exists():
        snapshot = TRASH_ROOT / "_shared" / relative
        if snapshot.exists():
            raise SystemExit(f"greenfield aborted: trash snapshot already exists: {snapshot}")
        snapshot.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(src, snapshot)
    src.parent.mkdir(parents=True, exist_ok=True)
    src.write_text(content, encoding="utf-8")
    print(f"reset {relative}")

def rewrite_readme() -> None:
    path = ROOT / "README.md"
    text = path.read_text(encoding="utf-8")
    text = text.replace("- Task list: http://localhost:3000/tasks/\n", "")
    text = text.replace("- Backend API: http://localhost:8080/api/tasks\n", "")
    start = text.find("Create a Task:\n")
    if start >= 0:
        end = text.find("\n## Development commands", start)
        if end >= 0:
            text = text[:start] + text[end + 1:]
    sample = text.find("## Sample\n")
    if sample >= 0:
        text = text[:sample].rstrip() + """

## Greenfield state

The executable teaching bundle has been archived locally under ignored `.trash/` and removed from the active product tree.

Start with [0. Greenfield bootstrap](./prompts/00-greenfield.md) for the conversion contract or continue product definition with [1B. Greenfield](./prompts/01-define-greenfield.md).

実行教材は ignore 対象の `.trash/` へローカル退避され、active product tree から切り離されている。

変換契約は [0. Greenfield bootstrap](./prompts/00-greenfield.md)、プロダクト定義は [1B. Greenfield](./prompts/01-define-greenfield.md) から開始する。
"""
    path.write_text(text, encoding="utf-8")
    print("updated README.md")

def main() -> None:
    args = parse_args()
    ensure_clean_worktree()
    print_plan()

    if args.dry_run:
        print("")
        print("Dry-run only. No files changed.")
        return

    if not args.confirm:
        raise SystemExit(
            "greenfield aborted: confirmation required. "
            "Run 'make greenfield DRY_RUN=1' first, then 'make greenfield CONFIRM=1'."
        )

    if not existing_sources() and all(
        (ROOT / path).read_text(encoding="utf-8") == content
        for path, content in SHARED_RESET.items()
        if (ROOT / path).exists()
    ):
        print("")
        print("Already in greenfield state.")
        return

    for relative in ARCHIVE_PATHS:
        archive(relative)

    for relative, content in SHARED_RESET.items():
        reset_shared(relative, content)

    rewrite_readme()

    print("")
    print("Greenfield conversion complete.")
    print(f"Local archive: {TRASH_ROOT.relative_to(ROOT)}/ (gitignored)")
    print("Next: make lint && make test && make survey")
    print("Then: prompts/01-define-greenfield.md")

if __name__ == "__main__":
    main()
