export type TaskQuick = {
  id: number;
  title: string;
};

export type TaskDetail = TaskQuick & {
  description: string | null;
  created_at: string;
  updated_at: string | null;
};
