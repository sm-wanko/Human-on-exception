import { TaskList } from "../presentation/TaskList";
import { useTasks } from "../hooks/useTasks";

type Props = {
  onOpenTask: (id: number) => void;
};

export function TaskListPage({ onOpenTask }: Props) {
  const { tasks, loading, error } = useTasks();

  if (loading) return <p>Loading…</p>;
  if (error) return <p role="alert">{error}</p>;

  return <TaskList tasks={tasks} onOpen={onOpenTask} />;
}
