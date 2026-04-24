<?php

/**
 * Dvě věci před Vercelem:
 *
 * 1) Vytvoří stub helpers.php pokud chybí (což by nemělo po `composer install`,
 *    ale ošetříme pro jistotu).
 * 2) Odstraní z `vendor/composer/autoload_files.php` záznam pro
 *    filament/notifications Testing/helpers.php. Ten soubor není v Lambda bundlu
 *    (Vercel NFT ho strippuje) a jeho require v autoload.php pak fatálně padá.
 *
 * Spouští se jako `post-autoload-dump` hook z composer.json.
 */

// 1) Stub fallback.
$stubs = [
    'vendor/filament/notifications/src/Testing/helpers.php' => "<?php\n// Stub — Vercel bundle fallback.\n",
];
foreach ($stubs as $path => $content) {
    $dir = dirname($path);
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
    if (! file_exists($path)) {
        @file_put_contents($path, $content);
    }
}

// 2) Patch autoload_files.php — odstranit záznam, který míří na Testing/helpers.
$autoloadFiles = 'vendor/composer/autoload_files.php';
if (is_file($autoloadFiles)) {
    $content = file_get_contents($autoloadFiles);
    // Matchneme řádky, které odkazují na filament/notifications Testing helpers.
    $patched = preg_replace(
        '/^\s*\'[^\']+\'\s*=>\s*\$[a-zA-Z]+Dir\s*\.\s*\'[^\']*filament\/notifications\/src\/Testing\/helpers\.php\',\s*\r?\n/m',
        '',
        $content
    );
    if ($patched !== null && $patched !== $content) {
        file_put_contents($autoloadFiles, $patched);
        echo "  vercel-stubs: patched autoload_files.php (removed filament Testing helpers entry)\n";
    }
}
