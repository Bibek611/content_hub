import { test, expect } from '@playwright/test';

test('Create, Edit, Delete post', async ({ page }) => {
  // 1. Go to login and authenticate
  await page.goto('/login');
  await page.fill('input[name="email"]', 'admin@gmail.com');
  await page.fill('input[name="password"]', '123');
  
  // Click login and wait for the dashboard page to load
  await Promise.all([
    page.waitForURL('**/dashboard'),
    page.click('button:has-text("Login")')
  ]);

  // 2. Create a new post
  await page.fill('input[name="title"]', 'Playwright Post');
  await page.fill('textarea[name="body"]', 'This is a body');
  await page.setInputFiles('input[name="image"]', 'e2e-tests/fixtures/test-image.jpg');
  await page.click('button:has-text("Create")');

  // 3. Verify creation success
  await expect(page.locator('text=Your post has been created successfully!')).toBeVisible({ timeout: 10000 });

  // 4. Update the post
  await page.click('a:has-text("Update")');
  await page.fill('input[name="title"]', 'Updated Post');
  await page.click('button:has-text("Update")');

  // 5. Verify update success
  await expect(page.locator('text=Your post was updated successfully!')).toBeVisible();

  // 6. Delete the post
  await page.locator('form:has(button:has-text("Delete"))').nth(0).evaluate(form => form.submit());

  // 7. Verify deletion success
  await expect(page.locator('text=Post deleted successfully!')).toBeVisible();
});