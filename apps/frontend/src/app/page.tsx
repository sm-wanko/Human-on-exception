import Link from 'next/link'

/** Sample application home */
export default function HomePage() {
  return (
    <section className="hero">
      <h1>Human-on-Exception</h1>
      <p>Laravel + TypeScript Task CRUD sample.</p>
      <div className="hero__actions">
        <Link className="button-link" href="/login/">ログイン</Link>
        <Link href="/register/">登録</Link>
        <Link href="/tasks/">Open tasks</Link>
      </div>
    </section>
  )
}
