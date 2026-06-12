import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
const ListLeaders = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListLeaders.url(options),
    method: 'get',
})

ListLeaders.definition = {
    methods: ["get","head"],
    url: '/admin/leaders',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
ListLeaders.url = (options?: RouteQueryOptions) => {
    return ListLeaders.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
ListLeaders.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListLeaders.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
ListLeaders.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListLeaders.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
const ListLeadersForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListLeaders.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
ListLeadersForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListLeaders.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\ListLeaders::__invoke
* @see app/Filament/Resources/Leaders/Pages/ListLeaders.php:7
* @route '/admin/leaders'
*/
ListLeadersForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListLeaders.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListLeaders.form = ListLeadersForm

export default ListLeaders