import { useEffect, useState } from "react";
import { listTasks } from "../api/taskApi";
import type { TaskQuick } from "../types/task";

export function useTasks() {
  const [tasks, setTasks] = useState<TaskQuick[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    void listTasks()
      .then(setTasks)
      .catch((value: unknown) => {
        setError(value instanceof Error ? value.message : "unknown error");
      })
      .finally(() => setLoading(false));
  }, []);

  return { tasks, loading, error };
}
