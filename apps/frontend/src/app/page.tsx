import Link from 'next/link'

/** Sample application home */
export default function HomePage() {
  return (
    <main>
      <h1>Human-on-Exception</h1>
      <p>Laravel + TypeScript Task CRUD sample.</p>
      <Link href="/tasks/">Open tasks</Link>
    </main>
  )
}
