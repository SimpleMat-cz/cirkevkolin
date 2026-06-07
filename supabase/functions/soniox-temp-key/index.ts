// Edge Function: soniox-temp-key
//
// Mints a short-lived Soniox temporary API key for an authenticated broadcaster.
// The main SONIOX_API_KEY lives only in Supabase secrets and never reaches the
// browser. Authorization: a valid Supabase JWT whose user is listed in
// public.sermon_broadcasters (checked via public.is_broadcaster()).
//
// Docs: https://soniox.com/docs/stt/api-reference/auth/create_temporary_api_key
//
// Deploy with verify_jwt = true so Supabase rejects requests without a JWT
// before this code even runs; we additionally enforce the broadcaster role.

import 'jsr:@supabase/functions-js/edge-runtime.d.ts'
import { createClient } from 'jsr:@supabase/supabase-js@2'

const SONIOX_TEMP_KEY_URL = 'https://api.soniox.com/v1/auth/temporary-api-key'

const corsHeaders = {
  'Access-Control-Allow-Origin': '*',
  'Access-Control-Allow-Headers': 'authorization, x-client-info, apikey, content-type',
  'Access-Control-Allow-Methods': 'POST, OPTIONS',
}

function json(body: unknown, status = 200): Response {
  return new Response(JSON.stringify(body), {
    status,
    headers: { ...corsHeaders, 'Content-Type': 'application/json' },
  })
}

Deno.serve(async (req: Request) => {
  if (req.method === 'OPTIONS') {
    return new Response('ok', { headers: corsHeaders })
  }
  if (req.method !== 'POST') {
    return json({ error: 'method_not_allowed' }, 405)
  }

  const authHeader = req.headers.get('Authorization') ?? ''
  if (!authHeader.startsWith('Bearer ')) {
    return json({ error: 'unauthorized' }, 401)
  }

  const supabaseUrl = Deno.env.get('SUPABASE_URL')
  const anonKey = Deno.env.get('SUPABASE_ANON_KEY')
  const sonioxApiKey = Deno.env.get('SONIOX_API_KEY')
  if (!supabaseUrl || !anonKey || !sonioxApiKey) {
    return json({ error: 'server_misconfigured' }, 500)
  }

  // Resolve the caller and verify the broadcaster role against the database.
  const supabase = createClient(supabaseUrl, anonKey, {
    global: { headers: { Authorization: authHeader } },
  })

  const { data: userData, error: userError } = await supabase.auth.getUser()
  if (userError || !userData.user) {
    return json({ error: 'unauthorized' }, 401)
  }

  const { data: isBroadcaster, error: roleError } = await supabase.rpc('is_broadcaster')
  if (roleError || isBroadcaster !== true) {
    return json({ error: 'forbidden' }, 403)
  }

  // Request the temporary key from Soniox.
  const expiresInSeconds = 300
  const sonioxResponse = await fetch(SONIOX_TEMP_KEY_URL, {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${sonioxApiKey}`,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({
      usage_type: 'transcribe_websocket',
      expires_in_seconds: expiresInSeconds,
    }),
  })

  if (!sonioxResponse.ok) {
    const detail = await sonioxResponse.text()
    return json({ error: 'soniox_error', status: sonioxResponse.status, detail }, 502)
  }

  const payload = await sonioxResponse.json()
  return json({ api_key: payload.api_key, expires_at: payload.expires_at })
})
