-- Spolehlivý lifecycle živého překladu.
--
-- last_seen_at: vysílací konzole každých ~15 s potvrzuje „žiju". Divácká
-- stránka pak za živé považuje jen session s čerstvým heartbeatem — když
-- broadcaster zavře panel (a tím se zastaví i Soniox účtování), session do
-- ~30 s zmizí i bez explicitního ukončení.
--
-- audio_seconds: kolik „stream-sekund" audia se nasbíralo (součet přes všechny
-- běžící jazykové sessions) — podklad pro odhad spotřeby/ceny v adminu.

alter table public.sermon_sessions
  add column if not exists last_seen_at timestamptz,
  add column if not exists audio_seconds integer not null default 0;
