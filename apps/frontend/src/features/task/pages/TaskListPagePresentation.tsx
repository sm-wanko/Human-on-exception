'use client'

import Link from 'next/link'
import { TaskList } from '../components/TaskList'
import { useTaskList } from '../../../hooks/task/useTaskList'

type Props = {
  onOpenTask: (id: number) => void
}

/** Task 一覧ページの Presentation */
export function TaskListPagePresentation({ onOpenTask }: Props) {
  const { state, hide } = useTaskList()

  if (state.kind === 'loading') return <p>Loading…</p>
  if (state.kind === 'error') return <p role="alert">{state.message}</p>

  return (
    <section>
      <Link href="/tasks/new/">登録</Link>
      {state.kind === 'empty' ? <p>No tasks yet.</p> : null}
      {state.kind === 'ready' ? (
        <TaskList
          tasks={state.tasks}
          onOpen={onOpenTask}
          onHide={(id) => void hide(id)}
        />
      ) : null}
    </section>
  )
}
