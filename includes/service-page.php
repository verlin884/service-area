<?php

add_shortcode('service-area', 'sva_page');
function sva_page()
{
    include PLUGIN_PATH . 'includes/templates/service-map.php';
}

add_action('wp_enqueue_scripts', 'sva_assets');
function sva_assets()
{
    global $version;
    wp_enqueue_style('styless', PLUGIN_URL_ASSETS . 'css/sva_style.css' . '', array(), null);
    wp_enqueue_style('responsive', PLUGIN_URL_ASSETS . 'css/sva_responsive.css' . '', array(), null);
    wp_enqueue_script('script', PLUGIN_URL_ASSETS . 'js/sva_script.js' . $version, array('jquery'), null, true);
}
