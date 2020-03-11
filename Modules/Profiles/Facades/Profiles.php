<?php

namespace TypiCMS\Modules\Profiles\Facades;

use Illuminate\Support\Facades\Facade;

class Profiles extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Profiles';
    }
}
