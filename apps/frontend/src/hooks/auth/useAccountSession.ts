'use client'

import { useCallback, useEffect, useMemo, useState } from 'react'
import { getAccountSession, logoutAccount } from '../../api/auth'
import {
  resolveAccountLabel,
  type AccountLabel,
} from '../../lib/auth/resolveAccountLabel'

/** ログイン中の表示名とログアウト */
export function useAccountSession(): {
  label: AccountLabel
  logout: () => Promise<void>
} {
  const [displayName, setDisplayName] = useState<string | null>(null)
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    void getAccountSession()
      .then((session) => setDisplayName(session?.display_name ?? null))
      .catch((value: unknown) => {
        setError(value instanceof Error ? value.message : 'unknown error')
      })
      .finally(() => setLoading(false))
  }, [])

  const logout = useCallback(async () => {
    await logoutAccount()
    setDisplayName(null)
  }, [])

  const label = useMemo(
    () => resolveAccountLabel({ loading, displayName, error }),
    [loading, displayName, error],
  )

  return { label, logout }
}
