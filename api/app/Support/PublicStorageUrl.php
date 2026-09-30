<?php

namespace App\Support;

use Illuminate\Http\Request;

class PublicStorageUrl
{
    public static function make(?string $path, Request $request): ?string
    {
        if (!$path) {
            return null;
        }

        $path = trim($path);
        $parsed = parse_url($path);

        if (isset($parsed['scheme'], $parsed['host'])) {
            $host = strtolower($parsed['host']);
            if (!in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
                return $path;
            }

            $path = ($parsed['path'] ?? '/')
                . (isset($parsed['query']) ? '?'.$parsed['query'] : '')
                . (isset($parsed['fragment']) ? '#'.$parsed['fragment'] : '');
        }

        $isRootPath = str_starts_with($path, '/');
        $path = ltrim($path, '/');
        if (!$isRootPath && str_starts_with($path, 'storage/')) {
            $isRootPath = true;
        }

        $urlPath = $isRootPath ? '/'.$path : '/storage/'.$path;
        $segments = explode('/', $urlPath);
        $urlPath = implode('/', array_map(
            static fn (string $segment): string => rawurlencode(rawurldecode($segment)),
            $segments,
        ));

        return rtrim($request->getSchemeAndHttpHost(), '/').$urlPath;
    }
}