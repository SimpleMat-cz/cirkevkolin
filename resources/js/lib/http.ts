function readCookie(name: string): string | null {
    const match = document.cookie.match(new RegExp(`(?:^|; )${name}=([^;]*)`));

    return match ? decodeURIComponent(match[1]) : null;
}

/** GET a same-origin Laravel JSON endpoint. */
export async function getJson<T>(url: string): Promise<T> {
    const response = await fetch(url, {
        credentials: 'same-origin',
        headers: {
            Accept: 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    });

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }

    return response.json() as Promise<T>;
}

/**
 * POST to a same-origin Laravel JSON endpoint with the CSRF token Laravel sets
 * in the XSRF-TOKEN cookie. Used for the broadcaster's server-side credential
 * endpoints (Soniox key, Supabase realtime token).
 */
export async function postJson<T>(url: string): Promise<T> {
    const response = await fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            Accept: 'application/json',
            'X-XSRF-TOKEN': readCookie('XSRF-TOKEN') ?? '',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: '{}',
    });

    if (!response.ok) {
        throw new Error(`HTTP ${response.status}`);
    }

    return response.json() as Promise<T>;
}
