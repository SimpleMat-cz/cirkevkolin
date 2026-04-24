import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../wayfinder'
/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
export const login = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

login.definition = {
    methods: ["get","head"],
    url: '/login',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
login.url = (options?: RouteQueryOptions) => {
    return login.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
login.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: login.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
login.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: login.url(options),
    method: 'head',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
const loginForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: login.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
loginForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: login.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::login
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:47
* @route '/login'
*/
loginForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: login.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

login.form = loginForm

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
export const logout = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

logout.definition = {
    methods: ["post"],
    url: '/logout',
} satisfies RouteDefinition<["post"]>

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
logout.url = (options?: RouteQueryOptions) => {
    return logout.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
logout.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: logout.url(options),
    method: 'post',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
const logoutForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: logout.url(options),
    method: 'post',
})

/**
* @see \Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::logout
* @see vendor/laravel/fortify/src/Http/Controllers/AuthenticatedSessionController.php:100
* @route '/logout'
*/
logoutForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
    action: logout.url(options),
    method: 'post',
})

logout.form = logoutForm

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
export const register = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

register.definition = {
    methods: ["get","head"],
    url: '/register',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
register.url = (options?: RouteQueryOptions) => {
    return register.definition.url + queryParams(options)
}

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
register.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: register.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
register.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: register.url(options),
    method: 'head',
})

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
const registerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: register.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
registerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: register.url(options),
    method: 'get',
})

/**
* @see \Laravel\Fortify\Http\Controllers\RegisteredUserController::register
* @see vendor/laravel/fortify/src/Http/Controllers/RegisteredUserController.php:41
* @route '/register'
*/
registerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: register.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

register.form = registerForm

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
export const home = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})

home.definition = {
    methods: ["get","head"],
    url: '/',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
home.url = (options?: RouteQueryOptions) => {
    return home.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
home.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: home.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
home.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: home.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
const homeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: home.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
homeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: home.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\HomeController::home
* @see app/Http/Controllers/HomeController.php:12
* @route '/'
*/
homeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: home.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

home.form = homeForm

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
export const nedele = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: nedele.url(options),
    method: 'get',
})

nedele.definition = {
    methods: ["get","head"],
    url: '/nedele',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
nedele.url = (options?: RouteQueryOptions) => {
    return nedele.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
nedele.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: nedele.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
nedele.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: nedele.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
const nedeleForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: nedele.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
nedeleForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: nedele.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\NedeleController::nedele
* @see app/Http/Controllers/NedeleController.php:9
* @route '/nedele'
*/
nedeleForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: nedele.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

nedele.form = nedeleForm

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
export const jsemTuPoprve = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jsemTuPoprve.url(options),
    method: 'get',
})

jsemTuPoprve.definition = {
    methods: ["get","head"],
    url: '/jsem-tu-poprve',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
jsemTuPoprve.url = (options?: RouteQueryOptions) => {
    return jsemTuPoprve.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
jsemTuPoprve.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: jsemTuPoprve.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
jsemTuPoprve.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: jsemTuPoprve.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
const jsemTuPoprveForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: jsemTuPoprve.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
jsemTuPoprveForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: jsemTuPoprve.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\JsemTuPoprveController::jsemTuPoprve
* @see app/Http/Controllers/JsemTuPoprveController.php:9
* @route '/jsem-tu-poprve'
*/
jsemTuPoprveForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: jsemTuPoprve.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

jsemTuPoprve.form = jsemTuPoprveForm

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
export const kdoJsme = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kdoJsme.url(options),
    method: 'get',
})

kdoJsme.definition = {
    methods: ["get","head"],
    url: '/kdo-jsme',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
kdoJsme.url = (options?: RouteQueryOptions) => {
    return kdoJsme.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
kdoJsme.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kdoJsme.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
kdoJsme.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: kdoJsme.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
const kdoJsmeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kdoJsme.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
kdoJsmeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kdoJsme.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KdoJsmeController::kdoJsme
* @see app/Http/Controllers/KdoJsmeController.php:9
* @route '/kdo-jsme'
*/
kdoJsmeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kdoJsme.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

kdoJsme.form = kdoJsmeForm

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
export const coDelame = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: coDelame.url(options),
    method: 'get',
})

coDelame.definition = {
    methods: ["get","head"],
    url: '/co-delame',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
coDelame.url = (options?: RouteQueryOptions) => {
    return coDelame.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
coDelame.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: coDelame.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
coDelame.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: coDelame.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
const coDelameForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: coDelame.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
coDelameForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: coDelame.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::coDelame
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
coDelameForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: coDelame.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

coDelame.form = coDelameForm

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
export const kazani = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kazani.url(options),
    method: 'get',
})

kazani.definition = {
    methods: ["get","head"],
    url: '/kazani',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
kazani.url = (options?: RouteQueryOptions) => {
    return kazani.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
kazani.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kazani.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
kazani.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: kazani.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
const kazaniForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kazani.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
kazaniForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kazani.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KazaniController::kazani
* @see app/Http/Controllers/KazaniController.php:15
* @route '/kazani'
*/
kazaniForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kazani.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

kazani.form = kazaniForm

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
export const akce = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: akce.url(options),
    method: 'get',
})

akce.definition = {
    methods: ["get","head"],
    url: '/akce',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
akce.url = (options?: RouteQueryOptions) => {
    return akce.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
akce.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: akce.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
akce.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: akce.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
const akceForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: akce.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
akceForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: akce.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\AkceController::akce
* @see app/Http/Controllers/AkceController.php:16
* @route '/akce'
*/
akceForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: akce.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

akce.form = akceForm

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
export const kontakt = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kontakt.url(options),
    method: 'get',
})

kontakt.definition = {
    methods: ["get","head"],
    url: '/kontakt',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
kontakt.url = (options?: RouteQueryOptions) => {
    return kontakt.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
kontakt.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kontakt.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
kontakt.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: kontakt.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
const kontaktForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kontakt.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
kontaktForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kontakt.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\KontaktController::kontakt
* @see app/Http/Controllers/KontaktController.php:9
* @route '/kontakt'
*/
kontaktForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kontakt.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

kontakt.form = kontaktForm

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
export const prispet = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: prispet.url(options),
    method: 'get',
})

prispet.definition = {
    methods: ["get","head"],
    url: '/prispet',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
prispet.url = (options?: RouteQueryOptions) => {
    return prispet.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
prispet.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: prispet.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
prispet.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: prispet.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
const prispetForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: prispet.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
prispetForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: prispet.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\PrispetController::prispet
* @see app/Http/Controllers/PrispetController.php:10
* @route '/prispet'
*/
prispetForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: prispet.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

prispet.form = prispetForm

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
export const sitemap = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sitemap.url(options),
    method: 'get',
})

sitemap.definition = {
    methods: ["get","head"],
    url: '/sitemap.xml',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
sitemap.url = (options?: RouteQueryOptions) => {
    return sitemap.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
sitemap.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: sitemap.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
sitemap.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: sitemap.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
const sitemapForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: sitemap.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
sitemapForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: sitemap.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\SitemapController::__invoke
* @see app/Http/Controllers/SitemapController.php:11
* @route '/sitemap.xml'
*/
sitemapForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: sitemap.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

sitemap.form = sitemapForm

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/dashboard',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url(options),
    method: 'get',
})

/**
* @see \Inertia\Controller::__invoke
* @see vendor/inertiajs/inertia-laravel/src/Controller.php:13
* @route '/dashboard'
*/
dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: dashboard.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

dashboard.form = dashboardForm
