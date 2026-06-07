/**
 * Glossary passed to Soniox via the `context` field (max 10 000 chars) to bias
 * recognition toward names and terms common in this congregation. Keep it as a
 * plain editable list so it can grow without a code change of substance.
 *
 * Bible names follow the Bible21 Czech translation.
 */
export const SERMON_GLOSSARY = [
    'Církev Kolín',
    'Apoštolská církev',
    'Kolín',
    'Pardubice',
    'Praha',
    // Biblical names (Bible21)
    'Ježíš',
    'Kristus',
    'Mojžíš',
    'Abraham',
    'Pavel',
    'Petr',
    'Jan',
    'David',
    'Šalomoun',
    'Duch svatý',
    // Bible books (selection, Bible21)
    'Genesis',
    'Exodus',
    'Žalmy',
    'Izaiáš',
    'Matouš',
    'Marek',
    'Lukáš',
    'Skutky',
    'Římanům',
    'Zjevení',
    // Ministries / programs
    'WyldLife',
    'Young Life',
    'KidzTown',
].join(', ');
