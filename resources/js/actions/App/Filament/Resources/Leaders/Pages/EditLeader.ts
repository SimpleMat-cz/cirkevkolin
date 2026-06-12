import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
const EditLeader = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditLeader.url(args, options),
    method: 'get',
})

EditLeader.definition = {
    methods: ["get","head"],
    url: '/admin/leaders/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
EditLeader.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditLeader.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
EditLeader.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditLeader.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
EditLeader.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditLeader.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
const EditLeaderForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditLeader.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
EditLeaderForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditLeader.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\EditLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/EditLeader.php:7
* @route '/admin/leaders/{record}/edit'
*/
EditLeaderForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditLeader.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditLeader.form = EditLeaderForm

export default EditLeader