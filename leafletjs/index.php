<?php
	// https://www.youtube.com/watch?v=NyjMmNCtKf4
	// https://www.liedman.net/leaflet-routing-machine/#getting-started
?>

<!DOCTYPE_html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE-edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>e-Locate: Leaflet.js & Openstreetmap</title>

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
		<!-- Make sure you put this AFTER Leaflet's CSS -->
		<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

		<style>
			#map { height: 720px; }
		</style>
	</head>

	<body>
		<h1 style="color:blue; font-weight:bold;">Leaflet.js & Openstreetmap</h1>
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

		let cli_marker, cli_circle, cli_zoomed;

		function success(pos) {
			let cli_latitude = pos.coords.latitude;
			let cli_longitude = pos.coords.longitude;
			let cli_accuracy = pos.coords.accuracy;

			if (cli_marker) {
				map.removeLayer(cli_marker);
				map.removeLayer(cli_circle);
			}

			cli_marker = L.marker([cli_latitude, cli_longitude]).addTo(map);
			cli_circle = L.circle([cli_latitude, cli_longitude], {radius: cli_accuracy}).addTo(map);

			if (!cli_zoomed) {
				cli_zoomed = map.fitBounds(cli_circle.getBounds());
			}

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
	</script>
</html>
