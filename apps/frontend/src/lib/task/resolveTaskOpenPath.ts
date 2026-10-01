/** Task 一覧から詳細へ遷移する path を返す */
export function resolveTaskOpenPath(id: number): string {
  return `/tasks/${id}/`
}
