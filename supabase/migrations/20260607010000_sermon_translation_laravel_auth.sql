-- Switch broadcaster authorization from dedicated Supabase Auth accounts to a
-- JWT claim minted by the church's Laravel backend, so a single login (the
-- website login + role) controls /preklad/admin. The minted token carries
-- `role: authenticated` and `broadcaster: true`; writes are authorized by the
-- claim instead of a Supabase user row.

drop policy if exists "sermon_sessions broadcaster insert" on public.sermon_sessions;
drop policy if exists "sermon_sessions broadcaster update" on public.sermon_sessions;
drop policy if exists "sermon_transcripts broadcaster insert" on public.sermon_transcripts;
drop policy if exists "sermon realtime broadcaster write" on realtime.messages;
drop policy if exists "sermon_broadcasters read own" on public.sermon_broadcasters;

drop function if exists public.is_broadcaster();
drop table if exists public.sermon_broadcasters;

create or replace function public.jwt_is_broadcaster()
returns boolean
language sql
stable
set search_path = public
as $$
  select coalesce((auth.jwt() ->> 'broadcaster')::boolean, false);
$$;

create policy "sermon_sessions broadcaster insert"
  on public.sermon_sessions for insert
  to authenticated
  with check (public.jwt_is_broadcaster());

create policy "sermon_sessions broadcaster update"
  on public.sermon_sessions for update
  to authenticated
  using (public.jwt_is_broadcaster())
  with check (public.jwt_is_broadcaster());

create policy "sermon_transcripts broadcaster insert"
  on public.sermon_transcripts for insert
  to authenticated
  with check (public.jwt_is_broadcaster());

create policy "sermon realtime broadcaster write"
  on realtime.messages for insert
  to authenticated
  with check (realtime.topic() like 'sermon:%' and public.jwt_is_broadcaster());
