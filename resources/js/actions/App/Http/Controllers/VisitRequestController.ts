import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\VisitRequestController::store
* @see app/Http/Controllers/VisitRequestController.php:12
* @route '/jsem-tu-poprve/prihlaseni'
*/
export const store = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

store.definition = {
    methods: ["post"],
    url: '/jsem-tu-poprve/prihlaseni',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\VisitRequestController::store
* @see app/Http/Controllers/VisitRequestController.php:12
* @route '/jsem-tu-poprve/prihlaseni'
*/
store.url = (options?: RouteQueryOptions) => {
    return store.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\VisitRequestController::store
* @see app/Http/Controllers/VisitRequestController.php:12
* @route '/jsem-tu-poprve/prihlaseni'
*/
store.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\VisitRequestController::store
* @see app/Http/Controllers/VisitRequestController.php:12
* @route '/jsem-tu-poprve/prihlaseni'
*/
const storeForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\VisitRequestController::store
* @see app/Http/Controllers/VisitRequestController.php:12
* @route '/jsem-tu-poprve/prihlaseni'
*/
storeForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: store.url(options),
    method: 'post',
})

store.form = storeForm

const VisitRequestController = { store }

export default VisitRequestController