import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
    applyUrlDefaults,
} from './../../../../../../wayfinder';
/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
const EditPage = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: EditPage.url(args, options),
    method: 'get',
});

EditPage.definition = {
    methods: ['get', 'head'],
    url: '/admin/pages/{record}/edit',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
EditPage.url = (
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
        EditPage.definition.url
            .replace('{record}', parsedArgs.record.toString())
            .replace(/\/+$/, '') + queryParams(options)
    );
};

/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
EditPage.get = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: EditPage.url(args, options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
EditPage.head = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteDefinition<'head'> => ({
    url: EditPage.url(args, options),
    method: 'head',
});

/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
const EditPageForm = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: EditPage.url(args, options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
EditPageForm.get = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: EditPage.url(args, options),
    method: 'get',
});

/**
 * @see \App\Filament\Resources\Pages\Pages\EditPage::__invoke
 * @see app/Filament/Resources/Pages/Pages/EditPage.php:7
 * @route '/admin/pages/{record}/edit'
 */
EditPageForm.head = (
    args:
        | { record: string | number }
        | [record: string | number]
        | string
        | number,
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: EditPage.url(args, {
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

EditPage.form = EditPageForm;

export default EditPage;
