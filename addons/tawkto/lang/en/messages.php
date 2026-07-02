<?php

return [
    'permissions' => [
        'tawkto' => 'Manage Tawkto settings',
    ],
    'admin' => [
        'title' => 'Tawkto',
        'subheading' => 'Configure your Tawk.to live chat integration',
        'menu_title' => 'Tawk.to Chat',
        'settings' => [
            'title' => 'Tawk.to Configuration',
            'description' => 'Enter your Tawk.to direct chat link to enable live chat on your client area.',
            'chat_url' => 'Direct Chat Link',
            'chat_url_help' => 'Paste your Tawk.to direct chat link, e.g. https://tawk.to/chat/xxxxxxxxxxxx/xxxxxxxxx. Leave empty and save to disable the widget.',
            'saved' => 'Tawk.to settings have been saved successfully.',
        ],
    ],
];
