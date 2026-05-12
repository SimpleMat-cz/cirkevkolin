import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../../wayfinder'
/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
const ListSiteSettings = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSiteSettings.url(options),
    method: 'get',
})

ListSiteSettings.definition = {
    methods: ["get","head"],
    url: '/admin/site-settings',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
ListSiteSettings.url = (options?: RouteQueryOptions) => {
    return ListSiteSettings.definition.url + queryParams(options)
}

/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
ListSiteSettings.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ListSiteSettings.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
ListSiteSettings.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ListSiteSettings.url(options),
    method: 'head',
})

/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
const ListSiteSettingsForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSiteSettings.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
ListSiteSettingsForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSiteSettings.url(options),
    method: 'get',
})

/**
* @see \App\Filament\Resources\SiteSettings\Pages\ListSiteSettings::__invoke
* @see app/Filament/Resources/SiteSettings/Pages/ListSiteSettings.php:7
* @route '/admin/site-settings'
*/
ListSiteSettingsForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
    action: ListSiteSettings.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        }
    }),
    method: 'get',
})

ListSiteSettings.form = ListSiteSettingsForm

export default ListSiteSettings