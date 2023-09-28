<?php

namespace App\Http\Controllers;

use Cache;
use Markdown;

class HelpController extends Controller 
{
    public function topic($topic, Markdown $markdown)
    {
        $helpFile = base_path('resources/help/' . str_replace('.', '/', $topic) . '.md');
        if(!file_exists($helpFile)) {
            return 'No help found for given topic <strong>' . $topic . '</strong>';
        }
        $helpFileMd5 = md5_file($helpFile);

        $helpCached = Cache::store('file')->get($topic);
        if(!$helpCached || $helpCached['md5'] != $helpFileMd5) {
            $helpMarkdown = file_get_contents($helpFile);
            $helpHtml = $markdown->parse($helpMarkdown);
            Cache::store('file')->forever($topic, [ 'md5' => $helpFileMd5, 'html' => $helpHtml ]);
        } else {
            $helpHtml = $helpCached['html'];
        }

        return $helpHtml;
    }
}