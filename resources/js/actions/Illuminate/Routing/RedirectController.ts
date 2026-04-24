import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
const RedirectController95dc0ba3e0fa3f3cb7d32fc207184316 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'get',
})

RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/o-nas',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url = (options?: RouteQueryOptions) => {
    return RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
const RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/o-nas'
*/
RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectController95dc0ba3e0fa3f3cb7d32fc207184316.form = RedirectController95dc0ba3e0fa3f3cb7d32fc207184316Form
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
const RedirectController524e2db38d5907cf86d31923fdbd8763 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'get',
})

RedirectController524e2db38d5907cf86d31923fdbd8763.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/co-delame',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.url = (options?: RouteQueryOptions) => {
    return RedirectController524e2db38d5907cf86d31923fdbd8763.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
const RedirectController524e2db38d5907cf86d31923fdbd8763Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-delame'
*/
RedirectController524e2db38d5907cf86d31923fdbd8763Form.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController524e2db38d5907cf86d31923fdbd8763.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectController524e2db38d5907cf86d31923fdbd8763.form = RedirectController524e2db38d5907cf86d31923fdbd8763Form
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
const RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'get',
})

RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/co-poslouchame',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url = (options?: RouteQueryOptions) => {
    return RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
const RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/co-poslouchame'
*/
RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e.form = RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5eForm
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
const RedirectControllera64e7ecd471fa1692606b917b60b3894 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'get',
})

RedirectControllera64e7ecd471fa1692606b917b60b3894.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/kde-nas-najdes',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.url = (options?: RouteQueryOptions) => {
    return RedirectControllera64e7ecd471fa1692606b917b60b3894.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
const RedirectControllera64e7ecd471fa1692606b917b60b3894Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/kde-nas-najdes'
*/
RedirectControllera64e7ecd471fa1692606b917b60b3894Form.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectControllera64e7ecd471fa1692606b917b60b3894.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectControllera64e7ecd471fa1692606b917b60b3894.form = RedirectControllera64e7ecd471fa1692606b917b60b3894Form
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
const RedirectController8b72587d67a3b9f33de91798fece91d9 = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'get',
})

RedirectController8b72587d67a3b9f33de91798fece91d9.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/feed',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.url = (options?: RouteQueryOptions) => {
    return RedirectController8b72587d67a3b9f33de91798fece91d9.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
const RedirectController8b72587d67a3b9f33de91798fece91d9Form = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/feed'
*/
RedirectController8b72587d67a3b9f33de91798fece91d9Form.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController8b72587d67a3b9f33de91798fece91d9.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectController8b72587d67a3b9f33de91798fece91d9.form = RedirectController8b72587d67a3b9f33de91798fece91d9Form
/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
const RedirectController4b87d2df7e3aa853f6720faea796e36c = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

RedirectController4b87d2df7e3aa853f6720faea796e36c.definition = {
    methods: ["get","head","post","put","patch","delete","options"],
    url: '/settings',
} satisfies RouteDefinition<["get","head","post","put","patch","delete","options"]>

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.url = (options?: RouteQueryOptions) => {
    return RedirectController4b87d2df7e3aa853f6720faea796e36c.definition.url + queryParams(options)
}

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'head',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.put = (options?: RouteQueryOptions): RouteDefinition<'put'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'put',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.patch = (options?: RouteQueryOptions): RouteDefinition<'patch'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'patch',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.delete = (options?: RouteQueryOptions): RouteDefinition<'delete'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'delete',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36c.options = (options?: RouteQueryOptions): RouteDefinition<'options'> => ({
    url: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'options',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
const RedirectController4b87d2df7e3aa853f6720faea796e36cForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url(options),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.put = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PUT',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.patch = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'PATCH',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.delete = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'DELETE',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'post',
})

/**
* @see \Illuminate\Routing\RedirectController::__invoke
* @see vendor/laravel/framework/src/Illuminate/Routing/RedirectController.php:19
* @route '/settings'
*/
RedirectController4b87d2df7e3aa853f6720faea796e36cForm.options = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: RedirectController4b87d2df7e3aa853f6720faea796e36c.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'OPTIONS',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

RedirectController4b87d2df7e3aa853f6720faea796e36c.form = RedirectController4b87d2df7e3aa853f6720faea796e36cForm

const RedirectController = {
    '/o-nas': RedirectController95dc0ba3e0fa3f3cb7d32fc207184316,
    '/co-delame': RedirectController524e2db38d5907cf86d31923fdbd8763,
    '/co-poslouchame': RedirectControllerdd2f789cbc5d8afe125c33b6d4932b5e,
    '/kde-nas-najdes': RedirectControllera64e7ecd471fa1692606b917b60b3894,
    '/feed': RedirectController8b72587d67a3b9f33de91798fece91d9,
    '/settings': RedirectController4b87d2df7e3aa853f6720faea796e36c,
}

export default RedirectController