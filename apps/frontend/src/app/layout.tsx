import type { ReactNode } from 'react'
import { AccountBar } from '../features/auth/AccountBar'

type Props = {
  children: ReactNode
}

/** Application root layout */
export default function RootLayout({ children }: Props) {
  return (
    <html lang="ja">
      <body>
        <AccountBar />
        {children}
      </body>
    </html>
  )
}
