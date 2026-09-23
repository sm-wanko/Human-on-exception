import type { TaskQuick } from '../../../api/task'

type Props = {
  tasks: TaskQuick[]
  onOpen: (id: number) => void
}

/** Task 一覧を描画する */
export function TaskList({ tasks, onOpen }: Props) {
  return (
    <ul>
      {tasks.map((task) => (
        <li key={task.id}>
          <button type="button" onClick={() => onOpen(task.id)}>
            {task.title}
          </button>
        </li>
      ))}
    </ul>
  )
}
