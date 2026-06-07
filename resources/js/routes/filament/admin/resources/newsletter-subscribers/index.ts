import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
} from './../../../../../wayfinder';
/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

index.definition = {
    methods: ['get', 'head'],
    url: '/admin/newsletter-subscribers',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options);
};

/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
});

/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
const indexForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
 * @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
 * @route '/admin/newsletter-subscribers'
 */
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

index.form = indexForm;

const newsletterSubscribers = {
    index: Object.assign(index, index),
};

export default newsletterSubscribers;
