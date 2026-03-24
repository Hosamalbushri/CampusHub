<?php

namespace Webkul\Event\Providers;

use Webkul\Core\Providers\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    /**
     * The models to be used by this module.
     *
     * @var array
     */
    protected $models = [
        \Webkul\Event\Models\EventCategory::class,
        \Webkul\Event\Models\Event::class,
        \Webkul\Event\Models\EventField::class,
    ];
}
