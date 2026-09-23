'use client'

import { useTaskDetail } from '../../../hooks/task/useTaskDetail'

type Props = {
  taskId: number
}

/** Task 詳細ページの Presentation */
export function TaskDetailPagePresentation({ taskId }: Props) {
  const { task, loading, error } = useTaskDetail(taskId)

  if (loading) return <p>Loading…</p>
  if (error !== null) return <p role="alert">{error}</p>
  if (task === null) return <p role="alert">Not Found</p>

  return (
    <article>
      <h1>{task.title}</h1>
      <p>{task.description ?? 'No description.'}</p>
    </article>
  )
}
