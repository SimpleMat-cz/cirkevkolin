import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/co-delame',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
*/
indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: index.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::index
* @see app/Http/Controllers/CoDelameController.php:9
* @route '/co-delame'
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

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
export const nedelniSetkani = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: nedelniSetkani.url(options),
    method: 'get',
})

nedelniSetkani.definition = {
    methods: ["get","head"],
    url: '/co-delame/nedelni-setkani',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
nedelniSetkani.url = (options?: RouteQueryOptions) => {
    return nedelniSetkani.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
nedelniSetkani.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: nedelniSetkani.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
nedelniSetkani.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: nedelniSetkani.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
const nedelniSetkaniForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: nedelniSetkani.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
nedelniSetkaniForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: nedelniSetkani.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::nedelniSetkani
* @see app/Http/Controllers/CoDelameController.php:14
* @route '/co-delame/nedelni-setkani'
*/
nedelniSetkaniForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: nedelniSetkani.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

nedelniSetkani.form = nedelniSetkaniForm

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
export const kidztown = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kidztown.url(options),
    method: 'get',
})

kidztown.definition = {
    methods: ["get","head"],
    url: '/co-delame/kidztown',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
kidztown.url = (options?: RouteQueryOptions) => {
    return kidztown.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
kidztown.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kidztown.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
kidztown.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: kidztown.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
const kidztownForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kidztown.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
kidztownForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kidztown.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::kidztown
* @see app/Http/Controllers/CoDelameController.php:19
* @route '/co-delame/kidztown'
*/
kidztownForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kidztown.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

kidztown.form = kidztownForm

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
export const wyldlife = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: wyldlife.url(options),
    method: 'get',
})

wyldlife.definition = {
    methods: ["get","head"],
    url: '/co-delame/wyldlife',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
wyldlife.url = (options?: RouteQueryOptions) => {
    return wyldlife.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
wyldlife.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: wyldlife.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
wyldlife.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: wyldlife.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
const wyldlifeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: wyldlife.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
wyldlifeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: wyldlife.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::wyldlife
* @see app/Http/Controllers/CoDelameController.php:24
* @route '/co-delame/wyldlife'
*/
wyldlifeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: wyldlife.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

wyldlife.form = wyldlifeForm

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
export const skupinky = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: skupinky.url(options),
    method: 'get',
})

skupinky.definition = {
    methods: ["get","head"],
    url: '/co-delame/skupinky',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
skupinky.url = (options?: RouteQueryOptions) => {
    return skupinky.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
skupinky.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: skupinky.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
skupinky.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: skupinky.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
const skupinkyForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: skupinky.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
skupinkyForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: skupinky.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::skupinky
* @see app/Http/Controllers/CoDelameController.php:29
* @route '/co-delame/skupinky'
*/
skupinkyForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: skupinky.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

skupinky.form = skupinkyForm

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
export const youngLife = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: youngLife.url(options),
    method: 'get',
})

youngLife.definition = {
    methods: ["get","head"],
    url: '/co-delame/young-life',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
youngLife.url = (options?: RouteQueryOptions) => {
    return youngLife.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
youngLife.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: youngLife.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
youngLife.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: youngLife.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
const youngLifeForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: youngLife.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
youngLifeForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: youngLife.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::youngLife
* @see app/Http/Controllers/CoDelameController.php:34
* @route '/co-delame/young-life'
*/
youngLifeForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: youngLife.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

youngLife.form = youngLifeForm

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
export const kavarna = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kavarna.url(options),
    method: 'get',
})

kavarna.definition = {
    methods: ["get","head"],
    url: '/co-delame/kavarna',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
kavarna.url = (options?: RouteQueryOptions) => {
    return kavarna.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
kavarna.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: kavarna.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
kavarna.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: kavarna.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
const kavarnaForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kavarna.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
kavarnaForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kavarna.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::kavarna
* @see app/Http/Controllers/CoDelameController.php:39
* @route '/co-delame/kavarna'
*/
kavarnaForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: kavarna.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

kavarna.form = kavarnaForm

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
export const business = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: business.url(options),
    method: 'get',
})

business.definition = {
    methods: ["get","head"],
    url: '/co-delame/business',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
business.url = (options?: RouteQueryOptions) => {
    return business.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
business.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: business.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
business.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: business.url(options),
    method: 'head',
})

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
const businessForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: business.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
businessForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: business.url(options),
    method: 'get',
})

/**
* @see \App\Http\Controllers\CoDelameController::business
* @see app/Http/Controllers/CoDelameController.php:44
* @route '/co-delame/business'
*/
businessForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: business.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

business.form = businessForm

const CoDelameController = { index, nedelniSetkani, kidztown, wyldlife, skupinky, youngLife, kavarna, business }

export default CoDelameController