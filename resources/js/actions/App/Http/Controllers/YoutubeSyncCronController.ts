import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
} from './../../../../wayfinder';
/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
const YoutubeSyncCronController = (
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: YoutubeSyncCronController.url(options),
    method: 'get',
});

YoutubeSyncCronController.definition = {
    methods: ['get', 'head'],
    url: '/cron/youtube-sync',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
YoutubeSyncCronController.url = (options?: RouteQueryOptions) => {
    return YoutubeSyncCronController.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
YoutubeSyncCronController.get = (
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: YoutubeSyncCronController.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
YoutubeSyncCronController.head = (
    options?: RouteQueryOptions,
): RouteDefinition<'head'> => ({
    url: YoutubeSyncCronController.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
const YoutubeSyncCronControllerForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: YoutubeSyncCronController.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
YoutubeSyncCronControllerForm.get = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: YoutubeSyncCronController.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
YoutubeSyncCronControllerForm.head = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: YoutubeSyncCronController.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

YoutubeSyncCronController.form = YoutubeSyncCronControllerForm;

export default YoutubeSyncCronController;
