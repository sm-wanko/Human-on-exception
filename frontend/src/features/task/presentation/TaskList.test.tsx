import { fireEvent, render, screen } from '@testing-library/react'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { TaskListPage } from '../pages/TaskListPage'
import { useTasks } from '../hooks/useTasks'

vi.mock('../hooks/useTasks', () => ({
  useTasks: vi.fn(),
}))

const mockedUseTasks = vi.mocked(useTasks)

describe('Task list flow contract', () => {
  beforeEach(() => {
    mockedUseTasks.mockReset()
  })

  it('TASK_CRUD-FE-001: shows loading state while list is pending', () => {
    mockedUseTasks.mockReturnValue({
      tasks: [],
      loading: true,
      error: null,
    })

    render(<TaskListPage onOpenTask={vi.fn()} />)

    expect(screen.getByText('Loading…')).toBeTruthy()
  })

  it('TASK_CRUD-FE-002: shows explicit empty state', () => {
    mockedUseTasks.mockReturnValue({
      tasks: [],
      loading: false,
      error: null,
    })

    render(<TaskListPage onOpenTask={vi.fn()} />)

    expect(screen.getByText('No tasks yet.')).toBeTruthy()
  })

  it('TASK_CRUD-FE-003: shows request failure as an alert', () => {
    mockedUseTasks.mockReturnValue({
      tasks: [],
      loading: false,
      error: 'failed to load tasks',
    })

    render(<TaskListPage onOpenTask={vi.fn()} />)

    expect(screen.getByRole('alert').textContent).toBe('failed to load tasks')
  })

  it('TASK_CRUD-FE-004: delegates selected TaskQuick id to navigation', () => {
    const onOpenTask = vi.fn()
    mockedUseTasks.mockReturnValue({
      tasks: [{ id: 42, title: 'Buy milk' }],
      loading: false,
      error: null,
    })

    render(<TaskListPage onOpenTask={onOpenTask} />)
    fireEvent.click(screen.getByRole('button', { name: 'Buy milk' }))

    expect(onOpenTask).toHaveBeenCalledOnce()
    expect(onOpenTask).toHaveBeenCalledWith(42)
  })
})
