import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
const EditSeries = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSeries.url(args, options),
    method: 'get',
})

EditSeries.definition = {
    methods: ["get","head"],
    url: '/admin/series/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
EditSeries.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args }
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
        record: args.record,
    }

    return EditSeries.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
EditSeries.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSeries.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
EditSeries.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditSeries.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
const EditSeriesForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSeries.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
EditSeriesForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSeries.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Series\Pages\EditSeries::__invoke
* @see app/Filament/Resources/Series/Pages/EditSeries.php:7
* @route '/admin/series/{record}/edit'
*/
EditSeriesForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSeries.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditSeries.form = EditSeriesForm

export default EditSeries