import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
    applyUrlDefaults,
} from './../../../../../../wayfinder';
/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
const EditSiteSetting = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: EditSiteSetting.url(args, options),
    method: 'get',
});

EditSiteSetting.definition = {
    methods: ['get', 'head'],
    url: '/admin/site-settings/{record}/edit',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
EditSiteSetting.url = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { record: args };
    }

    if (Array.isArray(args)) {
        args = {
            record: args[0],
        };
    }

    args = applyUrlDefaults(args);

    const parsedArgs = {
        record: args.record,
    };

    return (
        EditSiteSetting.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
EditSiteSetting.get = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: EditSiteSetting.url(args, options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
EditSiteSetting.head = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'head'> => ({
    url: EditSiteSetting.url(args, options),
    method: 'head',
});

/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
const EditSiteSettingForm = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: EditSiteSetting.url(args, options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
EditSiteSettingForm.get = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: EditSiteSetting.url(args, options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\SiteSettings\Pages\EditSiteSetting::__invoke
 * @see app/Filament/Resources/SiteSettings/Pages/EditSiteSetting.php:7
 * @route '/admin/site-settings/{record}/edit'
 */
EditSiteSettingForm.head = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: EditSiteSetting.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

EditSiteSetting.form = EditSiteSettingForm;

export default EditSiteSetting;
