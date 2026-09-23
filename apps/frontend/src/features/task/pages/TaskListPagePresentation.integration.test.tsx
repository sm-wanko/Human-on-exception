import { fireEvent, render, screen } from '@testing-library/react'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { useTaskList } from '../../../hooks/task/useTaskList'
import { TaskListPagePresentation } from './TaskListPagePresentation'

vi.mock('../../../hooks/task/useTaskList', () => ({
  useTaskList: vi.fn(),
}))

const mockedUseTaskList = vi.mocked(useTaskList)

describe('TaskListPagePresentation', () => {
  beforeEach(() => mockedUseTaskList.mockReset())

  it('TASK_CRUD-FE-004 representative: selected id is delegated', () => {
    const onOpenTask = vi.fn()
    mockedUseTaskList.mockReturnValue({
      state: {
        kind: 'ready',
        tasks: [{ id: 42, title: 'Buy milk' }],
      },
    })

    render(<TaskListPagePresentation onOpenTask={onOpenTask} />)
    fireEvent.click(screen.getByRole('button', { name: 'Buy milk' }))

    expect(onOpenTask).toHaveBeenCalledWith(42)
  })
})
