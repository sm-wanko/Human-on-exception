'use client'

import Link from 'next/link'
import { useAccountSession } from '../../hooks/auth/useAccountSession'

/** ログイン中の表示名、または登録とログインへの入口 */
export function AccountBar() {
  const { label, logout } = useAccountSession()

  if (label.kind === 'loading') return <p>Loading…</p>
  if (label.kind === 'error') return <p role="alert">{label.message}</p>
  if (label.kind === 'anonymous') {
    return (
      <p>
        <Link href="/login/">ログイン</Link>
        <Link href="/register/">登録</Link>
      </p>
    )
  }

  return (
    <p>
      <span>{label.displayName}</span>
      <button type="button" onClick={() => void logout()}>
        ログアウト
      </button>
    </p>
  )
}
