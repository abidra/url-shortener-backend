<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlShortener extends Model
{
    use HasFactory;

    protected $fillable = ['from_url', 'to_url', 'url_key'];

    /**
     * Generate shortener URL and insert into DB
     *
     * @param String $toUrl - Local or External urls
     * @return String
     */
    public static function generateShortUrl(String $toUrl): String
    {
        $urlKey = self::getUniqueKey();

        $result = self::create([
            'to_url' => $toUrl,
            'url_key' => $urlKey
        ]);

        return $result;
    }

    /**
     * Generate a random unique key for url shortener
     *
     * @return String
     */
    protected static function getUniqueKey(): String {
        $randomKey = Str::random(env('URL_KEY_LENGTH'));
        while(self::where('url_key', $randomKey)->exists()) {
            $randomKey = Str::random(env('URL_KEY_LENGTH'));
        }

        return $randomKey;
    }

    /**
     * Get original target Url from key
     *
     * @param String $urlKey
     * @return Mixed String|Boolean
     */
    public static function getOriginalUrlFromKey(String $urlKey): Mixed {
        $url = self::where('url_key', $urlKey)->first();

        if(!$url) return false;

        return $url->to_url;
    }
}
