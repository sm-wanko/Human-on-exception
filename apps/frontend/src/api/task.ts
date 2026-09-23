import { request } from './apiClient'

/** Task 一覧用 API DTO */
export type TaskQuick = {
  id: number
  title: string
}

/** Task 詳細用 API DTO */
export type TaskDetail = TaskQuick & {
  description: string | null
  created_at: string
  updated_at: string | null
}

/** Task 一覧を取得する */
export function getTasks(): Promise<TaskQuick[]> {
  return request<TaskQuick[]>('/api/tasks')
}

/** Task 詳細を取得する */
export function getTask(id: number): Promise<TaskDetail> {
  return request<TaskDetail>(`/api/tasks/${id}`)
}
