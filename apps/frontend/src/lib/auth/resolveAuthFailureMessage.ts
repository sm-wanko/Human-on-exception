/** ログイン失敗の表示。原因を区別しない */
export function resolveAuthFailureMessage(): string {
  return 'メールアドレスまたはパスワードが違います'
}

/** 登録失敗の表示 */
export function resolveRegisterFailureMessage(status: number): string {
  if (status === 422) return '同じメールアドレスでは登録できません'
  return '登録できません'
}
