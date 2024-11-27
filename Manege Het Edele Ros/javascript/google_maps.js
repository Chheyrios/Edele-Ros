function initMap() {
  
    var location = { lat: 51.596214018705645, lng: 5.221237670886564 };

 
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: location
    });

    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
  }