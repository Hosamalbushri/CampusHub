<?php

return [
    /**
     * General.
     */
    [
        'key' => 'general',
        'name' => 'admin::app.configuration.index.general.title',
        'info' => 'admin::app.configuration.index.general.info',
        'sort' => 1,
    ], [
        'key' => 'general.general',
        'name' => 'admin::app.configuration.index.general.general.title',
        'info' => 'admin::app.configuration.index.general.general.info',
        'icon' => 'icon-setting',
        'sort' => 1,
    ], [
        'key' => 'general.general.locale_settings',
        'name' => 'admin::app.configuration.index.general.general.locale-settings.title',
        'info' => 'admin::app.configuration.index.general.general.locale-settings.title-info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'locale',
                'title' => 'admin::app.configuration.index.general.general.locale-settings.title',
                'type' => 'select',
                'default' => 'en',
                'options' => 'Webkul\Core\Core@locales',
            ],
        ],
    ], [
        'key' => 'general.design',
        'name' => 'admin::app.configuration.index.general.design.title',
        'info' => 'admin::app.configuration.index.general.design.info',
        'icon' => 'icon-configuration',
        'sort' => 2,
    ], [
        'key' => 'general.design.admin_logo',
        'name' => 'admin::app.configuration.index.general.design.admin-logo.title',
        'info' => 'admin::app.configuration.index.general.design.admin-logo.title-info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'logo_image',
                'title' => 'admin::app.configuration.index.general.design.admin-logo.logo-image',
                'type' => 'image',
                'channel_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp,svg',
            ], [
                'name' => 'favicon',
                'title' => 'admin::app.configuration.index.general.design.admin-logo.favicon',
                'type' => 'image',
                'channel_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp,svg,ico',
            ],
        ],
    ], [
        'key' => 'general.store',
        'name' => 'admin::app.configuration.index.general.store.title',
        'info' => 'admin::app.configuration.index.general.store.info',
        'icon' => 'icon-configuration',
        'sort' => 3,
    ], [
        'key' => 'general.store.shop',
        'name' => 'admin::app.configuration.index.general.store.shop-logo.title',
        'info' => 'admin::app.configuration.index.general.store.shop-logo.title-info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'logo_image',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.logo-image',
                'type' => 'image',
                'channel_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp,svg',
            ], [
                'name' => 'favicon',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.favicon',
                'type' => 'image',
                'channel_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp,svg,ico',
            ], [
                'name' => 'primary_color',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.primary-color',
                'type' => 'color',
                'default' => '#0284c7',
            ], [
                'name' => 'accent_color',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.accent-color',
                'type' => 'color',
                'default' => '#0369a1',
            ], [
                'name' => 'icon_color',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.icon-color',
                'type' => 'color',
                'default' => '#0369a1',
            ], [
                'name' => 'badge_color',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.badge-color',
                'type' => 'color',
                'default' => '#0284c7',
            ], [
                'name' => 'header_middle_logo',
                'title' => 'admin::app.configuration.index.general.store.shop-logo.header-middle-logo',
                'type' => 'image',
                'channel_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp,svg',
            ],
        ],
    ], [
        'key' => 'general.store.events_page',
        'name' => 'admin::app.configuration.index.general.store.events-page.title',
        'info' => 'admin::app.configuration.index.general.store.events-page.title-info',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'heading',
                'title' => 'admin::app.configuration.index.general.store.events-page.heading',
                'type' => 'text',
                'default' => 'Events for students',
                'validation' => 'max:255',
            ], [
                'name' => 'description',
                'title' => 'admin::app.configuration.index.general.store.events-page.description',
                'type' => 'textarea',
                'default' => 'Browse published events you can attend or follow.',
            ], [
                'name' => 'per_page',
                'title' => 'admin::app.configuration.index.general.store.events-page.per-page',
                'type' => 'number',
                'default' => 12,
                'validation' => 'integer|min:1|max:48',
            ],
        ],
    ], [
        'key' => 'general.store.navigation',
        'name' => 'admin::app.configuration.index.general.store.navigation.title',
        'info' => 'admin::app.configuration.index.general.store.navigation.title-info',
        'sort' => 3,
        'fields' => [
            [
                'name' => 'show_home',
                'title' => 'admin::app.configuration.index.general.store.navigation.show-home',
                'type' => 'boolean',
                'default' => true,
            ], [
                'name' => 'home_label',
                'title' => 'admin::app.configuration.index.general.store.navigation.home-label',
                'type' => 'text',
                'default' => 'Home',
                'validation' => 'max:100',
            ], [
                'name' => 'show_events',
                'title' => 'admin::app.configuration.index.general.store.navigation.show-events',
                'type' => 'boolean',
                'default' => true,
            ], [
                'name' => 'events_label',
                'title' => 'admin::app.configuration.index.general.store.navigation.events-label',
                'type' => 'text',
                'default' => 'Events',
                'validation' => 'max:100',
            ], [
                'name' => 'custom_1_enabled',
                'title' => 'admin::app.configuration.index.general.store.navigation.custom-1-enabled',
                'type' => 'boolean',
                'default' => false,
            ], [
                'name' => 'custom_1_label',
                'title' => 'admin::app.configuration.index.general.store.navigation.custom-1-label',
                'type' => 'text',
                'validation' => 'max:100',
            ], [
                'name' => 'custom_1_url',
                'title' => 'admin::app.configuration.index.general.store.navigation.custom-1-url',
                'type' => 'text',
                'validation' => 'max:500',
            ], [
                'name' => 'custom_2_enabled',
                'title' => 'admin::app.configuration.index.general.store.navigation.custom-2-enabled',
                'type' => 'boolean',
                'default' => false,
            ], [
                'name' => 'custom_2_label',
                'title' => 'admin::app.configuration.index.general.store.navigation.custom-2-label',
                'type' => 'text',
                'validation' => 'max:100',
            ], [
                'name' => 'custom_2_url',
                'title' => 'admin::app.configuration.index.general.store.navigation.custom-2-url',
                'type' => 'text',
                'validation' => 'max:500',
            ],
        ],
    ], [
        'key' => 'general.store.student_login',
        'name' => 'admin::app.configuration.index.general.store.student-login.title',
        'info' => 'admin::app.configuration.index.general.store.student-login.title-info',
        'sort' => 4,
        'fields' => [
            [
                'name' => 'logo_image',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-logo-image',
                'type' => 'image',
                'channel_based' => false,
                'validation' => 'mimes:bmp,jpeg,jpg,png,webp,svg',
            ], [
                'name' => 'primary_color',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-primary-color',
                'type' => 'color',
                'default' => '#2563eb',
            ], [
                'name' => 'accent_color',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-accent-color',
                'type' => 'color',
                'default' => '#7c3aed',
            ], [
                'name' => 'surface_start',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-surface-start',
                'type' => 'color',
                'default' => '#f9fafb',
            ], [
                'name' => 'surface_end',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-surface-end',
                'type' => 'color',
                'default' => '#ffffff',
            ], [
                'name' => 'panel_start',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-panel-start',
                'type' => 'color',
                'default' => '#0f172a',
            ], [
                'name' => 'panel_end',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-panel-end',
                'type' => 'color',
                'default' => '#1d4ed8',
            ], [
                'name' => 'title',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-title',
                'type' => 'text',
                'validation' => 'max:255',
            ], [
                'name' => 'description',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-description',
                'type' => 'textarea',
            ], [
                'name' => 'eyebrow',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-eyebrow',
                'type' => 'text',
                'validation' => 'max:100',
            ], [
                'name' => 'panel_lead',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-panel-lead',
                'type' => 'textarea',
            ], [
                'name' => 'card_number',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-card-number',
                'type' => 'text',
                'validation' => 'max:255',
            ], [
                'name' => 'password',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-password',
                'type' => 'text',
                'validation' => 'max:255',
            ], [
                'name' => 'remember',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-remember',
                'type' => 'text',
                'validation' => 'max:255',
            ], [
                'name' => 'submit',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-submit',
                'type' => 'text',
                'validation' => 'max:255',
            ], [
                'name' => 'back_portal',
                'title' => 'admin::app.configuration.index.general.store.student-login.field-back-portal',
                'type' => 'text',
                'validation' => 'max:255',
            ],
        ],
    ], [
        'key' => 'general.settings',
        'name' => 'admin::app.configuration.index.general.settings.title',
        'info' => 'admin::app.configuration.index.general.settings.info',
        'icon' => 'icon-configuration',
        'sort' => 4,
    ], [
        'key' => 'general.settings.footer',
        'name' => 'admin::app.configuration.index.general.settings.footer.title',
        'info' => 'admin::app.configuration.index.general.settings.footer.info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'label',
                'title' => 'admin::app.configuration.index.general.settings.footer.powered-by',
                'type' => 'editor',
                'default' => 'Powered by <span style="color: rgb(14, 144, 217);"><a href="http://www.krayincrm.com" target="_blank">Krayin</a></span>, an open-source project by <span style="color: rgb(14, 144, 217);"><a href="https://webkul.com" target="_blank">Webkul</a></span>.',
                'tinymce' => true,
            ],
        ],
    ], [
        'key' => 'general.settings.menu',
        'name' => 'admin::app.configuration.index.general.settings.menu.title',
        'info' => 'admin::app.configuration.index.general.settings.menu.info',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'dashboard',
                'title' => 'admin::app.configuration.index.general.settings.menu.dashboard',
                'type' => 'text',
                'default' => 'Dashboard',
                'validation' => 'max:20',
            ],
//            [
//                'name' => 'leads',
//                'title' => 'admin::app.configuration.index.general.settings.menu.leads',
//                'type' => 'text',
//                'default' => 'Leads',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'quotes',
//                'title' => 'admin::app.configuration.index.general.settings.menu.quotes',
//                'type' => 'text',
//                'default' => 'Quotes',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'mail.mail',
//                'title' => 'admin::app.configuration.index.general.settings.menu.mail',
//                'type' => 'text',
//                'default' => 'Mail',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'mail.inbox',
//                'title' => 'admin::app.configuration.index.general.settings.menu.inbox',
//                'type' => 'text',
//                'default' => 'Inbox',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'mail.draft',
//                'title' => 'admin::app.configuration.index.general.settings.menu.draft',
//                'type' => 'text',
//                'default' => 'Draft',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'mail.outbox',
//                'title' => 'admin::app.configuration.index.general.settings.menu.outbox',
//                'type' => 'text',
//                'default' => 'Outbox',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'mail.sent',
//                'title' => 'admin::app.configuration.index.general.settings.menu.sent',
//                'type' => 'text',
//                'default' => 'Sent',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'mail.trash',
//                'title' => 'admin::app.configuration.index.general.settings.menu.trash',
//                'type' => 'text',
//                'default' => 'Trash',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'activities',
//                'title' => 'admin::app.configuration.index.general.settings.menu.activities',
//                'type' => 'text',
//                'default' => 'Activities',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'contacts.contacts',
//                'title' => 'admin::app.configuration.index.general.settings.menu.contacts',
//                'type' => 'text',
//                'default' => 'Contacts',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'contacts.persons',
//                'title' => 'admin::app.configuration.index.general.settings.menu.persons',
//                'type' => 'text',
//                'default' => 'Persons',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'contacts.organizations',
//                'title' => 'admin::app.configuration.index.general.settings.menu.organizations',
//                'type' => 'text',
//                'default' => 'Organizations',
//                'validation' => 'max:20',
//            ], [
//                'name' => 'products',
//                'title' => 'admin::app.configuration.index.general.settings.menu.products',
//                'type' => 'text',
//                'default' => 'Products',
//                'validation' => 'max:20',
//            ],
            [
                'name' => 'settings',
                'title' => 'admin::app.configuration.index.general.settings.menu.settings',
                'type' => 'text',
                'default' => 'Settings',
                'validation' => 'max:20',
            ], [
                'name' => 'configuration',
                'title' => 'admin::app.configuration.index.general.settings.menu.configuration',
                'type' => 'text',
                'default' => 'Configuration',
                'validation' => 'max:20',
            ],
        ],
    ], [
        'key' => 'general.settings.menu_color',
        'name' => 'admin::app.configuration.index.general.settings.menu-color.title',
        'info' => 'admin::app.configuration.index.general.settings.menu-color.info',
        'sort' => 3,
        'fields' => [
            [
                'name' => 'brand_color',
                'title' => 'admin::app.configuration.index.general.settings.menu-color.brand-color',
                'type' => 'color',
                'default' => '#0E90D9',
            ],
        ],
    ], [
        'key' => 'general.magic_ai',
        'name' => 'admin::app.configuration.index.magic-ai.title',
        'info' => 'admin::app.configuration.index.magic-ai.info',
        'icon' => 'icon-setting',
        'sort' => 5,
    ], [
        'key' => 'general.magic_ai.settings',
        'name' => 'admin::app.configuration.index.magic-ai.settings.title',
        'info' => 'admin::app.configuration.index.magic-ai.settings.info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'enable',
                'title' => 'admin::app.configuration.index.magic-ai.settings.enable',
                'type' => 'boolean',
                'channel_based' => true,
            ], [
                'name' => 'api_key',
                'title' => 'admin::app.configuration.index.magic-ai.settings.api-key',
                'type' => 'password',
                'depends' => 'enable:1',
                'validation' => 'required_if:enable,1',
                'info' => 'admin::app.configuration.index.magic-ai.settings.api-key-info',
            ], [
                'name' => 'model',
                'title' => 'admin::app.configuration.index.magic-ai.settings.models.title',
                'type' => 'select',
                'channel_based' => true,
                'depends' => 'enable:1',
                'options' => [
                    [
                        'title' => 'admin::app.configuration.index.magic-ai.settings.models.gpt-4o',
                        'value' => 'openai/chatgpt-4o-latest',
                    ], [
                        'title' => 'admin::app.configuration.index.magic-ai.settings.models.gpt-4o-mini',
                        'value' => 'openai/gpt-4o-mini',
                    ], [
                        'title' => 'admin::app.configuration.index.magic-ai.settings.models.gemini-2-0-flash-001',
                        'value' => 'google/gemini-2.0-flash-001',
                    ], [
                        'title' => 'admin::app.configuration.index.magic-ai.settings.models.deepseek-r1',
                        'value' => 'deepseek/deepseek-r1-distill-llama-8b',
                    ], [
                        'title' => 'admin::app.configuration.index.magic-ai.settings.models.llama-3-2-3b-instruct',
                        'value' => 'meta-llama/llama-3.2-3b-instruct',
                    ], [
                        'title' => 'admin::app.configuration.index.magic-ai.settings.models.grok-2-1212',
                        'value' => 'x-ai/grok-2-1212',
                    ],
                ],
            ], [
                'name' => 'other_model',
                'title' => 'admin::app.configuration.index.magic-ai.settings.other',
                'type' => 'text',
                'info' => 'admin::app.configuration.index.magic-ai.settings.other-model',
                'default' => null,
                'depends' => 'enable:1',
            ],
        ],
    ], [
        'key' => 'general.magic_ai.doc_generation',
        'name' => 'admin::app.configuration.index.magic-ai.settings.doc-generation',
        'info' => 'admin::app.configuration.index.magic-ai.settings.doc-generation-info',
        'sort' => 2,
        'fields' => [
            [
                'name' => 'enabled',
                'title' => 'admin::app.configuration.index.magic-ai.settings.enable',
                'type' => 'boolean',
            ],
        ],
    ],

    /**
     * Email.
     */
    [
        'key' => 'email',
        'name' => 'admin::app.configuration.index.email.title',
        'info' => 'admin::app.configuration.index.email.info',
        'sort' => 2,
    ], [
        'key' => 'email.imap',
        'name' => 'admin::app.configuration.index.email.imap.title',
        'info' => 'admin::app.configuration.index.email.imap.info',
        'icon' => 'icon-setting',
        'sort' => 1,
    ], [
        'key' => 'email.imap.account',
        'name' => 'admin::app.configuration.index.email.imap.account.title',
        'info' => 'admin::app.configuration.index.email.imap.account.title-info',
        'sort' => 1,
        'fields' => [
            [
                'name' => 'host',
                'title' => 'admin::app.configuration.index.email.imap.account.host',
                'type' => 'text',
                'default' => config('imap.accounts.default.host'),
            ],
            [
                'name' => 'port',
                'title' => 'admin::app.configuration.index.email.imap.account.port',
                'type' => 'text',
                'default' => config('imap.accounts.default.port'),
            ],
            [
                'name' => 'encryption',
                'title' => 'admin::app.configuration.index.email.imap.account.encryption',
                'type' => 'text',
                'default' => config('imap.accounts.default.encryption'),
            ],
            [
                'name' => 'validate_cert',
                'title' => 'admin::app.configuration.index.email.imap.account.validate-cert',
                'type' => 'boolean',
                'default' => config('imap.accounts.default.validate_cert'),
            ],
            [
                'name' => 'username',
                'title' => 'admin::app.configuration.index.email.imap.account.username',
                'type' => 'text',
                'default' => config('imap.accounts.default.username'),
            ],
            [
                'name' => 'password',
                'title' => 'admin::app.configuration.index.email.imap.account.password',
                'type' => 'password',
                'default' => config('imap.accounts.default.password'),
            ],
        ],
    ],
];
