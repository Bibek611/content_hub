import './bootstrap';
// Content Hub - Client Side JavaScript
// Processes REST API JSON data and form input
// Includes sanitization and validation

const API_BASE = '/api';

function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

// Simple sanitization
function sanitize(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Fetch latest posts from API
async function fetchLatestPosts() {
    try {
        const response = await fetch(`${API_BASE}/posts`, {
            headers: { 'Accept': 'application/json' }
        });
        if (!response.ok) throw new Error('Failed to fetch posts');
        return await response.json();
    } catch (error) {
        console.error(error);
        return null;
    }
}

// Create post using API (XHR style)
async function createPostViaApi(form) {
    const formData = new FormData(form);

    const title = formData.get('title')?.trim();
    const body  = formData.get('body')?.trim();

    // Client-side validation
    if (!title || title.length < 3) {
        alert('Title must be at least 3 characters');
        return;
    }
    if (!body || body.length < 10) {
        alert('Content must be at least 10 characters');
        return;
    }

    // Sanitize data
    formData.set('title', sanitize(title));
    formData.set('body', sanitize(body));

    try {
        const response = await fetch(`${API_BASE}/posts`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Accept': 'application/json',
            },
            body: formData,
            credentials: 'same-origin'
        });

        const data = await response.json();

        if (!response.ok) {
            alert(data.message || 'Something went wrong');
            return;
        }

        alert(data.message);
        location.reload();
    } catch (error) {
        alert('Network error. Please try again.');
    }
}

// Attach to form when page loads
document.addEventListener('DOMContentLoaded', () => {
    const apiForm = document.getElementById('api-create-post-form');
    if (apiForm) {
        apiForm.addEventListener('submit', function (e) {
            e.preventDefault();
            createPostViaApi(this);
        });
    }
});
