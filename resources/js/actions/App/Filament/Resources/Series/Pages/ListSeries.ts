import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
const ListSeries = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSeries.url(options),
    method: 'get',
})

ListSeries.definition = {
    methods: ["get","head"],
    url: '/admin/series',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
ListSeries.url = (options?: RouteQueryOptions) => {
    return ListSeries.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
ListSeries.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSeries.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
ListSeries.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSeries.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
const ListSeriesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSeries.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
ListSeriesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSeries.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\ListSeries::__invoke
* @see app/Filament/Resources/Series/Pages/ListSeries.php:7
* @route '/admin/series'
*/
ListSeriesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSeries.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListSeries.form = ListSeriesForm

export default ListSeries