import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/nedele',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\NedeleController::index
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

index.form = indexForm

const NedeleController = { index }

export default NedeleController