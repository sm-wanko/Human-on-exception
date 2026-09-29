/** API request を実行し JSON を返す。204 は本文なし。 */
export async function request<T>(
  url: string,
  options?: RequestInit,
): Promise<T> {
  const response = await fetch(url, {
    ...options,
    credentials: 'same-origin',
    headers: {
      Accept: 'application/json',
      ...(options?.body === undefined
        ? {}
        : { 'Content-Type': 'application/json' }),
      ...options?.headers,
    },
  })
  if (response.status === 204) {
    return undefined as T
  }
  if (!response.ok) {
    throw new Error(`HTTP ${response.status}`)
  }
  return response.json() as Promise<T>
}
