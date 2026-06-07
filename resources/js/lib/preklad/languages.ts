import type { CaptionLang } from './types'

export interface LangOption {
    code: CaptionLang
    /** Native label shown to the guest. */
    nativeName: string
    flag: string
    /** Soniox target_language for the translation session. Omitted for the cs original. */
    targetLanguage?: string
}

/** Full set of output languages (Czech original + four translations). */
export const LANGUAGES: LangOption[] = [
    { code: 'cs', nativeName: 'Čeština', flag: '🇨🇿' },
    { code: 'en', nativeName: 'English', flag: '🇬🇧', targetLanguage: 'en' },
    { code: 'uk', nativeName: 'Українська', flag: '🇺🇦', targetLanguage: 'uk' },
    { code: 'pl', nativeName: 'Polski', flag: '🇵🇱', targetLanguage: 'pl' },
    { code: 'sr', nativeName: 'Srpski', flag: '🇷🇸', targetLanguage: 'sr' },
]

/**
 * Languages enabled in the current phase. Phase 1 ships Czech + English only;
 * widen this list in Phase 2 to enable the full fan-out.
 */
export const ENABLED_LANG_CODES: CaptionLang[] = ['cs', 'en']

export const ENABLED_LANGUAGES: LangOption[] = LANGUAGES.filter((l) => ENABLED_LANG_CODES.includes(l.code))

/** Target languages that require a dedicated Soniox translation session. */
export const TRANSLATION_TARGETS: LangOption[] = ENABLED_LANGUAGES.filter((l) => l.targetLanguage)

export function langOption(code: CaptionLang): LangOption {
    return LANGUAGES.find((l) => l.code === code) ?? LANGUAGES[0]
}

/** Minimal UI dictionary (interface chrome only — not the captions themselves). */
type UiKey =
    | 'chooseLanguage'
    | 'notLive'
    | 'notLiveHint'
    | 'churchSite'
    | 'liveButton'
    | 'connecting'
    | 'fontSize'
    | 'changeLanguage'

export const UI_STRINGS: Record<CaptionLang, Record<UiKey, string>> = {
    cs: {
        chooseLanguage: 'Vyber si jazyk',
        notLive: 'Překlad právě neběží.',
        notLiveHint: 'Bohoslužby probíhají v neděli. Připoj se příště.',
        churchSite: 'Web církve',
        liveButton: 'Živě',
        connecting: 'Připojuji…',
        fontSize: 'Velikost písma',
        changeLanguage: 'Změnit jazyk',
    },
    en: {
        chooseLanguage: 'Choose your language',
        notLive: 'Translation is not running right now.',
        notLiveHint: 'Services are held on Sundays. Join us next time.',
        churchSite: 'Church website',
        liveButton: 'Live',
        connecting: 'Connecting…',
        fontSize: 'Font size',
        changeLanguage: 'Change language',
    },
    uk: {
        chooseLanguage: 'Виберіть мову',
        notLive: 'Переклад зараз не працює.',
        notLiveHint: 'Богослужіння відбуваються щонеділі. Приєднуйтесь наступного разу.',
        churchSite: 'Сайт церкви',
        liveButton: 'Наживо',
        connecting: 'З’єднання…',
        fontSize: 'Розмір шрифту',
        changeLanguage: 'Змінити мову',
    },
    pl: {
        chooseLanguage: 'Wybierz język',
        notLive: 'Tłumaczenie nie jest teraz aktywne.',
        notLiveHint: 'Nabożeństwa odbywają się w niedziele. Dołącz następnym razem.',
        churchSite: 'Strona kościoła',
        liveButton: 'Na żywo',
        connecting: 'Łączenie…',
        fontSize: 'Wielkość czcionki',
        changeLanguage: 'Zmień język',
    },
    sr: {
        chooseLanguage: 'Izaberite jezik',
        notLive: 'Prevod trenutno ne radi.',
        notLiveHint: 'Bogosluženja se održavaju nedeljom. Pridružite se sledeći put.',
        churchSite: 'Sajt crkve',
        liveButton: 'Uživo',
        connecting: 'Povezivanje…',
        fontSize: 'Veličina slova',
        changeLanguage: 'Promeni jezik',
    },
}
