function inicializarMapa(lat, lng) {
    var map = new google.maps.Map(document.getElementById("mapa"), {
        center: { lat: lat, lng: lng },
        zoom: 15,
    });

    new google.maps.Marker({
        position: { lat: lat, lng: lng },
        map: map,
    });
}
