import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
const ListPages = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPages.url(options),
    method: 'get',
})

ListPages.definition = {
    methods: ["get","head"],
    url: '/admin/pages',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
ListPages.url = (options?: RouteQueryOptions) => {
    return ListPages.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
ListPages.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListPages.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
ListPages.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListPages.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
const ListPagesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListPages.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
ListPagesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListPages.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Pages\Pages\ListPages::__invoke
* @see app/Filament/Resources/Pages/Pages/ListPages.php:7
* @route '/admin/pages'
*/
ListPagesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListPages.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListPages.form = ListPagesForm

export default ListPages