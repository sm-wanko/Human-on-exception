import { useEffect, useState } from "react";
import { getTask } from "../api/taskApi";
import type { TaskDetail } from "../types/task";

type Props = {
  taskId: number;
};

export function TaskDetailPage({ taskId }: Props) {
  const [task, setTask] = useState<TaskDetail | null>(null);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    void getTask(taskId)
      .then(setTask)
      .catch((value: unknown) => {
        setError(value instanceof Error ? value.message : "unknown error");
      });
  }, [taskId]);

  if (error) return <p role="alert">{error}</p>;
  if (task === null) return <p>Loading…</p>;

  return (
    <article>
      <h1>{task.title}</h1>
      <p>{task.description ?? "No description."}</p>
    </article>
  );
}
