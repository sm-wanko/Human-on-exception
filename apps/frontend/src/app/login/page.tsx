'use client'

import { useRouter } from 'next/navigation'
import { loginAccount } from '../../api/auth'
import { LoginPagePresentation } from '../../features/auth/pages/LoginPagePresentation'

/** ログイン route */
export default function LoginPage() {
  const router = useRouter()

  return (
    <LoginPagePresentation
      onSubmit={async (input) => {
        await loginAccount(input)
        router.push('/tasks/')
      }}
    />
  )
}
