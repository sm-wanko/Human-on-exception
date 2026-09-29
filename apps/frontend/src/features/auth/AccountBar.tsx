'use client'

import Link from 'next/link'
import { useAccountSession } from '../../hooks/auth/useAccountSession'

/** ログイン中の表示名、または登録とログインへの入口 */
export function AccountBar() {
  const { label, logout } = useAccountSession()

  return (
    <header className="account-bar">
      <div className="account-bar__inner">
        <Link className="account-bar__brand" href="/">Human-on-Exception</Link>
        {label.kind === 'loading' ? <p className="account-bar__actions">Loading…</p> : null}
        {label.kind === 'error' ? <p className="account-bar__actions" role="alert">{label.message}</p> : null}
        {label.kind === 'anonymous' ? (
          <p className="account-bar__actions">
            <Link href="/register/">Register</Link>
            <Link href="/login/">Login</Link>
          </p>
        ) : null}
        {label.kind === 'authenticated' ? (
          <p className="account-bar__actions">
            <span>Hello, {label.displayName}</span>
            <button type="button" onClick={() => void logout()}>
              ログアウト
            </button>
          </p>
        ) : null}
      </div>
    </header>
  )
}
