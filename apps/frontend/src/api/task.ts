import { request } from './apiClient'

/** Task 一覧用 API DTO */
export type TaskQuick = {
  id: number
  title: string
  status: string
  due_on: string | null
}

/** Task 詳細用 API DTO */
export type TaskDetail = TaskQuick & {
  description: string | null
  created_at: string
  updated_at: string | null
}

/** Task の書き込み */
export type TaskWriteInput = {
  title: string
  description: string
  status: string
  dueOn: string
}

/** Task 一覧を取得する */
export function getTasks(): Promise<TaskQuick[]> {
  return request<TaskQuick[]>('/api/tasks/')
}

/** Task 詳細を取得する */
export function getTask(id: number): Promise<TaskDetail> {
  return request<TaskDetail>(`/api/tasks/${id}/`)
}

/** Task を登録する */
export function createTask(input: TaskWriteInput): Promise<TaskDetail> {
  return request<TaskDetail>('/api/tasks/', {
    method: 'POST',
    body: JSON.stringify(buildTaskWriteBody(input)),
  })
}

/** Task を更新する */
export function updateTask(
  id: number,
  input: TaskWriteInput,
): Promise<TaskDetail> {
  return request<TaskDetail>(`/api/tasks/${id}/`, {
    method: 'PATCH',
    body: JSON.stringify(buildTaskWriteBody(input)),
  })
}

/** Task を論理削除する */
export function hideTask(id: number): Promise<void> {
  return request<void>(`/api/tasks/${id}/`, { method: 'DELETE' })
}

/** API へ送る Task 本文 */
export function buildTaskWriteBody(input: TaskWriteInput): {
  title: string
  description: string | null
  status: string
  due_on: string | null
} {
  const description = input.description.trim()
  const dueOn = input.dueOn.trim()
  return {
    title: input.title,
    description: description === '' ? null : description,
    status: input.status,
    due_on: dueOn === '' ? null : dueOn,
  }
}
