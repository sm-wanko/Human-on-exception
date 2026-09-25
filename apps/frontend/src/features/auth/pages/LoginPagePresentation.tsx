'use client'

import { useState } from 'react'
import type { FormEvent } from 'react'
import { resolveAuthFailureMessage } from '../../../lib/auth/resolveAuthFailureMessage'

type Props = {
  onSubmit: (input: { email: string; password: string }) => Promise<void>
}

/** メールアドレスとパスワードのログイン */
export function LoginPagePresentation({ onSubmit }: Props) {
  const [error, setError] = useState<string | null>(null)

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault()
    const form = new FormData(event.currentTarget)
    setError(null)
    try {
      await onSubmit({
        email: String(form.get('email') ?? ''),
        password: String(form.get('password') ?? ''),
      })
    } catch {
      setError(resolveAuthFailureMessage())
    }
  }

  return (
    <form onSubmit={(event) => void handleSubmit(event)}>
      <label>
        メールアドレス
        <input name="email" type="email" required />
      </label>
      <label>
        パスワード
        <input name="password" type="password" required />
      </label>
      {error !== null ? <p role="alert">{error}</p> : null}
      <button type="submit">ログイン</button>
    </form>
  )
}
