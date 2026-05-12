export type SiteSettings = Record<string, string | null>;

export type Page = {
    id: number;
    title: string;
    slug: string;
    hero_eyebrow?: string | null;
    hero_title?: string | null;
    hero_title_accent?: string | null;
    hero_accent_color?: string | null;
    hero_description?: string | null;
    meta_title?: string | null;
    meta_description?: string | null;
    is_published: boolean;
};

export type Faq = {
    id: number;
    question: string;
    answer: string;
};
