import { describe, expect, it } from 'vitest'
import { resolveTaskListState } from './resolveTaskListState'
import { resolveTaskOpenPath } from './resolveTaskOpenPath'

describe('TASK_CRUD frontend flow contract', () => {
  it('TASK_CRUD-FE-001: loading', () => {
    expect(resolveTaskListState({ tasks: [], loading: true, error: null })).toEqual({
      kind: 'loading',
    })
  })

  it('TASK_CRUD-FE-002: empty', () => {
    expect(resolveTaskListState({ tasks: [], loading: false, error: null })).toEqual({
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
})
