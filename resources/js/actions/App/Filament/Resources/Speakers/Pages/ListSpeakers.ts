import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
const ListSpeakers = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSpeakers.url(options),
    method: 'get',
})

ListSpeakers.definition = {
    methods: ["get","head"],
    url: '/admin/speakers',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
ListSpeakers.url = (options?: RouteQueryOptions) => {
    return ListSpeakers.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
ListSpeakers.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSpeakers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
ListSpeakers.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSpeakers.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
const ListSpeakersForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSpeakers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
ListSpeakersForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSpeakers.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\Speakers\Pages\ListSpeakers::__invoke
* @see app/Filament/Resources/Speakers/Pages/ListSpeakers.php:7
* @route '/admin/speakers'
*/
ListSpeakersForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSpeakers.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListSpeakers.form = ListSpeakersForm

export default ListSpeakers