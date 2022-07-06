<?php
    $config = array(
        'error-doc' => [
            '403' => '/chan/site/errors/403.php',
            '404' => '/chan/site/errors/404.php'
        ],
        'login-fields' => [
            'user' => 'login-user-name',
            'pass' => 'login-user-password'
        ],
        'register-fields' => [
            'user'  => 'register-user-name',
            'email' => 'register-user-email',
            'pass'  => 'register-user-password',
            'pass-confirm' => 'register-user-confirm-password'
        ],
        'reset-pass-fields' => [
            'email' => 'user-reset-email'
        ],
        'password-min-length' => 8,
        'headers' => [
            'nonce-1' => "Content-Security-Policy: default-src 'self'; font-src *; img-src * data:; script-src 'self' 'nonce-{}'; style-src 'self' 'nonce-{}';"
        ],
        'lang' => [
            'bg' => 'bg',
            'default' => 'en'
        ],
        'db' => [
            'tables' => [
                'users' => [
                    'id',
                    'username',
                    'display_name',
                    'email',
                    'password',
                    'picture',
                    'cover',
                    'level',
                    'num_posts'
                ]
            ]
        ]
    );
?>