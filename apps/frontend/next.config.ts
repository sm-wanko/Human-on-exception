import type { NextConfig } from 'next'

const backendInternalUrl =
  process.env.BACKEND_INTERNAL_URL ?? 'http://127.0.0.1:8080'

const nextConfig: NextConfig = {
  output: 'standalone',
  trailingSlash: true,
  allowedDevOrigins: ['localhost', '127.0.0.1'],
  async rewrites() {
    return [
      {
        source: '/api/:path*',
        destination: `${backendInternalUrl}/api/:path*`,
      },
    ]
  },
  webpack: (config) => {
    config.watchOptions = {
      poll: 1000,
      aggregateTimeout: 300,
      ignored: ['**/node_modules', '**/.git', '**/.next'],
    }
    return config
  },
}

export default nextConfig
