'use client'

import { useRouter } from 'next/navigation'
import { TaskListPagePresentation } from '../../features/task/pages/TaskListPagePresentation'
import { resolveTaskOpenPath } from '../../lib/task/resolveTaskOpenPath'

/** Task 一覧 route */
export default function TasksPage() {
  const router = useRouter()

  return (
    <TaskListPagePresentation
      onOpenTask={(id) => router.push(resolveTaskOpenPath(id))}
    />
  )
}
