export class AutocompleteFactory {

    constructor(AutocompleteService, Geocoder) {
        this.autocomplete = new AutocompleteService;
        this.geocoder = new Geocoder;
    }

    static async init() {
        const {AutocompleteService} = await google.maps.importLibrary("places")
        const {Geocoder} = await google.maps.importLibrary("geocoding")

        return new this(AutocompleteService, Geocoder)
    }

    getPredictions(address) {
        return this.autocomplete.getPlacePredictions({
            input: address,
            componentRestrictions: {country: 'us'},
            language: 'en'
        })
    }

    getPredictionInfo(place_id) {
        return this.geocoder.geocode({placeId: place_id})
    }
}
