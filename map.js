var mymap = L.map('map').setView([14, 100.192106], 14);
var latlngStore = []
var shopStore = {
  "type": "FeatureCollection",
  "features": [{
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.08940333532996,
          14.986962426969441
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.1046475104655,
          14.98256844093953
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.08473173327286,
          14.97033605899837
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.06948755813744,
          14.985299848268696
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.0633407133239,
          14.957865436254295
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.09395200049102,
          14.959765768471058
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.08903452463971,
          14.999312607197268
        ],
        "type": "Point"
      }
    },
    {
      "type": "Feature",
      "properties": {},
      "geometry": {
        "coordinates": [
          102.08496807118382,
          14.99578572342024
        ],
        "type": "Point"
      }
    }
  ]
}

// นำทาง
var line = {
  "type": "FeatureCollection",
  "features": [{
    "type": "Feature",
    "properties": {},
    "geometry": {
      "coordinates": [
        [
          100.59958060490595,
          13.941544323004493
        ],
        [
          100.57157489866933,
          13.864519469886702
        ],
        [
          100.5217844426167,
          13.805600259515572
        ],
        [
          100.45177271088647,
          13.76480231642833
        ],
        [
          100.46729686019319,
          13.70904960912084
        ],
        [
          100.45018226190194,
          13.696956910658372
        ]
      ],
      "type": "LineString"
    }
  }]
}
// 
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(mymap);

var iconMarker = L.icon({
  iconUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQikzl1oLBzntYoc6eYvP3WNmRv-LwNwEYI-aeyeSz0rYjfxcJfrpQM3Vthw85FTWBHElo&usqp=CAU',
  iconSize: [20, 20]
})

L.marker([14, 100.192106], {
  icon: iconMarker
}).addTo(mymap)

function onClickForMap(e) {
  latlngStore = [e.latlng.lat, e.latlng.lng]
  L.marker([e.latlng.lat, e.latlng.lng]).addTo(mymap)
  console.log('first', latlngStore)
  // [14,100]
  document.getElementById('show_latlng').textContent = 'test'
}

async function showPosition(position) {
  latlngStore = [position.coords.latitude, position.coords.longitude]
  mymap.setView([position.coords.latitude, position.coords.longitude], 20)
  L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap)
  // navigat to google map
  // window.location.href = 'https://maps.google.com/?q=34.059808,-118.368152'
  // L.Routing.control({
  //   waypoints: [
  //     L.latLng(14, 100.192106),

  //     L.latLng(position.coords.latitude, position.coords.longitude)
  //   ],
  //   routeWhileDragging: false
  // }).addTo(mymap);

  // const response = await fetch('http://router.project-osrm.org/route/v1/driving/14.00,100.192106;' + position.coords.latitude + ',' + position.coords.longitude + ';?overview=false')
  // const route = await response.json()
  // console.log('route', route)
  // mymap.setView([position.coords.latitude, position.coords.longitude], 20)
  // L.marker([position.coords.latitude, position.coords.longitude]).addTo(mymap)
}

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

var myLocation = {
  "type": "Feature",
  "properties": {},
  "geometry": {
    "coordinates": [
      102.07739762506395,
      14.994659633165298
    ],
    "type": "Point"
  }
}

// กรองพื้นที่ที่ใกล้เรา
var radius = 2;
var options = {
  steps: 10,
  units: 'kilometers',
  properties: {
    foo: 'bar'
  }
};
var circle = turf.circle(myLocation, radius, options);

var ptsWithin = turf.pointsWithinPolygon(shopStore, circle);
// console.log('circle', circle)
L.geoJSON(ptsWithin).addTo(mymap)

mymap.on('click', onClickForMap)