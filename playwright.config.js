import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './e2e-tests', // Must match your actual folder name!
  timeout: 30000,
  retries: 0,
  use: {
    baseURL: 'http://localhost:8000',
    headless: false,
    screenshot: 'only-on-failure',
    video: 'retain-on-failure',
  },
});