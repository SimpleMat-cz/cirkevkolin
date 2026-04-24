import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
const ListVisitRequests = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListVisitRequests.url(options),
    method: 'get',
})

ListVisitRequests.definition = {
    methods: ["get","head"],
    url: '/admin/visit-requests',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
ListVisitRequests.url = (options?: RouteQueryOptions) => {
    return ListVisitRequests.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
ListVisitRequests.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListVisitRequests.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
ListVisitRequests.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListVisitRequests.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
const ListVisitRequestsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListVisitRequests.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
ListVisitRequestsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListVisitRequests.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\VisitRequests\Pages\ListVisitRequests::__invoke
* @see app/Filament/Resources/VisitRequests/Pages/ListVisitRequests.php:7
* @route '/admin/visit-requests'
*/
ListVisitRequestsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListVisitRequests.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListVisitRequests.form = ListVisitRequestsForm

export default ListVisitRequests