import { dirname } from 'node:path'
import { fileURLToPath } from 'node:url'

import { FlatCompat } from '@eslint/eslintrc'
import type { Linter } from 'eslint'

const __dirname = dirname(fileURLToPath(import.meta.url))
const compat = new FlatCompat({ baseDirectory: __dirname })

const eslintConfig = [
  ...(compat.extends(
    'next/core-web-vitals',
    'next/typescript',
  ) as Linter.Config[]),
  {
    rules: {
      'no-console': 'error',
      '@typescript-eslint/consistent-type-imports': 'warn',
    },
  },
  {
    files: ['src/app/**/page.tsx'],
    rules: {
      'import/no-default-export': 'off',
    },
  },
] satisfies Linter.Config[]

export default eslintConfig
