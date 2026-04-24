import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
const EditVisitRequest = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditVisitRequest.url(args, options),
    method: 'get',
})

EditVisitRequest.definition = {
    methods: ["get","head"],
    url: '/admin/visit-requests/{record}/edit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
EditVisitRequest.url = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return EditVisitRequest.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
EditVisitRequest.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: EditVisitRequest.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
EditVisitRequest.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: EditVisitRequest.url(args, options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
const EditVisitRequestForm = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditVisitRequest.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
EditVisitRequestForm.get = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditVisitRequest.url(args, options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\EditVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/EditVisitRequest.php:7
* @route '/admin/visit-requests/{record}/edit'
*/
EditVisitRequestForm.head = (args: { record: string | number } | [record: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: EditVisitRequest.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

EditVisitRequest.form = EditVisitRequestForm

export default EditVisitRequest