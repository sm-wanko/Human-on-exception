import type { ReactNode } from 'react'

type Props = {
  children: ReactNode
}

/** Application root layout */
export default function RootLayout({ children }: Props) {
  return (
    <html lang="ja">
      <body>{children}</body>
    </html>
  )
}
