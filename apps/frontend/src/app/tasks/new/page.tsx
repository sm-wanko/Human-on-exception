'use client'

import { useRouter } from 'next/navigation'
import { createTask } from '../../../api/task'
import { TaskFormPresentation } from '../../../features/task/pages/TaskFormPresentation'

/** Task 登録 route */
export default function NewTaskPage() {
  const router = useRouter()

  return (
    <TaskFormPresentation
      createdAt={null}
      initial={{ title: '', description: '', status: 'not_started', dueOn: '' }}
      onSubmit={async (input) => {
        const created = await createTask(input)
        router.push(`/tasks/${created.id}/`)
      }}
    />
  )
}
