<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AuthViews extends BaseConfig
{
    public array $views = [
        'login'                       => 'auth/login',
        'register'                    => 'auth/register',
        'forgot-password'             => 'auth/forgot_password', // Pastikan nama file .php kau betul
        'reset-password'              => 'auth/reset_password',
        'email_2fa_verify'            => 'auth/email_2fa_verify',
        'email_activate_email'        => 'auth/email_activate_email',
        'email_activate_show'         => 'auth/email_activate_show',
        'magic-link-login'            => 'auth/magic_link_form',
        'magic-link-message'          => 'auth/magic_link_message',
        'magic-link-email'            => 'auth/magic_link_email',
    ];
}