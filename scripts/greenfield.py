#!/usr/bin/env python3
from __future__ import annotations

import shutil
import subprocess
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]

DELETE_PATHS = [
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

REPLACEMENTS = {
    "apps/backend/routes/api.php": """<?php

use Illuminate\\Support\\Facades\\Route;

// Greenfield: add API routes from accepted Issues / Flow contracts.
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

def ensure_clean_worktree() -> None:
    try:
        result = subprocess.run(
            ["git", "status", "--porcelain"],
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
            "Commit/stash current work, then run make greenfield again."
        )

def remove_path(relative: str) -> None:
    path = ROOT / relative
    if path.is_dir():
        shutil.rmtree(path)
        print(f"removed {relative}/")
    elif path.exists():
        path.unlink()
        print(f"removed {relative}")

def write_text(relative: str, content: str) -> None:
    path = ROOT / relative
    path.parent.mkdir(parents=True, exist_ok=True)
    path.write_text(content, encoding="utf-8")
    print(f"reset {relative}")

def rewrite_readme() -> None:
    path = ROOT / "README.md"
    text = path.read_text(encoding="utf-8")
    marker = "## Sample\n"
    if marker not in text:
        return
    before = text.split(marker, 1)[0].rstrip()
    replacement = """## Sample / Greenfield

The repository ships with a minimal `TASK_CRUD` executable example. Running `make greenfield` removes that product-specific sample while preserving the Human-on-Exception workflow, prompts, rules, templates, CI, and application skeleton.

After `make greenfield`, start product definition from [1B. Greenfield](./prompts/01-define-greenfield.md).

この repo には実行可能な最小 `TASK_CRUD` サンプルが含まれる。`make greenfield` を実行すると、Human-on-Exception の workflow / prompts / rules / templates / CI / application skeleton を残したまま、プロダクト固有のサンプルだけを削除する。

Greenfield 化後は [1B. Greenfield](./prompts/01-define-greenfield.md) からプロダクト定義を開始する。
"""
    path.write_text(before + "\n\n" + replacement, encoding="utf-8")
    print("updated README.md")

def main() -> None:
    ensure_clean_worktree()

    for relative in DELETE_PATHS:
        remove_path(relative)

    for relative, content in REPLACEMENTS.items():
        write_text(relative, content)

    rewrite_readme()

    print("")
    print("Greenfield conversion complete.")
    print("Next: review git diff, then start with prompts/01-define-greenfield.md.")
    print("Recommended verification: make lint && make test && make survey")

if __name__ == "__main__":
    main()
