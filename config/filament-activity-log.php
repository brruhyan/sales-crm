<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Resource Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the Activity Log resource.
    |
    */
    'resource' => [
        'class' => \AlizHarb\ActivityLog\Resources\ActivityLogs\ActivityLogResource::class,
        'group' => null,
        'sort' => null,
        'default_sort_column' => 'created_at',
        'default_sort_direction' => 'desc',
        'navigation_count_badge' => false,
        'navigation_icon' => 'heroicon-o-rectangle-stack',
        'global_search' => [
            'enabled' => true,
            'attributes' => ['log_name', 'description', 'subject_type', 'event'],
        ],
        'pagination' => [
            'options' => [10, 25, 50, 100],
            'default' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Activity Log Icons & Colors
    |--------------------------------------------------------------------------
    |
    | Define the icons and colors for different activity events.
    | You can add custom events here as well.
    |
    */
    'events' => [
        'created' => [
            'icon' => 'heroicon-m-plus',
            'color' => 'success',
        ],
        'updated' => [
            'icon' => 'heroicon-m-pencil',
            'color' => 'warning',
        ],
        'deleted' => [
            'icon' => 'heroicon-m-trash',
            'color' => 'danger',
        ],
        'restored' => [
            'icon' => 'heroicon-m-arrow-uturn-left',
            'color' => 'gray',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | DateTime Format
    |--------------------------------------------------------------------------
    |
    | The format used for displaying dates in the timeline and table.
    |
    */
    'datetime_format' => 'M d, Y H:i:s',

    /*
    |--------------------------------------------------------------------------
    | Table Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the activity log table.
    |
    */
    'table' => [
        'columns' => [
            'log_name' => [
                'visible' => true,
                'searchable' => true,
                'sortable' => true,
            ],
            'event' => [
                'visible' => true,
                'searchable' => true,
                'sortable' => true,
            ],
            'subject_type' => [
                'visible' => true,
                'searchable' => true,
                'sortable' => true,
            ],
            'causer' => [
                'visible' => true,
                'searchable' => true,
                'sortable' => true,
            ],
            'description' => [
                'visible' => true,
                'searchable' => true,
                'sortable' => true,
            ],
            'ip_address' => [
                'visible' => false,
                'searchable' => false,
                'sortable' => false,
            ],
            'user_agent' => [
                'visible' => false,
                'searchable' => false,
                'sortable' => false,
            ],
            'created_at' => [
                'visible' => true,
                'searchable' => false,
                'sortable' => true,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Infolist Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the activity log infolist.
    |
    */
    'infolist' => [
        'entries' => [
            'log_name' => true,
            'event' => true,
            'created_at' => true,
            'causer' => true,
            'subject' => true,
            'description' => true,
            'properties_attributes' => true,
            'properties_old' => true,
            'properties_raw' => true,
            'ip_address' => false,
            'user_agent' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeline Action
    |--------------------------------------------------------------------------
    |
    | Configuration for the timeline action.
    |
    */
    'timeline' => [
        'show_action' => true,
        'icon' => 'heroicon-m-clock',
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for the permissions.
    |
    */
    'permissions' => [
        'enabled' => false,
        'view_any' => 'view_any_activity',
        'view' => 'view_activity',
        'create' => 'create_activity',
        'update' => 'update_activity',
        'delete' => 'delete_activity',
        'restore' => 'restore_activity',
        'force_delete' => 'force_delete_activity',
    ],

    /*
    |--------------------------------------------------------------------------
    | Widgets Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for dashboard widgets.
    |
    */
    'widgets' => [
        'enabled' => true,
        'dashboard' => true,
        'widgets' => [
            \AlizHarb\ActivityLog\Widgets\LatestActivityWidget::class,
        ],

        /**
         * Activity Chart Widget Configuration
         */
        'activity_chart' => [
            'enabled' => false,
            'heading' => 'Activity Over Time',
            'sort' => 1,
            'column_span' => 1,
            'max_height' => '300px',
            'polling_interval' => null,
            'days' => 30,
            'type' => 'line',
            'label' => 'Activities',
            'fill' => true,
            'tension' => 0.3,
            'border_color' => '#10b981',
            'fill_color' => 'rgba(16, 185, 129, 0.1)',
            'date_format' => 'M d',
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => false,
                    ],
                ],
                'scales' => [
                    'y' => [
                        'beginAtZero' => true,
                        'ticks' => [
                            'precision' => 0,
                        ],
                    ],
                ],
            ],
        ],

        /**
         * Latest Activity Widget Configuration
         */
        'latest_activity' => [
            'enabled' => true,
            'heading' => null,
            'sort' => 1,
            'column_span' => 'full',
            'polling_interval' => null,
            'limit' => 10,
            'paginated' => false,
            'columns' => [
                'event' => true,
                'causer' => true,
                'causer_limit' => 30,
                'subject_type' => true,
                'subject_type_limit' => 30,
                'description' => true,
                'description_limit' => 50,
                'created_at' => true,
            ],
        ],
    ],
];
