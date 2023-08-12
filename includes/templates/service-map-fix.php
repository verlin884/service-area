<?php
$title          = carbon_get_theme_option('sva_title');
$description    = carbon_get_theme_option('sva_description');
$zoneUrl        = carbon_get_theme_option('sva_zone_url');
$inside_url     = carbon_get_theme_option('sva_inside_url');
$outside_url    = carbon_get_theme_option('sva_outside_url');
// $apiKey         = carbon_get_theme_option('sva_google_api');
$apiKey         = '';
?>

<section class="sva_container">
    <div class="sva_header_content">
        <h1><?= $title; ?> </h1>
        <p><?= $description; ?></p>
    </div>
    <div class="sva_kml_container">
        <form action="" class="sva_form">
            <input type="text" placeholder="Search Address" class="sva_address_input">
            <button type="submit">Search</button>
        </form>
        <div class="sva_map_container">
            <div id="sva_map"></div>
            <div id="sva_capture"></div>
        </div>
    </div>
</section>

<script>
    var map;
    var src = 'https://desapitra.id/Melbourne-VIC.kml';
    var latlng = {
        lat: -122.0914977709329,
        lng: 37.42390182131783
    };

    function initMap() {
        map = new google.maps.Map(document.getElementById('sva_map'), {
            center: new google.maps.LatLng(-37.8136, 144.9631),
            zoom: 8,
            mapTypeId: 'terrain'
        });

        var kmlLayer = new google.maps.KmlLayer(src, {
            suppressInfoWindows: false,
            preserveViewport: false,
            map: map
        });
    }
</script>

<script async src="https://maps.googleapis.com/maps/api/js?key=<?= $apiKey ?>&callback=initMap"></script>