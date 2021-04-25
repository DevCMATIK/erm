@extends('layouts.app-blank')
@section('page-title','Map Test')
@section('page-icon','key')
@section('page-content')
    <div class="row px-2 mb-2">
        <div class="col" id="map" style="min-height: 600px;">

        </div>
    </div>
@endsection
@section('maps-content')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANLIUC0DU8-V7nWP7CvP76Bp67MQDxTZY&callback=initMap&libraries=visualization&v=weekly"
        defer
    ></script>
    <script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>

    <script>

        let map;
        function initMap() {

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: { lat: -33.973347542860296, lng: -71.65837822592083},
                mapTypeId: 'hybrid',
            });

            const image =
                "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";

            var markers = [];
            var data = {!! json_encode($sub_zones->toArray(),JSON_NUMERIC_CHECK) !!};

            data.forEach(function(item, i) {
                var infoWindow = new google.maps.InfoWindow({});
                var marker = new google.maps.Marker({
                    map: map,
                    position: new google.maps.LatLng(item.lat,item.lng),
                });
                markers.push(new google.maps.LatLng(item.lat,item.lng));

                google.maps.event.addListener(marker, 'mouseover', function () {
                    infoWindow.setContent('<div><strong>' + item.name + '</strong><br>');
                    infoWindow.open(map, marker); // open at marker's location
                });

                google.maps.event.addListener(marker, 'mouseout', function () {
                    infoWindow.close();
                });
            })

            var lines = {!! json_encode($lines,JSON_NUMERIC_CHECK) !!};

            lines.forEach(function(item, i) {
                var path = [];
                path.push(new google.maps.LatLng(item.p_one_lat,item.p_one_lng));
                path.push(new google.maps.LatLng(item.p_two_lat,item.p_two_lng));
                var linePath = new google.maps.Polyline({
                    path: path,
                    geodesic: true,
                    strokeColor: item.color,
                    strokeWeight : 10,
                    map : map
                });
            })



            //var markerCluster = new MarkerClusterer(map, markers);


        }



        function getZonesData()
        {
            var markers = [];

            return markers;
        }

    </script>

@endsection
