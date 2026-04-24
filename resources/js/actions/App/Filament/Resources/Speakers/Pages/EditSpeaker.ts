import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
const EditSpeaker = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSpeaker.url(args, options),
    method: 'get',
})

EditSpeaker.definition = {
    methods: ["get","head"],
    url: '/admin/speakers/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
EditSpeaker.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditSpeaker.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
EditSpeaker.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditSpeaker.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
EditSpeaker.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditSpeaker.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
const EditSpeakerForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSpeaker.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
EditSpeakerForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSpeaker.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\EditSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/EditSpeaker.php:7
* @route '/admin/speakers/{record}/edit'
*/
EditSpeakerForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditSpeaker.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditSpeaker.form = EditSpeakerForm

export default EditSpeaker