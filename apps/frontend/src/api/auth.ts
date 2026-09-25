import { request } from './apiClient'

/** ログイン中の表示名 */
export type AccountSession = {
  display_name: string
}

/** 本人登録の入力 */
export type RegisterInput = {
  email: string
  password: string
  displayName: string
}

/** ログインの入力 */
export type LoginInput = {
  email: string
  password: string
}

/** アカウントを作成してログインする */
export function registerAccount(input: RegisterInput): Promise<AccountSession> {
  return request<AccountSession>('/api/auth/register/', {
    method: 'POST',
    body: JSON.stringify({
      email: input.email,
      password: input.password,
      display_name: input.displayName,
    }),
  })
}

/** メールアドレスとパスワードでログインする */
export function loginAccount(input: LoginInput): Promise<AccountSession> {
  return request<AccountSession>('/api/auth/login/', {
    method: 'POST',
    body: JSON.stringify(input),
  })
}

/** ログアウトする */
export function logoutAccount(): Promise<void> {
  return request<void>('/api/auth/logout/', { method: 'POST' })
}

/** ログイン中の表示名を取得する。未ログインは null */
export async function getAccountSession(): Promise<AccountSession | null> {
  try {
    return await request<AccountSession>('/api/auth/session/')
  } catch (error) {
    if (error instanceof Error && error.message === 'HTTP 401') {
      return null
    }
    throw error
  }
}
