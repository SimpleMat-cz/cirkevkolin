import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
const ListSermons = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSermons.url(options),
    method: 'get',
})

ListSermons.definition = {
    methods: ["get","head"],
    url: '/admin/sermons',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
ListSermons.url = (options?: RouteQueryOptions) => {
    return ListSermons.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
ListSermons.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSermons.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
ListSermons.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSermons.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
const ListSermonsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSermons.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
ListSermonsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSermons.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\ListSermons::__invoke
* @see app/Filament/Resources/Sermons/Pages/ListSermons.php:7
* @route '/admin/sermons'
*/
ListSermonsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSermons.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListSermons.form = ListSermonsForm

export default ListSermons