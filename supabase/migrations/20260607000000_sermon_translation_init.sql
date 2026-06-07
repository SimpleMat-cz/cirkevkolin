-- Live sermon translation module (Církev Kolín)
-- Target Supabase project: jako-doma (ref: ybesajwrpxgbiiyshynz)
--
-- Additive only: new tables sermon_*, helper function is_broadcaster(),
-- RLS policies on the new tables and on realtime.messages scoped to 'sermon:*'
-- topics so existing realtime usage in the project is left untouched.

-- 1. Tables -----------------------------------------------------------------

create table if not exists public.sermon_sessions (
  id uuid primary key default gen_random_uuid(),
  title text not null,
  status text not null default 'idle' check (status in ('idle', 'live', 'ended')),
  started_at timestamptz,
  ended_at timestamptz,
  created_by uuid references auth.users(id),
  created_at timestamptz not null default now()
);

create table if not exists public.sermon_transcripts (
  id bigint generated always as identity primary key,
  session_id uuid not null references public.sermon_sessions(id) on delete cascade,
  language text not null,
  content text not null,
  seq int not null,
  created_at timestamptz not null default now()
);

create index if not exists sermon_transcripts_session_idx
  on public.sermon_transcripts (session_id, language, seq);

-- Maps Supabase Auth users allowed to broadcast (the AV technician).
create table if not exists public.sermon_broadcasters (
  user_id uuid primary key references auth.users(id) on delete cascade,
  created_at timestamptz not null default now()
);

-- 2. Authorization helper ---------------------------------------------------

create or replace function public.is_broadcaster()
returns boolean
language sql
stable
security definer
set search_path = public
as $$
  select exists (
    select 1 from public.sermon_broadcasters b where b.user_id = auth.uid()
  );
$$;

-- 3. RLS on the new tables --------------------------------------------------

alter table public.sermon_sessions enable row level security;
alter table public.sermon_transcripts enable row level security;
alter table public.sermon_broadcasters enable row level security;

-- sermon_sessions: viewers may read only live/ended sessions; broadcasters manage.
create policy "sermon_sessions public read live/ended"
  on public.sermon_sessions for select
  to anon, authenticated
  using (status in ('live', 'ended'));

create policy "sermon_sessions broadcaster insert"
  on public.sermon_sessions for insert
  to authenticated
  with check (public.is_broadcaster());

create policy "sermon_sessions broadcaster update"
  on public.sermon_sessions for update
  to authenticated
  using (public.is_broadcaster())
  with check (public.is_broadcaster());

-- sermon_transcripts: public archive read; broadcaster writes.
create policy "sermon_transcripts public read"
  on public.sermon_transcripts for select
  to anon, authenticated
  using (true);

create policy "sermon_transcripts broadcaster insert"
  on public.sermon_transcripts for insert
  to authenticated
  with check (public.is_broadcaster());

-- sermon_broadcasters: a user may see their own membership row.
create policy "sermon_broadcasters read own"
  on public.sermon_broadcasters for select
  to authenticated
  using (user_id = auth.uid());

-- 4. Realtime Broadcast authorization (private channel sermon:{id}) ---------
-- Scoped strictly to 'sermon:*' topics so existing realtime usage is untouched.

create policy "sermon realtime read"
  on realtime.messages for select
  to anon, authenticated
  using (realtime.topic() like 'sermon:%');

create policy "sermon realtime broadcaster write"
  on realtime.messages for insert
  to authenticated
  with check (realtime.topic() like 'sermon:%' and public.is_broadcaster());
