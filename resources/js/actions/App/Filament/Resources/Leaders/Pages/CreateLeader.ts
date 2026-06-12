import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
const CreateLeader = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateLeader.url(options),
    method: 'get',
})

CreateLeader.definition = {
    methods: ["get","head"],
    url: '/admin/leaders/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
CreateLeader.url = (options?: RouteQueryOptions) => {
    return CreateLeader.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
CreateLeader.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateLeader.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
CreateLeader.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateLeader.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
const CreateLeaderForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateLeader.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
CreateLeaderForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateLeader.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Leaders\Pages\CreateLeader::__invoke
* @see app/Filament/Resources/Leaders/Pages/CreateLeader.php:7
* @route '/admin/leaders/create'
*/
CreateLeaderForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateLeader.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateLeader.form = CreateLeaderForm

export default CreateLeader