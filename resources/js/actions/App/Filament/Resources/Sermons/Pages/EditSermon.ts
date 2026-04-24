import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
const EditSermon = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSermon.url(args, options),
    method: 'get',
})

EditSermon.definition = {
    methods: ["get","head"],
    url: '/admin/sermons/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
EditSermon.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditSermon.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
EditSermon.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSermon.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
EditSermon.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditSermon.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
const EditSermonForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSermon.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
EditSermonForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSermon.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\EditSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/EditSermon.php:7
* @route '/admin/sermons/{record}/edit'
*/
EditSermonForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSermon.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditSermon.form = EditSermonForm

export default EditSermon