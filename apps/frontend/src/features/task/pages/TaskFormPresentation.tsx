'use client'

import { useState } from 'react'
import type { FormEvent } from 'react'
import type { TaskWriteInput } from '../../../api/task'
import {
  formatRegistrationDate,
  TASK_STATUS_OPTIONS,
} from '../../../lib/task/resolveTaskStatusLabel'

type Props = {
  initial: TaskWriteInput
  createdAt: string | null
  onSubmit: (input: TaskWriteInput) => Promise<void>
}

/** Task の登録と編集 */
export function TaskFormPresentation({ initial, createdAt, onSubmit }: Props) {
  const [error, setError] = useState<string | null>(null)

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault()
    const form = new FormData(event.currentTarget)
    setError(null)
    try {
      await onSubmit({
        title: String(form.get('title') ?? ''),
        description: String(form.get('description') ?? ''),
        status: String(form.get('status') ?? 'not_started'),
        dueOn: String(form.get('due_on') ?? ''),
      })
    } catch (value) {
      setError(value instanceof Error ? value.message : '保存できません')
    }
  }

  return (
    <section className="panel">
      <h1>{createdAt === null ? 'Task登録' : 'Task編集'}</h1>
      <form className="form-stack" onSubmit={(event) => void handleSubmit(event)}>
        <label>
          内容
          <input
            name="title"
            required
            maxLength={200}
            defaultValue={initial.title}
          />
        </label>
        <label>
          詳細
          <textarea
            name="description"
            maxLength={2000}
            defaultValue={initial.description}
          />
        </label>
        <label>
          STATUS
          <select name="status" defaultValue={initial.status}>
            {TASK_STATUS_OPTIONS.map((option) => (
              <option key={option.value} value={option.value}>
                {option.label}
              </option>
            ))}
          </select>
        </label>
        <label>
          終了予定日
          <input name="due_on" type="date" defaultValue={initial.dueOn} />
        </label>
        {createdAt !== null ? (
          <p>登録日 {formatRegistrationDate(createdAt)}</p>
        ) : null}
        {error !== null ? <p role="alert">{error}</p> : null}
        <button type="submit">保存</button>
      </form>
    </section>
  )
}
