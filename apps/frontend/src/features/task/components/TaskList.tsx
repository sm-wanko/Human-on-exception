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
    <ul className="task-list">
      {tasks.map((task) => (
        <li className="task-list__item" key={task.id}>
          <input
            type="checkbox"
            aria-label={`${task.title} を一覧から外す`}
            onChange={() => onHide(task.id)}
          />
          <button className="task-list__open" type="button" onClick={() => onOpen(task.id)}>
            {task.title}
          </button>
          <div className="task-list__meta">
            <span className="badge">{resolveTaskStatusLabel(task.status)}</span>
            <span className="badge">{task.due_on ?? '終了予定なし'}</span>
          </div>
        </li>
      ))}
    </ul>
  )
}
