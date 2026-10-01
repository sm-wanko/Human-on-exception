'use client'

import { useParams } from 'next/navigation'
import { TaskDetailPagePresentation } from '../../../features/task/pages/TaskDetailPagePresentation'

/** Task 詳細 route */
export default function TaskDetailPage() {
  const params = useParams<{ id: string }>()
  return <TaskDetailPagePresentation taskId={Number(params.id)} />
}
