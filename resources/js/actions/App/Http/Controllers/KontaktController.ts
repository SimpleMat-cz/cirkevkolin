import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/kontakt',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KontaktController::index
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
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

const KontaktController = { index }

export default KontaktController