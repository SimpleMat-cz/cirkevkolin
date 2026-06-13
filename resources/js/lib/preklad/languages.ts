import type { CaptionLang } from './types';

export interface LangOption {
    code: CaptionLang;
    /** Native label shown to the guest. */
    nativeName: string;
    flag: string;
    /** Oblíbené jazyky se hostovi nabízejí jako první (zbytek je v „Další jazyky"). */
    favorite?: boolean;
    /** Soniox target_language pro překlad. Vynecháno u cs (zdroj — jen přepis). */
    targetLanguage?: string;
}

/**
 * Katalog jazyků. Oblíbené (cs, en, uk, pl, sr, de, ru) jsou nahoře; zbytek je
 * kompletní sada, kterou Soniox umí přeložit (60 jazyků, ISO 639-1).
 * cs je zdroj (přepis) — nemá targetLanguage. Ostatní mají targetLanguage = code.
 */
export const LANGUAGES: LangOption[] = [
    { code: 'cs', nativeName: 'Čeština', flag: '🇨🇿', favorite: true },
    {
        code: 'en',
        nativeName: 'English',
        flag: '🇬🇧',
        favorite: true,
        targetLanguage: 'en',
    },
    {
        code: 'uk',
        nativeName: 'Українська',
        flag: '🇺🇦',
        favorite: true,
        targetLanguage: 'uk',
    },
    {
        code: 'pl',
        nativeName: 'Polski',
        flag: '🇵🇱',
        favorite: true,
        targetLanguage: 'pl',
    },
    {
        code: 'sr',
        nativeName: 'Srpski',
        flag: '🇷🇸',
        favorite: true,
        targetLanguage: 'sr',
    },
    {
        code: 'de',
        nativeName: 'Deutsch',
        flag: '🇩🇪',
        favorite: true,
        targetLanguage: 'de',
    },
    {
        code: 'ru',
        nativeName: 'Русский',
        flag: '🇷🇺',
        favorite: true,
        targetLanguage: 'ru',
    },

    { code: 'sk', nativeName: 'Slovenčina', flag: '🇸🇰', targetLanguage: 'sk' },
    { code: 'es', nativeName: 'Español', flag: '🇪🇸', targetLanguage: 'es' },
    { code: 'fr', nativeName: 'Français', flag: '🇫🇷', targetLanguage: 'fr' },
    { code: 'it', nativeName: 'Italiano', flag: '🇮🇹', targetLanguage: 'it' },
    { code: 'pt', nativeName: 'Português', flag: '🇵🇹', targetLanguage: 'pt' },
    { code: 'ro', nativeName: 'Română', flag: '🇷🇴', targetLanguage: 'ro' },
    { code: 'nl', nativeName: 'Nederlands', flag: '🇳🇱', targetLanguage: 'nl' },
    { code: 'hu', nativeName: 'Magyar', flag: '🇭🇺', targetLanguage: 'hu' },
    { code: 'bg', nativeName: 'Български', flag: '🇧🇬', targetLanguage: 'bg' },
    { code: 'hr', nativeName: 'Hrvatski', flag: '🇭🇷', targetLanguage: 'hr' },
    { code: 'bs', nativeName: 'Bosanski', flag: '🇧🇦', targetLanguage: 'bs' },
    { code: 'mk', nativeName: 'Македонски', flag: '🇲🇰', targetLanguage: 'mk' },
    { code: 'sl', nativeName: 'Slovenščina', flag: '🇸🇮', targetLanguage: 'sl' },
    { code: 'be', nativeName: 'Беларуская', flag: '🇧🇾', targetLanguage: 'be' },
    { code: 'el', nativeName: 'Ελληνικά', flag: '🇬🇷', targetLanguage: 'el' },
    { code: 'tr', nativeName: 'Türkçe', flag: '🇹🇷', targetLanguage: 'tr' },
    { code: 'sv', nativeName: 'Svenska', flag: '🇸🇪', targetLanguage: 'sv' },
    { code: 'no', nativeName: 'Norsk', flag: '🇳🇴', targetLanguage: 'no' },
    { code: 'da', nativeName: 'Dansk', flag: '🇩🇰', targetLanguage: 'da' },
    { code: 'fi', nativeName: 'Suomi', flag: '🇫🇮', targetLanguage: 'fi' },
    { code: 'et', nativeName: 'Eesti', flag: '🇪🇪', targetLanguage: 'et' },
    { code: 'lv', nativeName: 'Latviešu', flag: '🇱🇻', targetLanguage: 'lv' },
    { code: 'lt', nativeName: 'Lietuvių', flag: '🇱🇹', targetLanguage: 'lt' },
    { code: 'sq', nativeName: 'Shqip', flag: '🇦🇱', targetLanguage: 'sq' },
    { code: 'ar', nativeName: 'العربية', flag: '🇸🇦', targetLanguage: 'ar' },
    { code: 'he', nativeName: 'עברית', flag: '🇮🇱', targetLanguage: 'he' },
    { code: 'fa', nativeName: 'فارسی', flag: '🇮🇷', targetLanguage: 'fa' },
    { code: 'ur', nativeName: 'اردو', flag: '🇵🇰', targetLanguage: 'ur' },
    { code: 'hi', nativeName: 'हिन्दी', flag: '🇮🇳', targetLanguage: 'hi' },
    { code: 'bn', nativeName: 'বাংলা', flag: '🇧🇩', targetLanguage: 'bn' },
    { code: 'pa', nativeName: 'ਪੰਜਾਬੀ', flag: '🇮🇳', targetLanguage: 'pa' },
    { code: 'gu', nativeName: 'ગુજરાતી', flag: '🇮🇳', targetLanguage: 'gu' },
    { code: 'mr', nativeName: 'मराठी', flag: '🇮🇳', targetLanguage: 'mr' },
    { code: 'ta', nativeName: 'தமிழ்', flag: '🇮🇳', targetLanguage: 'ta' },
    { code: 'te', nativeName: 'తెలుగు', flag: '🇮🇳', targetLanguage: 'te' },
    { code: 'kn', nativeName: 'ಕನ್ನಡ', flag: '🇮🇳', targetLanguage: 'kn' },
    { code: 'ml', nativeName: 'മലയാളം', flag: '🇮🇳', targetLanguage: 'ml' },
    { code: 'zh', nativeName: '中文', flag: '🇨🇳', targetLanguage: 'zh' },
    { code: 'ja', nativeName: '日本語', flag: '🇯🇵', targetLanguage: 'ja' },
    { code: 'ko', nativeName: '한국어', flag: '🇰🇷', targetLanguage: 'ko' },
    { code: 'vi', nativeName: 'Tiếng Việt', flag: '🇻🇳', targetLanguage: 'vi' },
    { code: 'th', nativeName: 'ไทย', flag: '🇹🇭', targetLanguage: 'th' },
    { code: 'id', nativeName: 'Indonesia', flag: '🇮🇩', targetLanguage: 'id' },
    { code: 'ms', nativeName: 'Melayu', flag: '🇲🇾', targetLanguage: 'ms' },
    { code: 'tl', nativeName: 'Tagalog', flag: '🇵🇭', targetLanguage: 'tl' },
    { code: 'sw', nativeName: 'Kiswahili', flag: '🇹🇿', targetLanguage: 'sw' },
    { code: 'kk', nativeName: 'Қазақ', flag: '🇰🇿', targetLanguage: 'kk' },
    { code: 'az', nativeName: 'Azərbaycan', flag: '🇦🇿', targetLanguage: 'az' },
    { code: 'af', nativeName: 'Afrikaans', flag: '🇿🇦', targetLanguage: 'af' },
    { code: 'ca', nativeName: 'Català', flag: '🇪🇸', targetLanguage: 'ca' },
    { code: 'gl', nativeName: 'Galego', flag: '🇪🇸', targetLanguage: 'gl' },
    { code: 'eu', nativeName: 'Euskara', flag: '🇪🇸', targetLanguage: 'eu' },
    { code: 'cy', nativeName: 'Cymraeg', flag: '🏴󠁧󠁢󠁷󠁬󠁳󠁿', targetLanguage: 'cy' },
];

export const FAVORITE_LANGUAGES: LangOption[] = LANGUAGES.filter(
    (l) => l.favorite,
);

export const EXTENDED_LANGUAGES: LangOption[] = LANGUAGES.filter(
    (l) => !l.favorite,
);

/** Cíle vyžadující překladovou Soniox session (vše kromě zdrojové cs). */
export const TRANSLATION_TARGETS: LangOption[] = LANGUAGES.filter(
    (l) => l.targetLanguage,
);

const LANG_BY_CODE = new Map(LANGUAGES.map((l) => [l.code, l]));

export function langOption(code: CaptionLang): LangOption {
    return (
        LANG_BY_CODE.get(code) ?? {
            code,
            nativeName: code.toUpperCase(),
            flag: '🌐',
        }
    );
}

/** Minimal UI dictionary (interface chrome only — not the captions themselves). */
type UiKey =
    | 'chooseLanguage'
    | 'tagline'
    | 'notLive'
    | 'notLiveHint'
    | 'churchSite'
    | 'liveButton'
    | 'connecting'
    | 'fontSize'
    | 'changeLanguage'
    | 'moreLanguages';

type UiDict = Record<UiKey, string>;

const UI_STRINGS_BY_LANG: Record<string, UiDict> = {
    cs: {
        chooseLanguage: 'Vyber si jazyk',
        tagline: 'jako doma',
        notLive: 'Překlad právě neběží.',
        notLiveHint: 'Bohoslužby probíhají v neděli. Připoj se příště.',
        churchSite: 'Web církve',
        liveButton: 'Živě',
        connecting: 'Připojuji…',
        fontSize: 'Velikost písma',
        changeLanguage: 'Změnit jazyk',
        moreLanguages: 'Další jazyky',
    },
    en: {
        chooseLanguage: 'Choose your language',
        tagline: 'feel at home',
        notLive: 'Translation is not running right now.',
        notLiveHint: 'Services are held on Sundays. Join us next time.',
        churchSite: 'Church website',
        liveButton: 'Live',
        connecting: 'Connecting…',
        fontSize: 'Font size',
        changeLanguage: 'Change language',
        moreLanguages: 'More languages',
    },
    de: {
        chooseLanguage: 'Wähle deine Sprache',
        tagline: 'wie zu Hause',
        notLive: 'Die Übersetzung läuft gerade nicht.',
        notLiveHint:
            'Gottesdienste finden sonntags statt. Sei das nächste Mal dabei.',
        churchSite: 'Webseite der Gemeinde',
        liveButton: 'Live',
        connecting: 'Verbinde…',
        fontSize: 'Schriftgröße',
        changeLanguage: 'Sprache ändern',
        moreLanguages: 'Weitere Sprachen',
    },
    ru: {
        chooseLanguage: 'Выберите язык',
        tagline: 'как дома',
        notLive: 'Перевод сейчас не идёт.',
        notLiveHint:
            'Богослужения проходят по воскресеньям. Присоединяйтесь в следующий раз.',
        churchSite: 'Сайт церкви',
        liveButton: 'В эфире',
        connecting: 'Подключение…',
        fontSize: 'Размер шрифта',
        changeLanguage: 'Сменить язык',
        moreLanguages: 'Другие языки',
    },
    uk: {
        chooseLanguage: 'Виберіть мову',
        tagline: 'як удома',
        notLive: 'Переклад зараз не працює.',
        notLiveHint:
            'Богослужіння відбуваються щонеділі. Приєднуйтесь наступного разу.',
        churchSite: 'Сайт церкви',
        liveButton: 'Наживо',
        connecting: 'З’єднання…',
        fontSize: 'Розмір шрифту',
        changeLanguage: 'Змінити мову',
        moreLanguages: 'Інші мови',
    },
    pl: {
        chooseLanguage: 'Wybierz język',
        tagline: 'jak w domu',
        notLive: 'Tłumaczenie nie jest teraz aktywne.',
        notLiveHint:
            'Nabożeństwa odbywają się w niedziele. Dołącz następnym razem.',
        churchSite: 'Strona kościoła',
        liveButton: 'Na żywo',
        connecting: 'Łączenie…',
        fontSize: 'Wielkość czcionki',
        changeLanguage: 'Zmień język',
        moreLanguages: 'Więcej języków',
    },
    sr: {
        chooseLanguage: 'Izaberite jezik',
        tagline: 'kao kod kuće',
        notLive: 'Prevod trenutno ne radi.',
        notLiveHint:
            'Bogosluženja se održavaju nedeljom. Pridružite se sledeći put.',
        churchSite: 'Sajt crkve',
        liveButton: 'Uživo',
        connecting: 'Povezivanje…',
        fontSize: 'Veličina slova',
        changeLanguage: 'Promeni jezik',
        moreLanguages: 'Drugi jezici',
    },
};

/** UI chrome v jazyce hosta; pro nepřeložené jazyky padá zpět na angličtinu. */
export function uiFor(code: CaptionLang | null | undefined): UiDict {
    return UI_STRINGS_BY_LANG[code ?? 'cs'] ?? UI_STRINGS_BY_LANG.en;
}

/** Pozvánka pro kartičku (host i nedoslýchaví) — krátká věta v daném jazyce. */
export const HARD_OF_HEARING_INVITE: Record<string, string> = {
    cs: 'Špatně slyšíte? Pusťte si živý přepis a překlad kázání.',
    en: 'Hard of hearing? Follow the live transcript & translation.',
    de: 'Schwerhörig? Lesen Sie die Live-Übersetzung der Predigt.',
    ru: 'Плохо слышно? Включите живой перевод проповеди.',
    uk: 'Погано чути? Увімкніть живий переклад проповіді.',
    pl: 'Słabo słyszysz? Włącz napisy na żywo i tłumaczenie.',
    sr: 'Slabije čujete? Pratite prevod uživo.',
};

/** Pozvánka „nerozumíte česky → čtěte překlad" pro kartičku cizinců. */
export const UNDERSTAND_INVITE: Record<string, string> = {
    en: "Don't understand Czech? Read the live translation.",
    de: 'Verstehen Sie kein Tschechisch? Lesen Sie die Live-Übersetzung.',
    ru: 'Не понимаете по-чешски? Читайте перевод в прямом эфире.',
    uk: 'Не розумієте чеської? Читайте переклад наживо.',
    pl: 'Nie rozumiesz po czesku? Czytaj tłumaczenie na żywo.',
    sr: 'Ne razumete češki? Čitajte prevod uživo.',
};
