<?php
$title          = carbon_get_theme_option('sva_title');
$description    = carbon_get_theme_option('sva_description');
$kml_filename   = carbon_get_theme_option('sva_zone_url');
$inside_url     = carbon_get_theme_option('sva_inside_url');
$outside_url    = carbon_get_theme_option('sva_outside_url');
$apiKey         = carbon_get_theme_option('sva_google_api');
$apiKey         = '';
// Enter the name of the KML file here.
$xml = simplexml_load_file($kml_filename);
$xmllink = $xml->Document->NetworkLink->Link->href;

$sxml = simplexml_load_file($xmllink);

$coor = $sxml->Document->Placemark->Polygon->outerBoundaryIs->LinearRing->coordinates;

foreach ($coor as $dt) {
    $latlng = $dt;
}

$newArr = explode(",0", $latlng);
$polygonCoordinates = array();
foreach ($newArr as $arr) {
    $arr = str_replace(' ', '', $arr);
    list($k, $v) = explode(',', $arr);
    if ($v != null) {
        $result['lat'] = $v;
        $result['lng'] = $k;
        array_push($polygonCoordinates, $result);
    }
}

$polygonCoordinates = json_encode($polygonCoordinates);
$polygonCoordinates = str_replace("\\n", "", $polygonCoordinates);


?>

<section class="gmap_container">
    <div class="sva_map_container">
        <input id="pac-input" class="controls" type="text" placeholder="Search Box" />
        <div id="sva_map"></div>
        <div id="sva_capture"></div>
    </div>
</section>

<script>
    var map;
    var src = "<?= $xmllink ?>";
    let markers = [];

    function initMap() {
        // create polygon start
        const polygon = <?= $polygonCoordinates ?>;
        const polygonMapped = polygon.map(elem => ({
            lat: Number(elem.lat),
            lng: Number(elem.lng)
        }));

        const map = new google.maps.Map(document.getElementById("sva_map"), {
            zoom: 15,
            center: polygonMapped[0],
            mapTypeId: "terrain",
        });

        const kmlPolygon = new google.maps.Polygon({
            paths: polygonMapped,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });

        kmlPolygon.setMap(map);
        // create polygon end

        // Create the search box and link it to the UI element.
        const input = document.getElementById("pac-input");
        const searchBox = new google.maps.places.SearchBox(input);

        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        // Bias the SearchBox results towards current map's viewport.
        map.addListener("bounds_changed", () => {
            searchBox.setBounds(map.getBounds());
        });

        let markers = [];

        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener("places_changed", () => {
            const places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach((marker) => {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            const bounds = new google.maps.LatLngBounds();

            places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                const placeLocation = place.geometry.location;
                console.log(placeLocation);

                // redirect

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                // Create a marker for each place.
                markers.push(
                    new google.maps.Marker({
                        map,
                        icon,
                        title: place.name,
                        position: place.geometry.location,
                    }),
                );
                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }

                // if (google.maps.geometry.poly.containsLocation(placeLocation, polygonMapped)) {
                //     console.log("stu");
                // } else {
                //     console.log("stum 12");
                // }
            });
            map.fitBounds(bounds);
        });
    }
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDW3k7mWI6cEN5Y5oim6U1kufOSfO1tnNQ&callback=initMap&libraries=places&v=weekly">
</script>