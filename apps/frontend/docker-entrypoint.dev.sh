#!/bin/sh
set -e

cd /app

# build 時の node_modules を匿名 volume 側へ同期する。
pnpm install --no-frozen-lockfile

if [ "$#" -gt 0 ]; then
  exec "$@"
fi

exec pnpm dev
