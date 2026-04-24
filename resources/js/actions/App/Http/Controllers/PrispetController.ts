import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/prispet',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrispetController::index
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
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

const PrispetController = { index }

export default PrispetController