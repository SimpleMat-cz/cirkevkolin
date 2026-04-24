import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
const CreateSermon = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSermon.url(options),
    method: 'get',
})

CreateSermon.definition = {
    methods: ["get","head"],
    url: '/admin/sermons/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
CreateSermon.url = (options?: RouteQueryOptions) => {
    return CreateSermon.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
CreateSermon.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSermon.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
CreateSermon.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateSermon.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
const CreateSermonForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSermon.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
CreateSermonForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSermon.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Sermons\Pages\CreateSermon::__invoke
* @see app/Filament/Resources/Sermons/Pages/CreateSermon.php:7
* @route '/admin/sermons/create'
*/
CreateSermonForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSermon.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateSermon.form = CreateSermonForm

export default CreateSermon