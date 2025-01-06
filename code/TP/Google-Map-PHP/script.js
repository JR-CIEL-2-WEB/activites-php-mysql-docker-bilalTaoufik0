let map, polyline;

function initMap() {
    const defaultLatLng = { lat: 48.8566, lng: 2.3522 };

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: defaultLatLng
    });

    loadCourse(1);

    document.getElementById('courseSelect').addEventListener('change', (event) => {
        loadCourse(event.target.value);
    });
}

function loadCourse(courseId) {
    fetch(`courses.php?id=${courseId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Échec de la récupération des données du cours : ${response.status}`);
            }
            return response.json();
        })
        .then(course => {
            console.log("Course selectioner : ", course.name);

            const path = [];

            if (polyline) {
                polyline.setMap(null);
            }

            for (let i = 0; i < course.markers.length; i++) {
                const marker = course.markers[i];
                const position = { lat: marker.lat, lng: marker.lng };

                new google.maps.Marker({
                    position: position,
                    map: map
                });

                path.push(position);
            }

            if (path.length > 0) {
                map.setCenter(path[0]);
            }

            polyline = new google.maps.Polyline({
                path: path,
                geodesic: true,
                strokeColor: "#FF0000",
                strokeOpacity: 1.0,
                strokeWeight: 2
            });

            polyline.setMap(map);
        })
        
}
