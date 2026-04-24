import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
const CreateSpeaker = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSpeaker.url(options),
    method: 'get',
})

CreateSpeaker.definition = {
    methods: ["get","head"],
    url: '/admin/speakers/create',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
CreateSpeaker.url = (options?: RouteQueryOptions) => {
    return CreateSpeaker.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
CreateSpeaker.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: CreateSpeaker.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
CreateSpeaker.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: CreateSpeaker.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
const CreateSpeakerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSpeaker.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
CreateSpeakerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSpeaker.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\CreateSpeaker::__invoke
* @see app/Filament/Resources/Speakers/Pages/CreateSpeaker.php:7
* @route '/admin/speakers/create'
*/
CreateSpeakerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: CreateSpeaker.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

CreateSpeaker.form = CreateSpeakerForm

export default CreateSpeaker