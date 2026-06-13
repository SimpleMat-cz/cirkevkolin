-- On-demand překlad: divák (anon) musí umět poslat presence, aby konzoli
-- signalizoval, jaký jazyk čte. Dosud směl jen číst (SELECT), takže presence
-- ani počítání diváků nefungovaly.
--
-- Povolujeme INSERT jen pro extension = 'presence' na sermon:* topics — broadcast
-- (titulky) zůstává vyhrazený broadcasterovi, host tedy nemůže podvrhnout přepis.

create policy "sermon realtime presence write"
  on realtime.messages for insert
  to anon, authenticated
  with check (
    realtime.topic() like 'sermon:%'
    and extension = 'presence'
  );
