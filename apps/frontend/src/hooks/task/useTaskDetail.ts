'use client'

import { useEffect, useState } from 'react'
import { getTask, type TaskDetail } from '../../api/task'

/** Task 詳細の取得状態を管理する */
export function useTaskDetail(taskId: number) {
  const [task, setTask] = useState<TaskDetail | null>(null)
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    setLoading(true)
    void getTask(taskId)
      .then(setTask)
      .catch((value: unknown) => {
        setError(value instanceof Error ? value.message : 'unknown error')
      })
      .finally(() => setLoading(false))
  }, [taskId])

  return { task, loading, error }
}
