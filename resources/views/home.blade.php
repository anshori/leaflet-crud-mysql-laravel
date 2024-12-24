@extends('layouts.template')

@section('content')
<div id="map"></div>
@endsection

@section('css')
<style>
  #map {
    margin-top: 55px;
    height: calc(100vh - 55px);
    width: 100%;
  }
</style>
@endsection

@section('script')
<script>
  // init map
  var map = L.map('map').setView([-7.7911905,110.3708839], 14);

  // init basemap
  var basemap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '<a href="https://unsorry.net" target="_blank">unsorry@2024</a>',
  });

  // add basemap to map
  basemap.addTo(map);

  // scale bar
  L.control.scale({
    position: 'bottomleft',
    metric: true,
    imperial: false,
  }).addTo(map);

  /* Digitize Function */
  var drawnItems = new L.FeatureGroup();
  map.addLayer(drawnItems);

  var drawControl = new L.Control.Draw({
    draw: {
      position: 'topleft',
      polyline: true,
      polygon: true,
      rectangle: true,
      circle: false,
      marker: true,
      circlemarker: false
    },
    edit: false
  });

  map.addControl(drawControl);

  map.on('draw:created', function(e) {
    var type = e.layerType,
      layer = e.layer;

      console.log(type);

    var drawnJSONObject = layer.toGeoJSON();
		var objectGeometry =  Terraformer.geojsonToWKT(drawnJSONObject.geometry);

    if (type === 'polyline') {
      $('#geom_polyline').empty();
      console.log(objectGeometry);
      $('#geom_polyline').val(objectGeometry);
      $('#createpolylineModal').modal('show');

      // modal dismiss reload
      $('#createpolylineModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    } else if (type === 'polygon' || type === 'rectangle') {
      $('#geom_polygon').empty();
      console.log(objectGeometry);
      $('#geom_polygon').val(objectGeometry);
      $('#createpolygonModal').modal('show');

      // modal dismiss reload
      $('#createpolygonModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    } else if (type === 'marker') {
      $('#geom_point').empty();
      console.log(objectGeometry);
      $('#geom_point').val(objectGeometry);
      $('#createpointModal').modal('show');

      // modal dismiss reload
      $('#createpointModal').on('hidden.bs.modal', function() {
        location.reload();
      });
    } else {
      console.log('__undefined__');
    }

    drawnItems.addLayer(layer);
  });

  /* GeoJSON Point */
  var point = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
			var editUrl = "{{ route('point.edit', ':id') }}";
			editUrl = editUrl.replace(':id', feature.properties.id);

			var deleteUrl = "{{ route('point.destroy', ':id') }}";
			deleteUrl = deleteUrl.replace(':id', feature.properties.id);

      var popupContent = "<table class='table table-sm'>" +
					"<tr><th>Name</th><td>:</td><td>" + feature.properties.name + "</td></tr>" +
					"<tr><th>Description</th><td>:</td><td>" + feature.properties.description + "</td></tr>" +
				"</table>" +
        "<div class='d-flex flex-row'>" +
        "<a href='" + editUrl + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='" + deleteUrl + "' method='Post'>" +
        '{{ csrf_field() }}' +
        '{{ method_field("DELETE") }}' +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure you want to delete point " + feature.properties.name + "?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form>" +
        "</div>";

      layer.on({
        click: function(e) {
          point.bindPopup(popupContent);
        },
        mouseover: function(e) {
          point.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("{{ route('geojson.points') }}", function(data) {
    point.addData(data);
    map.addLayer(point);
  });

  /* GeoJSON Polyline */
  var polyline = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
			var editUrl = "{{ route('polyline.edit', ':id') }}";
			editUrl = editUrl.replace(':id', feature.properties.id);

			var deleteUrl = "{{ route('polyline.destroy', ':id') }}";
			deleteUrl = deleteUrl.replace(':id', feature.properties.id);

      var popupContent = "<table class='table table-sm'>" +
					"<tr><th>Name</th><td>:</td><td>" + feature.properties.name + "</td></tr>" +
					"<tr><th>Description</th><td>:</td><td>" + feature.properties.description + "</td></tr>" +
					"<tr><th>Length</th><td>:</td><td>" + feature.properties.length.toFixed(2) + " m</td></tr>" +
				"</table>" +
        "<div class='d-flex flex-row'>" +
        "<a href='" + editUrl + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='" + deleteUrl + "' method='Post'>" +
        '{{ csrf_field() }}' +
        '{{ method_field("DELETE") }}' +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure you want to delete polygon " + feature.properties.name + "?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form>" +
        "</div>";

      layer.on({
        click: function(e) {
          polyline.bindPopup(popupContent);
        },
        mouseover: function(e) {
          polyline.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("{{ route('geojson.polylines') }}", function(data) {
    polyline.addData(data);
    map.addLayer(polyline);
  });

  /* GeoJSON Polygon */
  var polygon = L.geoJson(null, {
    onEachFeature: function(feature, layer) {
			var editUrl = "{{ route('polygon.edit', ':id') }}";
			editUrl = editUrl.replace(':id', feature.properties.id);

			var deleteUrl = "{{ route('polygon.destroy', ':id') }}";
			deleteUrl = deleteUrl.replace(':id', feature.properties.id);

      var popupContent = "<table class='table table-sm'>" +
					"<tr><th>Name</th><td>:</td><td>" + feature.properties.name + "</td></tr>" +
					"<tr><th>Description</th><td>:</td><td>" + feature.properties.description + "</td></tr>" +
					"<tr><th>Area</th><td>:</td><td>" + feature.properties.area.toFixed(2) + " m<sup>2</sup></td></tr>" +
				"</table>" +
        "<div class='d-flex flex-row'>" +
        "<a href='" + editUrl + "' class='btn btn-sm btn-warning text-dark me-2'><i class='bi bi-pencil-square'></i></a>" +
        "<form action='" + deleteUrl + "' method='Post'>" +
        '{{ csrf_field() }}' +
        '{{ method_field("DELETE") }}' +
        "<button type='submit' class='btn btn-sm btn-danger text-light' onclick='return confirm(`Are you sure you want to delete polygon " + feature.properties.name + "?`)'><i class='bi bi-trash-fill'></i></button>" +
        "</form>" +
        "</div>";

      layer.on({
        click: function(e) {
          polygon.bindPopup(popupContent);
        },
        mouseover: function(e) {
          polygon.bindTooltip(feature.properties.name);
        },
      });
    },
  });
  $.getJSON("{{ route('geojson.polygons') }}", function(data) {
    polygon.addData(data);
    map.addLayer(polygon);
  });

  // layer control
  var layers = {
    "Point": point,
    "Polyline": polyline,
    "Polygon": polygon,
  };

  L.control.layers(null, layers, {collapsed: false}).addTo(map);
</script>
@endsection