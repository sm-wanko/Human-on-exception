'use client'

import { TaskList } from '../components/TaskList'
import { useTaskList } from '../../../hooks/task/useTaskList'

type Props = {
  onOpenTask: (id: number) => void
}

/** Task 一覧ページの Presentation */
export function TaskListPagePresentation({ onOpenTask }: Props) {
  const { state } = useTaskList()

  if (state.kind === 'loading') return <p>Loading…</p>
  if (state.kind === 'error') return <p role="alert">{state.message}</p>
  if (state.kind === 'empty') return <p>No tasks yet.</p>

  return <TaskList tasks={state.tasks} onOpen={onOpenTask} />
}
