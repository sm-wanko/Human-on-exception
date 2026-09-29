/** ログイン中の表示 */
export type AccountLabel =
  | { kind: 'loading' }
  | { kind: 'anonymous' }
  | { kind: 'named'; displayName: string }
  | { kind: 'error'; message: string }

/** 表示名を出すかどうかを決める */
export function resolveAccountLabel(input: {
  loading: boolean
  displayName: string | null
  error: string | null
}): AccountLabel {
  if (input.loading) return { kind: 'loading' }
  if (input.error !== null) return { kind: 'error', message: input.error }
  if (input.displayName === null || input.displayName === '')
    return { kind: 'anonymous' }
  return { kind: 'named', displayName: input.displayName }
}
