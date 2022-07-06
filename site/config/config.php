<?php
    $config = array(
        'error-doc' => [
            '403' => '/chan/site/errors/403.php',
            '404' => '/chan/site/errors/404.php'
        ],
        'login-fields' => [
            'user' => 'login-username-field',
            'pass' => 'login-password-field'
        ],
        'register-fields' => [
            'user'  => 'register-username-field',
            'email' => 'register-email-field',
            'pass'  => 'register-password-field',
            'pass-confirm' => 'register-password-confirmation-field'
        ],
        'reset-pass-fields' => [
            'email' => 'reset-pass-field'
        ],
        'password-min-length' => 10,
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