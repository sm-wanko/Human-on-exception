import type { TaskDetail, TaskQuick } from "../types/task";

export async function listTasks(): Promise<TaskQuick[]> {
  const response = await fetch("/api/tasks");
  if (!response.ok) throw new Error("failed to load tasks");
  return response.json() as Promise<TaskQuick[]>;
}

export async function getTask(id: number): Promise<TaskDetail> {
  const response = await fetch(`/api/tasks/${id}`);
  if (response.status === 404) throw new Error("task not found");
  if (!response.ok) throw new Error("failed to load task");
  return response.json() as Promise<TaskDetail>;
}
