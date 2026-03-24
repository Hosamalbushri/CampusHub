<?php

namespace Webkul\Event\Repositories;

use Webkul\Core\Eloquent\Repository;

class EventFieldRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return \Webkul\Event\Contracts\EventField::class;
    }
}
