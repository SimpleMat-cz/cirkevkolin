import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:23
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
* @see app/Http/Controllers/PrekladController.php:23
* @route '/preklad/admin'
*/
admin.url = (options?: RouteQueryOptions) => {
    return admin.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:23
* @route '/preklad/admin'
*/
admin.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: admin.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:23
* @route '/preklad/admin'
*/
admin.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: admin.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:23
* @route '/preklad/admin'
*/
const adminForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: admin.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:23
* @route '/preklad/admin'
*/
adminForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: admin.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrekladController::admin
* @see app/Http/Controllers/PrekladController.php:23
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

/**
* @see \App\Http\Controllers\PrekladController::sonioxKey
* @see app/Http/Controllers/PrekladController.php:34
* @route '/preklad/soniox-key'
*/
export const sonioxKey = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sonioxKey.url(options),
    method: 'post',
})

sonioxKey.definition = {
    methods: ["post"],
    url: '/preklad/soniox-key',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\PrekladController::sonioxKey
* @see app/Http/Controllers/PrekladController.php:34
* @route '/preklad/soniox-key'
*/
sonioxKey.url = (options?: RouteQueryOptions) => {
    return sonioxKey.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PrekladController::sonioxKey
* @see app/Http/Controllers/PrekladController.php:34
* @route '/preklad/soniox-key'
*/
sonioxKey.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: sonioxKey.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\PrekladController::sonioxKey
* @see app/Http/Controllers/PrekladController.php:34
* @route '/preklad/soniox-key'
*/
const sonioxKeyForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: sonioxKey.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\PrekladController::sonioxKey
* @see app/Http/Controllers/PrekladController.php:34
* @route '/preklad/soniox-key'
*/
sonioxKeyForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: sonioxKey.url(options),
    method: 'post',
})

sonioxKey.form = sonioxKeyForm

/**
* @see \App\Http\Controllers\PrekladController::realtimeToken
* @see app/Http/Controllers/PrekladController.php:64
* @route '/preklad/realtime-token'
*/
export const realtimeToken = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: realtimeToken.url(options),
    method: 'post',
})

realtimeToken.definition = {
    methods: ["post"],
    url: '/preklad/realtime-token',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\PrekladController::realtimeToken
* @see app/Http/Controllers/PrekladController.php:64
* @route '/preklad/realtime-token'
*/
realtimeToken.url = (options?: RouteQueryOptions) => {
    return realtimeToken.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PrekladController::realtimeToken
* @see app/Http/Controllers/PrekladController.php:64
* @route '/preklad/realtime-token'
*/
realtimeToken.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: realtimeToken.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\PrekladController::realtimeToken
* @see app/Http/Controllers/PrekladController.php:64
* @route '/preklad/realtime-token'
*/
const realtimeTokenForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: realtimeToken.url(options),
    method: 'post',
})

/**
* @see \App\Http\Controllers\PrekladController::realtimeToken
* @see app/Http/Controllers/PrekladController.php:64
* @route '/preklad/realtime-token'
*/
realtimeTokenForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: realtimeToken.url(options),
    method: 'post',
})

realtimeToken.form = realtimeTokenForm

const preklad = {
    admin: Object.assign(admin, admin),
    sonioxKey: Object.assign(sonioxKey, sonioxKey),
    realtimeToken: Object.assign(realtimeToken, realtimeToken),
}

export default preklad