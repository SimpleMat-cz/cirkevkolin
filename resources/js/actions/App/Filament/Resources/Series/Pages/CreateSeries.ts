import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
const CreateSeries = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSeries.url(options),
    method: 'get',
})

CreateSeries.definition = {
    methods: ["get","head"],
    url: '/admin/series/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
CreateSeries.url = (options?: RouteQueryOptions) => {
    return CreateSeries.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
CreateSeries.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSeries.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
CreateSeries.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateSeries.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
const CreateSeriesForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSeries.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
CreateSeriesForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSeries.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\CreateSeries::__invoke
* @see app/Filament/Resources/Series/Pages/CreateSeries.php:7
* @route '/admin/series/create'
*/
CreateSeriesForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSeries.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateSeries.form = CreateSeriesForm

export default CreateSeries