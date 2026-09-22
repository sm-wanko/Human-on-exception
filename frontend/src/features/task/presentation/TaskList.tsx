import type { TaskQuick } from "../types/task";

type Props = {
  tasks: TaskQuick[];
  onOpen: (id: number) => void;
};

export function TaskList({ tasks, onOpen }: Props) {
  if (tasks.length === 0) {
    return <p>No tasks yet.</p>;
  }

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
  );
}
