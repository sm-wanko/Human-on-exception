import type { TaskQuick } from '../../api/task'

/** Task 一覧の表示状態 */
export type TaskListState =
  | { kind: 'loading' }
  | { kind: 'error'; message: string }
  | { kind: 'empty' }
  | { kind: 'ready'; tasks: TaskQuick[] }

/** Task 一覧の表示状態を決定する */
export function resolveTaskListState(input: {
  tasks: TaskQuick[]
  loading: boolean
  error: string | null
}): TaskListState {
  if (input.loading) return { kind: 'loading' }
  if (input.error !== null) return { kind: 'error', message: input.error }
  if (input.tasks.length === 0) return { kind: 'empty' }
  return { kind: 'ready', tasks: input.tasks }
}
