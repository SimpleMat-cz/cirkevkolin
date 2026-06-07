import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
export const admin = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: admin.url(options),
    method: 'get',
})

admin.definition = {
    methods: ["get","head"],
    url: '/preklad/admin',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
admin.url = (options?: RouteQueryOptions) => {
    return admin.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
admin.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: admin.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
admin.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: admin.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
const adminForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: admin.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
adminForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: admin.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:15
* @route '/preklad/admin'
*/
adminForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: admin.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

admin.form = adminForm

const preklad = {
    admin: Object.assign(admin, admin),
}

export default preklad