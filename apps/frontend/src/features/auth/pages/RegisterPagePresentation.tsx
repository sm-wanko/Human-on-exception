'use client'

import { useState } from 'react'
import type { FormEvent } from 'react'

type Props = {
  onSubmit: (input: {
    email: string
    password: string
    displayName: string
  }) => Promise<void>
}

/** 表示名つきの本人登録 */
export function RegisterPagePresentation({ onSubmit }: Props) {
  const [error, setError] = useState<string | null>(null)

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault()
    const form = new FormData(event.currentTarget)
    setError(null)
    try {
      await onSubmit({
        email: String(form.get('email') ?? ''),
        password: String(form.get('password') ?? ''),
        displayName: String(form.get('display_name') ?? ''),
      })
    } catch (value) {
      setError(value instanceof Error ? value.message : '登録できません')
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
        <input name="password" type="password" required minLength={8} />
      </label>
      <label>
        表示名
        <input name="display_name" required maxLength={80} />
      </label>
      {error !== null ? <p role="alert">{error}</p> : null}
      <button type="submit">登録</button>
    </form>
  )
}
