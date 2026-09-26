import { describe, expect, it } from 'vitest'
import { resolveTaskListState } from './resolveTaskListState'
import { resolveTaskOpenPath } from './resolveTaskOpenPath'

describe('EXAMPLE_EXAMPLE_TASK_CRUD frontend flow contract', () => {
  it('EXAMPLE_EXAMPLE_TASK_CRUD-FE-001: loading', () => {
    expect(resolveTaskListState({ tasks: [], loading: true, error: null })).toEqual({
      kind: 'loading',
    })
  })

  it('EXAMPLE_EXAMPLE_TASK_CRUD-FE-002: empty', () => {
    expect(resolveTaskListState({ tasks: [], loading: false, error: null })).toEqual({
      kind: 'empty',
    })
  })

  it('EXAMPLE_EXAMPLE_TASK_CRUD-FE-003: error', () => {
    expect(
      resolveTaskListState({
        tasks: [],
        loading: false,
        error: 'failed',
      }),
    ).toEqual({ kind: 'error', message: 'failed' })
  })

  it('EXAMPLE_EXAMPLE_TASK_CRUD-FE-004: detail path', () => {
    expect(resolveTaskOpenPath(42)).toBe('/tasks/42/')
  })
})
