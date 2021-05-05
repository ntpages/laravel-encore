<?php

namespace Ntpages\LaravelEncore;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Arr;

class Encore
{
    private array $returnedFiles = [];
    private array $entrypoints = [];
    private array $manifest = [];

    public function __construct()
    {
        $config = \config('encore');

        if (is_array($config['packages'])) {
            foreach ($config['packages'] as $key => $path) {
                [
                    'entrypoints' => $this->entrypoints[$key],
                    'manifest' => $this->manifest[$key]
                ] = $this->readEncoreFiles("{$config['output_path']}/$path");
            }
        } else {
            [
                'entrypoints' => $this->entrypoints,
                'manifest' => $this->manifest
            ] = $this->readEncoreFiles($config['output_path']);
        }
    }

    public function asset(string $path): ?string
    {
        return Arr::get($this->manifest, $path) ?? $path;
    }

    public function getLinkTags(string $entryName): ?Htmlable
    {
        return $this->getEntries($entryName, 'css', fn(string $p) => sprintf('<link rel="stylesheet" href="%s"/>', $p));
    }

    public function getScriptTags(string $entryName, bool $defer = true): ?Htmlable
    {
        $script = \sprintf('<script src="%%s"%s></script>', $defer ? ' defer' : '');

        return $this->getEntries($entryName, 'js', fn(string $p) => \sprintf($script, $p));
    }

    protected function getEntries(string $entryName, string $entryType, callable $format): ?Htmlable
    {
        if (empty($entries = Arr::get($this->entrypoints, "$entryName.$entryType"))) {
            return null;
        }

        // make sure to not return the same file multiple times
        $newFiles = array_values(array_diff($entries, $this->returnedFiles));
        $this->returnedFiles = array_merge($this->returnedFiles, $newFiles);

        return new HtmlString(\implode('', \array_map($format, $newFiles)));
    }

    protected function readEncoreFiles(string $path): array
    {
        $manifest = [];

        // removing the prefix
        foreach ($this->readJsonFile("$path/manifest.json") as $key => $value) {
            $manifest[substr($key, strlen("$path/"))] = $value;
        }

        return [
            'entrypoints' => $this->readJsonFile("$path/entrypoints.json")['entrypoints'],
            'manifest' => $manifest
        ];
    }

    protected function readJsonFile(string $path): array
    {
        return \json_decode(\file_get_contents(public_path($path)), true);
    }
}
