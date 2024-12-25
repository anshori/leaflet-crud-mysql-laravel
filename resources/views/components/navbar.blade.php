<nav class="navbar navbar-expand-lg bg-dark border-bottom border-body fixed-top" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="bi bi-pin-map-fill"></i> {{ $title }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        @if ($page !== "map")
        <li class="nav-item">
          <a class="nav-link" href="{{ route('/') }}"><i class="bi bi-globe-asia-australia"></i> Home</a>
        </li>
        @endif
				<li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-stack"></i> GeoJSON API
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('geojson.points') }}" target="_blank"><i class="bi bi-geo-alt-fill"></i> Points</a></li>
            <li><a class="dropdown-item" href="{{ route('geojson.polylines') }}" target="_blank"><i class="bi bi-dash-lg"></i> Polylines</a></li>
            <li><a class="dropdown-item" href="{{ route('geojson.polygons') }}" target="_blank"><i class="bi bi-pentagon"></i> Polygons</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i class="bi bi-info-circle-fill"></i> Info</a>
        </li>
      </ul>
    </div>
  </div>
</nav>