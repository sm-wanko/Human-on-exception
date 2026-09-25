import type { TaskQuick } from '../../../api/task'
import { resolveTaskStatusLabel } from '../../../lib/task/resolveTaskStatusLabel'

type Props = {
  tasks: TaskQuick[]
  onOpen: (id: number) => void
  onHide: (id: number) => void
}

/** Task 一覧を描画する */
export function TaskList({ tasks, onOpen, onHide }: Props) {
  return (
    <ul>
      {tasks.map((task) => (
        <li key={task.id}>
          <input
            type="checkbox"
            aria-label={`${task.title} を一覧から外す`}
            onChange={() => onHide(task.id)}
          />
          <button type="button" onClick={() => onOpen(task.id)}>
            {task.title}
          </button>
          <span>{resolveTaskStatusLabel(task.status)}</span>
          <span>{task.due_on ?? '終了予定なし'}</span>
        </li>
      ))}
    </ul>
  )
}
