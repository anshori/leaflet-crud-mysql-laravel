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
    var map = L.map('map').setView([-7.7911905, 110.3708839], 14);

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
      draw: false,
      edit: {
        featureGroup: drawnItems,
        edit: true,
        remove: false
      }
    });

    map.addControl(drawControl);

    map.on('draw:edited', function(e) {
      var layers = e.layers;

      layers.eachLayer(function(layer) {
        var drawnJSONObject = layer.toGeoJSON();
        var objectGeometry = Terraformer.geojsonToWKT(drawnJSONObject.geometry);

        // layer type
        var type = drawnJSONObject.geometry.type;
        console.log(type);

        // layer properties
        var properties = drawnJSONObject.properties;

        if (type === 'LineString') {
          $('#name').val(properties.name);
          $('#description').val(properties.description);
          $('#geom').empty();
          $('#geom').val(objectGeometry);
          $('#editpolylineModal').modal('show');

          // modal dismiss reload
          $('#editpolylineModal').on('hidden.bs.modal', function() {
            location.reload();
          });
        } else if (type === 'Polygon') {
          console.log(objectGeometry);
          $('#name').val(properties.name);
          $('#description').val(properties.description);
          $('#geom').empty();
          $('#geom').val(objectGeometry);
          $('#editpolygonModal').modal('show');

          // modal dismiss reload
          $('#editpolygonModal').on('hidden.bs.modal', function() {
            location.reload();
          });
        } else if (type === 'Point') {
          $('#name').val(properties.name);
          $('#description').val(properties.description);
          $('#geom').empty();
          $('#geom').val(objectGeometry);
          $('#editpointModal').modal('show');

          // modal dismiss reload
          $('#editpointModal').on('hidden.bs.modal', function() {
            location.reload();
          });
        } else {
          console.log('__undefined__');
        }

        drawnItems.addLayer(layer);
      });
    });

    @if ($page == 'edit-point')
      /* GeoJSON Point */
      var point = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
          drawnItems.addLayer(layer);

          var geom = Terraformer.geojsonToWKT(feature.geometry);

          layer.on({
            click: function(e) {
              $('#name').val(feature.properties.name);
              $('#description').val(feature.properties.description);
              $('#geom').val(geom);

              $('#editpointModal').modal('show');
            },
            mouseover: function(e) {
              point.bindTooltip(feature.properties.name);
            },
          });
        },
      });
      $.getJSON("{{ route('geojson.point', $id) }}", function(data) {
        point.addData(data);
        map.fitBounds(point.getBounds(), {
          padding: [100, 100]
        });
      });
    @endif

    @if ($page == 'edit-polyline')
      /* GeoJSON Polyline */
      var polyline = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
          drawnItems.addLayer(layer);

          var geom = Terraformer.geojsonToWKT(feature.geometry);

          layer.on({
            click: function(e) {
              $('#name').val(feature.properties.name);
              $('#description').val(feature.properties.description);
              $('#geom').val(geom);

              $('#editpolylineModal').modal('show');
            },
            mouseover: function(e) {
              polyline.bindTooltip(feature.properties.name);
            },
          });
        },
      });
      $.getJSON("{{ route('geojson.polylines') }}", function(data) {
        polyline.addData(data);
        map.fitBounds(polyline.getBounds(), {
          padding: [100, 100]
        });
      });
    @endif

    @if ($page == 'edit-polygon')
      /* GeoJSON Polygon */
      var polygon = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
          drawnItems.addLayer(layer);

          var geom = Terraformer.geojsonToWKT(feature.geometry);

          layer.on({
            click: function(e) {
              $('#name').val(feature.properties.name);
              $('#description').val(feature.properties.description);
              $('#geom').val(geom);

              $('#editpolygonModal').modal('show');
            },
            mouseover: function(e) {
              polygon.bindTooltip(feature.properties.name);
            },
          });
        },
      });
      $.getJSON("{{ route('geojson.polygon', $id) }}", function(data) {
        polygon.addData(data);
        map.fitBounds(polygon.getBounds(), {
          padding: [100, 100]
        });
      });
    @endif
  </script>
@endsection
