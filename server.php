<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    (string) parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && $uri !== '' && file_exists(__DIR__.'/public'.$uri)) {
    // PHP's built-in web server does not support HTTP Range requests for static files
    // (returning 200 OK without Accept-Ranges / 206 Partial Content), which breaks
    // seeking in HTML5 <audio>/<video> and mediaelementplayer.
    $__normalizedUri = str_replace('\\', '/', $uri);
    $__ext = strtolower(pathinfo($__normalizedUri, PATHINFO_EXTENSION));
    $__mediaTypes = [
        'ogg'  => 'audio/ogg',
        'oga'  => 'audio/ogg',
        'opus' => 'audio/ogg',
        'mp3'  => 'audio/mpeg',
        'wav'  => 'audio/wav',
        'flac' => 'audio/flac',
        'aac'  => 'audio/aac',
        'm4a'  => 'audio/mp4',
        'mp4'  => 'video/mp4',
        'm4v'  => 'video/mp4',
        'webm' => 'video/webm',
        'ogv'  => 'video/ogg',
    ];

    if (isset($__mediaTypes[$__ext]) && is_file(__DIR__.'/public'.$__normalizedUri)) {
        $__hasTraversal = strpos($__normalizedUri, "\0") !== false
            || preg_match('#(^|/)\.\.(/|$)#', $__normalizedUri) === 1;

        $__filePath   = $__hasTraversal ? false : realpath(__DIR__.'/public'.$__normalizedUri);
        $__publicDir  = realpath(__DIR__.'/public');
        $__storageDir = realpath(__DIR__.'/public/storage');

        $__inPublic = $__filePath !== false
            && $__publicDir !== false
            && strpos($__filePath, $__publicDir.DIRECTORY_SEPARATOR) === 0;

        $__underStorageUri = DIRECTORY_SEPARATOR === '\\'
            ? stripos($__normalizedUri, '/storage/') === 0
            : strpos($__normalizedUri, '/storage/') === 0;

        $__inStorage = $__filePath !== false
            && $__storageDir !== false
            && $__underStorageUri
            && strpos($__filePath, $__storageDir.DIRECTORY_SEPARATOR) === 0;

        // Path-traversal guard: allow only files inside public/ or the public/storage symlink target.
        if ($__filePath === false || !is_file($__filePath) || (!$__inPublic && !$__inStorage)) {
            http_response_code(403);
            return true;
        }

        $__size = filesize($__filePath);
        if ($__size === false) {
            http_response_code(500);
            return true;
        }

        $__type   = $__mediaTypes[$__ext];
        $__isHead = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD';

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Handle single byte-range requests per RFC 7233 (bytes=start-end, bytes=start-, bytes=-suffix).
        if (!empty($_SERVER['HTTP_RANGE'])
            && preg_match('/^bytes=(\d*)-(\d*)$/i', trim($_SERVER['HTTP_RANGE']), $__m)
        ) {
            $__startRaw = $__m[1];
            $__endRaw   = $__m[2];

            if (($__startRaw === '' && $__endRaw === '') || $__size === 0) {
                http_response_code(416);
                header('Accept-Ranges: bytes');
                header("Content-Range: bytes */$__size");
                return true;
            }

            if ($__startRaw === '') {
                $__suffix = (int) $__endRaw;
                if ($__suffix <= 0) {
                    http_response_code(416);
                    header('Accept-Ranges: bytes');
                    header("Content-Range: bytes */$__size");
                    return true;
                }
                $__start = max(0, $__size - $__suffix);
                $__end   = $__size - 1;
            } else {
                $__start = (int) $__startRaw;
                $__end   = $__endRaw !== '' ? min((int) $__endRaw, $__size - 1) : $__size - 1;
            }

            if ($__start > $__end || $__start >= $__size) {
                http_response_code(416);
                header('Accept-Ranges: bytes');
                header("Content-Range: bytes */$__size");
                return true;
            }

            $__length = $__end - $__start + 1;

            http_response_code(206);
            header("Content-Type: $__type");
            header('Accept-Ranges: bytes');
            header("Content-Range: bytes $__start-$__end/$__size");
            header("Content-Length: $__length");

            if (!$__isHead) {
                $__fp = fopen($__filePath, 'rb');
                if ($__fp !== false) {
                    fseek($__fp, $__start);
                    $__rem = $__length;
                    while ($__rem > 0 && !feof($__fp)) {
                        $__chunk = fread($__fp, min($__rem, 8192));
                        if ($__chunk === false || $__chunk === '') {
                            break;
                        }
                        echo $__chunk;
                        $__rem -= strlen($__chunk);
                        flush();
                    }
                    fclose($__fp);
                }
            }

            return true;
        }

        // Full response with Accept-Ranges header so browsers know seeking via Range is supported.
        http_response_code(200);
        header("Content-Type: $__type");
        header('Accept-Ranges: bytes');
        header("Content-Length: $__size");

        if (!$__isHead) {
            readfile($__filePath);
        }

        return true;
    }

    return false;
}

require_once __DIR__.'/public/index.php';
