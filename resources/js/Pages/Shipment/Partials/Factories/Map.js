import {watch} from "vue";

export async function initMap(htmlElem, stops, driver_locations) {

    const {Map, InfoWindow} = await google.maps.importLibrary("maps");
    const {LatLng} = await google.maps.importLibrary("core")
    const {DirectionsRenderer, DirectionsService} = await google.maps.importLibrary("routes")
    const {Marker, Animation} = await google.maps.importLibrary("marker")

    const map = new Map(htmlElem.value, {
            center: {lat: 39.8097343, lng: -98.5556199},
            zoom: 4.3,
            mapId: '9e749c4636f1e600',
            disableDefaultUI: true
        }
    );

    let stopsMarkers = []
    let driverMarker

    const directionsService = new DirectionsService

    const routeRenderer = directionsRenderer(map, DirectionsRenderer, '#8f2221', 6, 1)
    const driverRenderer = directionsRenderer(map, DirectionsRenderer, '#fb923c', 3, 2)

    watch(stops, (newStops, oldStops) => {

            deleteMarkers(stopsMarkers)

            if (!newStops.length) {
                return
            }

            calcRoute(newStops, directionsService, routeRenderer, LatLng)
            stopsMarkers = addMarkers(newStops, map, Marker, LatLng, Animation, InfoWindow, null, 2)

        }, {immediate: true}
    )

    watch(driver_locations, (newLocations, oldLocations) => {

            deleteMarkers(driverMarker)

            if (!newLocations.length) {
                return
            }

            calcRoute(newLocations, directionsService, driverRenderer, LatLng)

            const lastLocation = [newLocations.pop()]
            let icon = "http://track.test/truckicon2.png"
            driverMarker = addMarkers(lastLocation, map, Marker, LatLng, Animation, InfoWindow, icon, 3)

        }, {immediate: true}
    )

}

function directionsRenderer(map, DirectionsRenderer, strokeColor, strokeWeight, zIndex) {
    return new DirectionsRenderer({
        map: map,
        preserveViewport: true,
        suppressMarkers: true,
        polylineOptions: {
            strokeColor: strokeColor,
            strokeWeight: strokeWeight,
            zIndex: zIndex
        },
    })
}

function calcRoute(stops, directionsService, directionsRenderer, LatLng) {

    if (!stops || !stops.length) {
        return
    }

    if (stops.length < 2) {
        directionsRenderer.setDirections({routes: []});
        return
    }

    const parsedStops = getParsedStops(stops, LatLng)

    const request = {
        origin: parsedStops.first,
        destination: parsedStops.last,
        waypoints: parsedStops.middle,
        travelMode: 'DRIVING'
    };

    directionsService.route(request, function (result, status) {
        if (status == 'OK') {
            directionsRenderer.setDirections(result);
        }
    });

}

function getParsedStops(stops, LatLng) {
    let middle = []
    let first = null
    let last = null

    if (stops.length > 1) {
        first = new LatLng(stops[0].lat, stops[0].lng);
        last = new LatLng(stops[stops.length - 1].lat, stops[stops.length - 1].lng);
    }

    if (stops.length > 2) {
        for (let i = 1; i < stops.length - 1; i++) {
            middle.push({
                location: new LatLng(stops[i].lat, stops[i].lng),
                stopover: true,
            })
        }
    }

    return {first, last, middle}
}

function addMarkers(stops, map, marker, LatLng, Animation, InfoWindow, icon, zIndex) {

    if (!stops || !stops.length) {
        return
    }

    const infoWindow = addInfoWindow(map, InfoWindow)

    let array = []

    stops.forEach((stop, index) => {

        let newMarker = renderMarker(map, marker, LatLng, Animation, stop, index, icon, zIndex)

        let content = `<div class="text-black font-bold">
                            <div>${stop.type}</div>
                            <div>${stop.name}</div>
                            <div>${stop.lat}</div>
                          </div>`

        newMarker.addListener("click", () => {
            infoWindow.close();
            infoWindow.setContent(content);
            infoWindow.open(newMarker.map, newMarker);
        });

        array.push(newMarker)
    })

    return array
}

function renderMarker(map, marker, LatLng, Animation, stop, index, icon, zIndex) {
    return new marker({
        position: new LatLng(stop.lat, stop.lng),
        map: map,
        label: {
            text: icon ? ' ' : `${index + 1}`,
            fontFamily: "Calibri",
            color: '#000000',
            fontSize: '16px',
            fontWeight: '600',
            zIndex: zIndex ?? 1
        },
        title: "Material Icon Font Marker",
        animation: Animation.DROP,
        icon: icon,
        optimized: false,
        zIndex: zIndex ?? 1
    });
}

function addInfoWindow(map, InfoWindow, content) {
    const infoWindow = new InfoWindow

    infoWindow.setContent(content ?? 'no content  provided');

    map.addListener("click", () => {
        infoWindow.close();
    });

    return infoWindow
}

function deleteMarkers(markers) {

    if (!markers || !markers.length) {
        return
    }

    markers.forEach((marker) => {
        marker.setMap(null)
    })
}
