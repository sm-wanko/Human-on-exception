import { describe, expect, it } from 'vitest'
import { buildTaskWriteBody } from '../../api/task'
import {
  excludeTask,
  formatRegistrationDate,
  resolveTaskStatusLabel,
} from './resolveTaskStatusLabel'
import { resolveTaskListState } from './resolveTaskListState'
import { resolveTaskOpenPath } from './resolveTaskOpenPath'

describe('TASK_CRUD frontend flow contract', () => {
  it('TASK_CRUD-FE-001: loading', () => {
    expect(
      resolveTaskListState({ tasks: [], loading: true, error: null }),
    ).toEqual({
      kind: 'loading',
    })
  })

  it('TASK_CRUD-FE-002: empty', () => {
    expect(
      resolveTaskListState({ tasks: [], loading: false, error: null }),
    ).toEqual({
      kind: 'empty',
    })
  })

  it('TASK_CRUD-FE-003: error', () => {
    expect(
      resolveTaskListState({
        tasks: [],
        loading: false,
        error: 'failed',
      }),
    ).toEqual({ kind: 'error', message: 'failed' })
  })

  it('TASK_CRUD-FE-004: detail path', () => {
    expect(resolveTaskOpenPath(42)).toBe('/tasks/42/')
  })

  it('TASK_CRUD-FE-005: create payload keeps title and optional detail', () => {
    expect(
      buildTaskWriteBody({
        title: '牛乳を買う',
        description: '',
        status: 'not_started',
        dueOn: '',
      }),
    ).toEqual({
      title: '牛乳を買う',
      description: null,
      status: 'not_started',
      due_on: null,
    })
  })

  it('TASK_CRUD-FE-006: edit sends status and due date', () => {
    expect(resolveTaskStatusLabel('done')).toBe('完了')
    expect(
      buildTaskWriteBody({
        title: '牛乳を買う',
        description: '低脂肪',
        status: 'done',
        dueOn: '2026-09-30',
      }).status,
    ).toBe('done')
    expect(formatRegistrationDate('2026-09-25T00:30:00Z')).toBe('2026-09-25')
  })

  it('TASK_CRUD-FE-007: checked task leaves the list', () => {
    expect(excludeTask([{ id: 1 }, { id: 2 }], 1)).toEqual([{ id: 2 }])
  })
})
