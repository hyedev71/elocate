<?php
	// https://github.com/perliedman/leaflet-routing-machine
?>
<!DOCTYPE_html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>e-Locate: Route Tracking</title>

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
		<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

		<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
		<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

		<style>
			#map { height: 720px; }
		</style>
	</head>

	<body>
		<h1 style="color:blue; font-weight:bold;">Route Tracking</h1>
		<div id="map"></div>
	</body>

	<script>
		var map = L.map('map');
		map.setView([51.505, -0.09], 13);

		L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
			maxZoom: 19,
			attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
		}).addTo(map);

		navigator.geolocation.watchPosition(success, error);

		let cli_latitude, cli_longitude, cli_marker, cli_circle, cli_zoomed;

		function success(pos) {
			cli_latitude = pos.coords.latitude;
			cli_longitude = pos.coords.longitude;
			let cli_accuracy = pos.coords.accuracy;

			cli_marker = L.marker([cli_latitude, cli_longitude]).addTo(map);

			map.setView([cli_latitude, cli_longitude]);
		}

		function error(err) {
			if (err.code === 1) {
				alert('Please allow geolocation access');
				// chrome://flags/#unsafely-treat-insecure-origin-as-secure
			}
			else {
				alert('Cannot get current location');
			}
		}

		// set reachpoint marker
		let rp_lat = 5.330808493753585;
		let rp_lng = 103.14031533203195;
		L.marker([rp_lat, rp_lng]).addTo(map);

		// example of set routing machine
		L.Routing.control({
			waypoints: [
				L.latLng(cli_latitude, cli_longitude),
				L.latLng(rp_lat, rp_lng)
			]
		}).addTo(map);
	</script>
</html>
