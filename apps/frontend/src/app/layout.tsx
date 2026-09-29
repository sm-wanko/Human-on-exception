import type { ReactNode } from 'react'
import { AccountBar } from '../features/auth/AccountBar'
import './globals.css'

type Props = {
  children: ReactNode
}

/** Application root layout */
export default function RootLayout({ children }: Props) {
  return (
    <html lang="ja">
      <body>
        <AccountBar />
        <div className="app-shell">
          <main className="app-main">{children}</main>
        </div>
      </body>
    </html>
  )
}
