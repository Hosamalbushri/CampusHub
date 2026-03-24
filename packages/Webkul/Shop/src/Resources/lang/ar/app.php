<?php

return [
    'meta' => [
        'title' => 'بوابة الطلاب — الفعاليات',
    ],

    'home' => [
        'seo' => [
            'meta-title'       => 'بوابة الطلاب',
            'meta-description' => 'استعرض الفعاليات والتحديثات للطلاب.',
            'meta-keywords'    => 'طلاب، فعاليات، بوابة',
        ],
        'index' => [
            'image-carousel'      => 'صور مميزة',
            'events-carousel'     => 'فعاليات مميزة',
            'categories-carousel' => 'تصنيفات الفعاليات',
            'footer-links'        => 'أعمدة روابط في الصفحة الرئيسية',
            'services-strip'      => 'الخدمات والمميزات',
        ],
        'hero' => [
            'heading'    => 'مرحباً بك في بوابة الطلاب',
            'subheading' => 'اكتشف الفعاليات وتابع ما يحدث في الحرم.',
            'cta'        => 'استعرض الفعاليات',
        ],
        'event-carousel' => [
            'title'    => 'أحدث الفعاليات',
            'empty'    => 'لا توجد فعاليات منشورة بعد.',
            'view-all' => 'كل الفعاليات',
        ],
        'category-carousel' => [
            'title'    => 'تصفح حسب التصنيف',
            'empty'    => 'لا توجد تصنيفات فعاليات بعد.',
            'view-all' => 'كل الفعاليات',
        ],
        'carousel' => [
            'slide-alt' => 'صورة العرض :n',
        ],
    ],

    'layout' => [
        'brand' => 'بوابة الطلاب',
        'nav' => [
            'home' => 'الرئيسية',
            'events' => 'الفعاليات',
            'student-login' => 'تسجيل دخول الطلاب',
            'student-logout' => 'تسجيل الخروج',
            'student-menu' => 'قائمة حساب الطالب',
            'student-registration' => 'رقم القيد',
        ],
        'footer' => 'فعاليات منشورة للطلاب.',
        'services-placeholder' => '',
    ],

    'partials' => [
        'pagination' => [
            'pagination-showing' => 'عرض :firstItem إلى :lastItem من أصل :total',
            'simple' => 'صفحات إضافية متاحة',
            'page-nav' => 'التصفح بين الصفحات',
            'prev-page' => 'الصفحة السابقة',
            'next-page' => 'الصفحة التالية',
            'prev-symbol' => '‹',
            'next-symbol' => '›',
        ],
    ],

    'components' => [
        'layouts' => [
            'skip-to-content' => 'تخطي إلى المحتوى الرئيسي',
            'header' => [
                'desktop' => [
                    'bottom' => [
                        'logo-alt' => 'الرئيسية',
                        'nav-label' => 'التنقل الرئيسي',
                        'search' => 'البحث في الفعاليات',
                        'search-text' => 'ابحث في الفعاليات…',
                    ],
                ],
                'mobile' => [
                    'logo-alt' => 'الرئيسية',
                    'menu' => 'فتح القائمة',
                    'search' => 'البحث في الفعاليات',
                    'search-text' => 'ابحث في الفعاليات…',
                ],
            ],
            'footer' => [
                'footer-content' => 'روابط التذييل',
                'footer-text' => '© :current_year — بوابة الطلاب. جميع الحقوق محفوظة.',
                'link-home' => 'الرئيسية',
                'link-events' => 'الفعاليات',
                'link-student-login' => 'تسجيل دخول الطلاب',
                'link-student-logout' => 'تسجيل الخروج',
            ],
            'flash-group' => [
                'close' => 'إغلاق الإشعار',
            ],
            'services' => [
                'calendar-title' => 'تقويم الفعاليات',
                'calendar-desc' => 'اطلع على المواعيد وخطط مسبقاً.',
                'updates-title' => 'ابقَ على اطلاع',
                'updates-desc' => 'التفاصيل في مكان واحد.',
                'campus-title' => 'الحرم والمواقع',
                'campus-desc' => 'اعرف أين تقام الأنشطة.',
            ],
        ],
    ],

    'events' => [
        'index' => [
            'title' => 'الفعاليات',
            'heading' => 'فعاليات للطلاب',
            'subheading' => 'استعرض الفعاليات المنشورة التي يمكنك حضورها أو متابعتها.',
            'empty' => 'لا توجد فعاليات منشورة حالياً. تعرّض لاحقاً.',
        ],
        'subscribe' => [
            'success' => 'تم تسجيلك في هذه الفعالية.',
            'already' => 'أنت مسجّل مسبقاً في هذه الفعالية.',
            'no-seats' => 'لا توجد مقاعد متاحة لهذه الفعالية.',
            'not-available' => 'هذه الفعالية غير مفتوحة للتسجيل حالياً.',
            'event-unavailable' => 'هذه الفعالية غير متاحة.',
            'event-not-found' => 'الفعالية غير موجودة.',
            'login-to-continue' => 'سجّل دخولك بحساب الطالب لإكمال التسجيل في الفعالية.',
        ],
        'card' => [
            'no-image' => 'بدون صورة',
            'view' => 'التفاصيل',
            'details' => 'عرض التفاصيل',
            'subscribe' => 'اشتراك',
            'subscribe-unavailable' => 'غير متاح',
            'subscribe-registered' => 'مسجّل',
            'date-format' => 'j F Y',
            'modal-title' => 'تأكيد الاشتراك',
            'modal-body-before' => 'أنت على وشك المتابعة لفعالية ',
            'modal-body-after' => '. سيتم نقلك إلى صفحة الفعالية لإكمال الخطوات التالية.',
            'modal-confirm' => 'تأكيد',
            'modal-confirm-login' => 'تسجيل الدخول للمتابعة',
            'modal-cancel' => 'إلغاء',
            'modal-close' => 'إغلاق النافذة',
        ],
        'seats' => [
            'unlimited' => 'سعة مفتوحة',
            'sold-out' => 'مكتمل العدد',
            'remaining' => ':count مقعداً متاحاً',
            'ended' => 'انتهى التسجيل',
            'unavailable' => 'غير متوفرة',
            'open-registrations' => 'مفتوحة للتسجيل',
        ],
        'show' => [
            'back' => 'كل الفعاليات',
            'details' => 'التفاصيل',
            'related' => 'فعاليات ذات صلة',
            'suggestions-title' => 'قد يعجبك أيضاً',
            'suggestions-subtitle' => 'فعاليات مشابهة نقترح عليك استكشافها.',
            'seats-heading' => 'التوفر',
            'breadcrumb-nav' => 'مسار التنقل',
            'breadcrumb-home' => 'الرئيسية',
        ],
    ],
];
