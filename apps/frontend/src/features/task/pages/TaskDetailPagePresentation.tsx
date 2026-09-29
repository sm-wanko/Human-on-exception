'use client'

import Link from 'next/link'
import { useTaskDetail } from '../../../hooks/task/useTaskDetail'
import {
  formatRegistrationDate,
  resolveTaskStatusLabel,
} from '../../../lib/task/resolveTaskStatusLabel'

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
    <article className="task-detail">
      <h1>{task.title}</h1>
      <p className="task-detail__description">{task.description ?? 'No description.'}</p>
      <p>登録日 {formatRegistrationDate(task.created_at)}</p>
      <p>終了予定日 {task.due_on ?? 'なし'}</p>
      <p><span className="badge">{resolveTaskStatusLabel(task.status)}</span></p>
      <div className="panel__actions">
        <Link className="button-link" href={`/tasks/${task.id}/edit/`}>編集</Link>
      </div>
    </article>
  )
}
