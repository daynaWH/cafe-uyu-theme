window.initGoogleMap = function () {
    (function ($) {
        function render_map($el) {
            var $markers = $el.find(".marker");

            var args = {
                zoom: 16,
                center: new google.maps.LatLng(0, 0),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            };

            var map = new google.maps.Map($el[0], args);
            map.markers = [];

            $markers.each(function () {
                var lat = $(this).data("lat");
                var lng = $(this).data("lng");
                var latLng = new google.maps.LatLng(lat, lng);

                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                });

                map.markers.push(marker);
            });

            center_map(map);
        }

        function center_map(map) {
            var bounds = new google.maps.LatLngBounds();

            $.each(map.markers, function (i, marker) {
                bounds.extend(marker.position);
            });

            if (map.markers.length === 1) {
                map.setCenter(bounds.getCenter());
                map.setZoom(16);
            } else {
                map.fitBounds(bounds);
            }
        }

        // Called when API is loaded
        $(function () {
            $(".acf-map").each(function () {
                render_map($(this));
            });
        });
    })(jQuery);
};

if (typeof google !== "undefined" && google.maps) {
    window.initGoogleMap();
}
