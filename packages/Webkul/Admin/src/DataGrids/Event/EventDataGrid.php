<?php

namespace Webkul\Admin\DataGrids\Event;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class EventDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $categoryNamesSub = DB::table('event_event_category')
            ->join('event_categories', 'event_event_category.event_category_id', '=', 'event_categories.id')
            ->select(
                'event_event_category.event_id',
                DB::raw('GROUP_CONCAT(DISTINCT event_categories.name ORDER BY event_categories.sort_order, event_categories.id SEPARATOR ", ") as category_name')
            )
            ->groupBy('event_event_category.event_id');

        $queryBuilder = DB::table('events')
            ->leftJoinSub($categoryNamesSub, 'event_cat_names', function ($join) {
                $join->on('events.id', '=', 'event_cat_names.event_id');
            })
            ->select(
                'events.id',
                'events.title',
                'events.event_date',
                'events.event_end_date',
                'events.organizer',
                'events.available_seats',
                'events.status',
                'event_cat_names.category_name'
            );

        $this->addFilter('id', 'events.id');
        $this->addFilter('title', 'events.title');
        $this->addFilter('event_date', 'events.event_date');
        $this->addFilter('event_end_date', 'events.event_end_date');
        $this->addFilter('organizer', 'events.organizer');
        $this->addFilter('available_seats', 'events.available_seats');
        $this->addFilter('status', 'events.status');
        $this->addFilter('category_name', 'event_cat_names.category_name');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index' => 'id',
            'label' => trans('admin::app.events.index.datagrid.id'),
            'type' => 'integer',
            'sortable' => true,
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => trans('admin::app.events.index.datagrid.title'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'event_date',
            'label' => trans('admin::app.events.index.datagrid.event_date'),
            'type' => 'date',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'event_end_date',
            'label' => trans('admin::app.events.index.datagrid.event_end_date'),
            'type' => 'date',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true,
            'closure' => fn ($row) => $row->event_end_date
                ? \Illuminate\Support\Carbon::parse($row->event_end_date)->format('Y-m-d')
                : '—',
        ]);

        $this->addColumn([
            'index' => 'organizer',
            'label' => trans('admin::app.events.index.datagrid.organizer'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index' => 'available_seats',
            'label' => trans('admin::app.events.index.datagrid.available_seats'),
            'type' => 'integer',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true,
            'closure' => fn ($row) => $row->available_seats === null
                ? trans('admin::app.events.index.datagrid.available_seats-unlimited')
                : (string) $row->available_seats,
        ]);

        $this->addColumn([
            'index' => 'category_name',
            'label' => trans('admin::app.events.index.datagrid.category_name'),
            'type' => 'string',
            'sortable' => true,
            'searchable' => true,
            'filterable' => true,
            'closure' => fn ($row) => $row->category_name ?: '—',
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => trans('admin::app.events.index.datagrid.published'),
            'type' => 'boolean',
            'sortable' => true,
            'searchable' => false,
            'filterable' => true,
            'closure' => fn ($row) => (bool) $row->status
                ? '<span class="badge badge-md badge-success">' . e(trans('admin::app.events.index.datagrid.published-yes')) . '</span>'
                : '<span class="badge badge-md badge-danger">' . e(trans('admin::app.events.index.datagrid.published-no')) . '</span>',
        ]);
    }

    public function prepareActions(): void
    {
        $this->addAction([
            'index' => 'edit',
            'icon' => 'icon-edit',
            'title' => trans('admin::app.datagrid.edit'),
            'method' => 'GET',
            'url' => fn ($row) => route('admin.events.edit', $row->id),
        ]);

        $this->addAction([
            'index' => 'delete',
            'icon' => 'icon-delete',
            'title' => trans('admin::app.datagrid.delete'),
            'url' => fn ($row) => route('admin.events.delete', $row->id),
            'method' => 'DELETE',
        ]);
    }
}
