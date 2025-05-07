<?php

namespace People\Providers;

class RegisterAssets implements Provider
{
    public function __construct()
    {
        add_action('init', [$this, 'enqueue']);
    }

    public function register()
    {
        //
    }

    public function enqueue() {

        wp_enqueue_script('people.js', get_template_directory_uri() . '/modules/people/public/scripts/people.js', ['jquery'], null, true);
    }
}