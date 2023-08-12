<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('after_setup_theme', 'load_carbon_fields');
add_action('carbon_fields_register_fields', 'create_option_page');

function load_carbon_fields()
{
    \Carbon_Fields\Carbon_Fields::boot();
}

function create_option_page()
{
    Container::make('theme_options', 'Service Area')
        ->set_icon('dashicons-admin-site-alt')
        ->add_fields(array(
            Field::make('text', 'sva_title', 'Title')
                ->set_attribute('placeholder', 'Title'),

            Field::make('textarea', 'sva_description', 'Description')
                ->set_attribute('placeholder', 'Description')
                ->set_rows(3),

            Field::make('text', 'sva_google_api', 'API Key')
                ->set_attribute('placeholder', 'Google Map API Key'),

            Field::make('text', 'sva_zone_url', 'Zone URL')
                ->set_attribute('placeholder', 'Insert the KML link'),

            Field::make('text', 'sva_inside_url', 'Inside radius URL')
                ->set_attribute('placeholder', 'Action URL if the address is inside the radius'),

            Field::make('text', 'sva_outside_url', 'Outside radius URL')
                ->set_attribute('placeholder', 'Action URL if the address is Outside the radius')
        ));
}
