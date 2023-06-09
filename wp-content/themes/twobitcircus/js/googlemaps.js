function initMap() {
  let styles = {
    default: null,
    hide: [
      {
        featureType: "poi.business",
        stylers: [{visibility: "off"}]
      },
      {
        featureType: "poi.school",
        stylers: [{visibility: "off"}]
      },
      {
        featureType: "poi.park",
        stylers: [{visibility: "off"}]
      },
      {
        featureType: "poi.attraction",
        stylers: [{visibility: "off"}]
      },
      {
        featureType: "transit",
        elementType: "labels.icon",
        stylers: [{visibility: "off"}]
      }
    ]
  };
  let zoomed = 15;
  if (document.getElementById("main-map") !== null) {
    let map = new google.maps.Map(document.getElementById("main-map"), {
      zoom: zoomed,
      center: new google.maps.LatLng(twobit["lat"], twobit["long"]),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    map.setOptions({styles: styles["hide"]});
    var infowindow = new google.maps.InfoWindow({});
    var marker, i;
    for (i = 0; i < locations.length; i++) {
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        icon: locations[i][4],
        map: map,
        animation: google.maps.Animation.DROP
      });
      google.maps.event.addListener(
        marker,
        "click",
        (function(marker, i) {
          return function() {
            infowindow.setContent(locations[i][0]);
            infowindow.open(map, marker);
          };
        })(marker, i)
      );
    }
  }
}
