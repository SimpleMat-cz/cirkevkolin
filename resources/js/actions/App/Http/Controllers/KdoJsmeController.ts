import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/kdo-jsme',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::index
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
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

const KdoJsmeController = { index }

export default KdoJsmeController