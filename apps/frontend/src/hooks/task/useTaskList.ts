'use client'

import { useCallback, useEffect, useMemo, useState } from 'react'
import { getTasks, hideTask, type TaskQuick } from '../../api/task'
import { excludeTask } from '../../lib/task/resolveTaskStatusLabel'
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

  const hide = useCallback(async (id: number) => {
    await hideTask(id)
    setTasks((current) => excludeTask(current, id))
  }, [])

  const state = useMemo(
    () => resolveTaskListState({ tasks, loading, error }),
    [tasks, loading, error],
  )

  return { state, hide }
}
