import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/jsem-tu-poprve',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::index
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
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

const JsemTuPoprveController = { index }

export default JsemTuPoprveController