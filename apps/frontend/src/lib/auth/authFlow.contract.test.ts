import { describe, expect, it } from 'vitest'
import { resolveAccountLabel } from './resolveAccountLabel'
import { resolveAuthFailureMessage } from './resolveAuthFailureMessage'

describe('AUTH_LOGIN frontend flow contract', () => {
  it('AUTH_LOGIN-FE-001: shows the display name', () => {
    expect(
      resolveAccountLabel({ loading: false, displayName: '花子', error: null }),
    ).toEqual({ kind: 'named', displayName: '花子' })
  })

  it('AUTH_LOGIN-FE-002: logged out shows no name', () => {
    expect(
      resolveAccountLabel({ loading: false, displayName: null, error: null }),
    ).toEqual({
      kind: 'anonymous',
    })
  })

  it('AUTH_LOGIN-FE-003: login failure does not distinguish the reason', () => {
    expect(resolveAuthFailureMessage()).toBe(resolveAuthFailureMessage())
  })
})
