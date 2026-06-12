-- Jazyky vysílané v rámci session — divák si z nich vybírá v prohlížeči.
-- Additivní změna s defaultem, starší klienti fungují beze změny.

alter table public.sermon_sessions
  add column if not exists languages text[] not null default '{cs,en}';
