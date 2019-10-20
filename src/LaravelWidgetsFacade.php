<?php

namespace SchuBu\LaravelWidgets;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SchuBu\LaravelWidgets\Skeleton\SkeletonClass
 */
class LaravelWidgetsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-widgets';
    }
}
