import {
    queryParams,
    type RouteQueryOptions,
    type RouteDefinition,
    type RouteFormDefinition,
} from './../../wayfinder';
/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
export const youtubeSync = (
    options?: RouteQueryOptions,
): RouteDefinition<'get'> => ({
    url: youtubeSync.url(options),
    method: 'get',
});

youtubeSync.definition = {
    methods: ['get', 'head'],
    url: '/cron/youtube-sync',
} satisfies RouteDefinition<['get', 'head']>;

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
youtubeSync.url = (options?: RouteQueryOptions) => {
    return youtubeSync.definition.url + queryParams(options);
};

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
youtubeSync.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: youtubeSync.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
youtubeSync.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: youtubeSync.url(options),
    method: 'head',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
const youtubeSyncForm = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: youtubeSync.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
youtubeSyncForm.get = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: youtubeSync.url(options),
    method: 'get',
});

/**
 * @see \App\Http\Controllers\YoutubeSyncCronController::__invoke
 * @see app/Http/Controllers/YoutubeSyncCronController.php:16
 * @route '/cron/youtube-sync'
 */
youtubeSyncForm.head = (
    options?: RouteQueryOptions,
): RouteFormDefinition<'get'> => ({
    action: youtubeSync.url({
        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
            _method: 'HEAD',
            ...(options?.query ?? options?.mergeQuery ?? {}),
        },
    }),
    method: 'get',
});

youtubeSync.form = youtubeSyncForm;

const cron = {
    youtubeSync: Object.assign(youtubeSync, youtubeSync),
};

export default cron;
