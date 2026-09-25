'use client'

import { useRouter } from 'next/navigation'
import { registerAccount } from '../../api/auth'
import { RegisterPagePresentation } from '../../features/auth/pages/RegisterPagePresentation'
import { resolveRegisterFailureMessage } from '../../lib/auth/resolveAuthFailureMessage'

/** 本人登録 route */
export default function RegisterPage() {
  const router = useRouter()

  return (
    <RegisterPagePresentation
      onSubmit={async (input) => {
        try {
          await registerAccount(input)
        } catch (error) {
          const status =
            error instanceof Error && error.message === 'HTTP 422' ? 422 : 500
          throw new Error(resolveRegisterFailureMessage(status))
        }
        router.push('/tasks/')
      }}
    />
  )
}
