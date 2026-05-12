import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
const ListNewsletterSubscribers = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListNewsletterSubscribers.url(options),
    method: 'get',
})

ListNewsletterSubscribers.definition = {
    methods: ["get","head"],
    url: '/admin/newsletter-subscribers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
ListNewsletterSubscribers.url = (options?: RouteQueryOptions) => {
    return ListNewsletterSubscribers.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
ListNewsletterSubscribers.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListNewsletterSubscribers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
ListNewsletterSubscribers.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListNewsletterSubscribers.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
const ListNewsletterSubscribersForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListNewsletterSubscribers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
ListNewsletterSubscribersForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListNewsletterSubscribers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\NewsletterSubscribers\Pages\ListNewsletterSubscribers::__invoke
* @see app/Filament/Resources/NewsletterSubscribers/Pages/ListNewsletterSubscribers.php:7
* @route '/admin/newsletter-subscribers'
*/
ListNewsletterSubscribersForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListNewsletterSubscribers.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListNewsletterSubscribers.form = ListNewsletterSubscribersForm

export default ListNewsletterSubscribers