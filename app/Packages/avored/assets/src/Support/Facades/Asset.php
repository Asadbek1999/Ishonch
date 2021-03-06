<?php

namespace AvoRed\Assets\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \AvoRed\Assets\AssetsManager allJS()
 * @method static \AvoRed\Assets\AssetsManager allCSS()
 * @method static \AvoRed\Assets\AssetsManager renderJS($key, $path)
 * @method static \AvoRed\Assets\AssetsManager renderCSS($key, $path)
 */
class Asset extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'avored_assets';
    }
}
