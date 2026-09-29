/** STATUS の保存値と表示 */
export const TASK_STATUS_OPTIONS = [
  { value: 'not_started', label: '未着手' },
  { value: 'in_progress', label: '進行中' },
  { value: 'done', label: '完了' },
] as const

/** STATUS の表示ラベル */
export function resolveTaskStatusLabel(status: string): string {
  return (
    TASK_STATUS_OPTIONS.find((option) => option.value === status)?.label ??
    status
  )
}

/** 登録日。Asia/Tokyo の日付 */
export function formatRegistrationDate(createdAt: string): string {
  return new Intl.DateTimeFormat('sv-SE', {
    timeZone: 'Asia/Tokyo',
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
  }).format(new Date(createdAt))
}

/** チェックした Task を一覧から外す */
export function excludeTask<T extends { id: number }>(
  tasks: T[],
  id: number,
): T[] {
  return tasks.filter((task) => task.id !== id)
}
