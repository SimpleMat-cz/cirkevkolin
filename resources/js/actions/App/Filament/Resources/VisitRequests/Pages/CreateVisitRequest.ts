import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
const CreateVisitRequest = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateVisitRequest.url(options),
    method: 'get',
})

CreateVisitRequest.definition = {
    methods: ["get","head"],
    url: '/admin/visit-requests/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
CreateVisitRequest.url = (options?: RouteQueryOptions) => {
    return CreateVisitRequest.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
CreateVisitRequest.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateVisitRequest.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
CreateVisitRequest.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateVisitRequest.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
const CreateVisitRequestForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateVisitRequest.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
CreateVisitRequestForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateVisitRequest.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\CreateVisitRequest::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/CreateVisitRequest.php:7
* @route '/admin/visit-requests/create'
*/
CreateVisitRequestForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateVisitRequest.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateVisitRequest.form = CreateVisitRequestForm

export default CreateVisitRequest