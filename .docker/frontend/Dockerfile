ARG NODE_VERSION=22.18.0
ARG ALPINE_VERSION=3.22

FROM node:${NODE_VERSION}-alpine${ALPINE_VERSION} AS base

RUN apk add --no-cache bash curl
WORKDIR /app
RUN npm install -g pnpm@10.13.1

FROM base AS dev
COPY package.json ./
RUN pnpm install --no-frozen-lockfile
COPY . .
COPY docker-entrypoint.dev.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
EXPOSE 3000
ENTRYPOINT ["docker-entrypoint.sh"]

FROM base AS prod-builder
COPY package.json ./
RUN pnpm install --no-frozen-lockfile
COPY . .
RUN pnpm build

FROM node:${NODE_VERSION}-alpine${ALPINE_VERSION} AS prod
WORKDIR /app
ENV NODE_ENV=production
ENV HOSTNAME=0.0.0.0
ENV PORT=3000
COPY --from=prod-builder /app/.next/standalone ./
COPY --from=prod-builder /app/.next/static ./.next/static
EXPOSE 3000
CMD ["node", "server.js"]
