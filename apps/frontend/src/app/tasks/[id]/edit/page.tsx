'use client'

import { useParams, useRouter } from 'next/navigation'
import { useEffect, useState } from 'react'
import { getTask, updateTask, type TaskDetail } from '../../../../api/task'
import { TaskFormPresentation } from '../../../../features/task/pages/TaskFormPresentation'

/** Task 編集 route */
export default function EditTaskPage() {
  const params = useParams<{ id: string }>()
  const router = useRouter()
  const taskId = Number(params.id)
  const [task, setTask] = useState<TaskDetail | null>(null)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    void getTask(taskId)
      .then(setTask)
      .catch((value: unknown) => {
        setError(value instanceof Error ? value.message : 'unknown error')
      })
  }, [taskId])

  if (error !== null) return <p role="alert">{error}</p>
  if (task === null) return <p>Loading…</p>

  return (
    <TaskFormPresentation
      createdAt={task.created_at}
      initial={{
        title: task.title,
        description: task.description ?? '',
        status: task.status,
        dueOn: task.due_on ?? '',
      }}
      onSubmit={async (input) => {
        await updateTask(task.id, input)
        router.push(`/tasks/${task.id}/`)
      }}
    />
  )
}
