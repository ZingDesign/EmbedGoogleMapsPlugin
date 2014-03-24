/**
 * Created by Sam on 24/03/14.
 */

(function() {
    if( document.getElementById('egm-map') ) {
        var geocoder,
            map,
            marker,
            _infoWindowContent = (egmOptions.infoWindowContent === "") ? 'We are here' : egmOptions.infoWindowContent;

        var infowindow = new google.maps.InfoWindow({
            content: _infoWindowContent
        });

        function initialize() {
            geocoder = new google.maps.Geocoder();

            var companyLat = -41.2831354,
                companyLng = 174.7748761,
                companyLatLng = google.maps.LatLng( companyLat, companyLng ),
                mapOptions = {
                    zoom: 14,
                    center: companyLatLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: egmOptions.style ? JSON.parse(egmOptions.style) : []
                };

            map = new google.maps.Map(document.getElementById("egm-map"), mapOptions);
        }

        function codeAddress() {
            var address = egmOptions.address;
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });

                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.open(map,marker);
                    });
                } else {
                    console.log("Geocode was not successful for the following reason: " + status);
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
        google.maps.event.addDomListener(window, 'load', codeAddress);
    }

})();