<?php

use Illuminate\Contracts\Support\Htmlable;
use Ntpages\LaravelEncore\Encore;

if (!function_exists('encore_script_tags')) {
    /**
     * Returns the HTML markup for entry JavaScript files if those haven't been rendered yet
     * @param string $entryName
     * @param bool $defer
     * @return Htmlable|null
     */
    function encore_script_tags(string $entryName, bool $defer = true): ?Htmlable
    {
        return app(Encore::class)->getScriptTags($entryName, $defer);
    }
}

if (!function_exists('encore_link_tags')) {
    /**
     * Returns the HTML markup for entry Stylesheet files if those haven't been rendered yet
     * @param string $entryName
     * @return Htmlable|null
     */
    function encore_link_tags(string $entryName): ?Htmlable
    {
        return app(Encore::class)->getLinkTags($entryName);
    }
}
