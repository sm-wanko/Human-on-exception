'use client'

import { useEffect, useMemo, useState } from 'react'
import { getTasks, type TaskQuick } from '../../api/task'
import { resolveTaskListState } from '../../lib/task/resolveTaskListState'

/** Task 一覧の取得状態を管理する */
export function useTaskList() {
  const [tasks, setTasks] = useState<TaskQuick[]>([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    void getTasks()
      .then(setTasks)
      .catch((value: unknown) => {
        setError(value instanceof Error ? value.message : 'unknown error')
      })
      .finally(() => setLoading(false))
  }, [])

  const state = useMemo(
    () => resolveTaskListState({ tasks, loading, error }),
    [tasks, loading, error],
  )

  return { state }
}
