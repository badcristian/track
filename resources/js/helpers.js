
export const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

export const deleteProperties = (object) => {
    for (let property in object) {
        delete object[property]
    }
}

export let setTrueOrDelete = (object, property) => {
    if (object[property] === undefined) {
        object[property] = true
        console.log('uuu')
    } else {
        delete object[property]
    }
}

export let getDate = (datetime) => {
    return new Date(datetime).toLocaleDateString('en-US', {
        year: 'numeric', month: '2-digit', day: 'numeric',
    });
}
export const formatTime = (date) => {
    return new Date(date).toLocaleString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true
    });
}

export const formatTimeRange = (dateFrom, dateTo) => {

    let firstDate = new Date(dateFrom).toLocaleString('en-US', {
        year: 'numeric', month: 'short', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true
    });

    let secondDate = new Date(dateTo).toLocaleString('en-US', {
        hour: 'numeric', minute: 'numeric', hour12: true
    });

    return `${firstDate} to ${secondDate}`
}

export let rezizeTextArea = (id) => {
    const item = document.getElementById(id);

    item.addEventListener("input", OnInput, false);

    function OnInput() {
        if (this.scrollHeight < 120) {
            this.style.height = 0;
            this.style.height = (this.scrollHeight) + "px";
        }
    }
}


export let scrollToBottom = (id) => {
    const element = document.getElementById(id);
    let scrollHeight = element.scrollHeight;
    let i = element.scrollTop;
    let int = setInterval(function () {
        element.scrollTo(0, i);
        i += 40;
        if (i >= scrollHeight) clearInterval(int);
    }, 1);
}

export const parseAddress = (place) => {

    let address_components = {
        street_address: '',
        city: '',
        state: '',
        country: '',
        zip_code: '',
        lat: '',
        lng: ''
    }

    address_components.lat = place.geometry.location.lat()
    address_components.lng = place.geometry.location.lng()

    for (const component of place.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
            case "street_number": {
                address_components.street_address = `${component.long_name} ${address_components.street_address}`;
                break;
            }

            case "route": {
                address_components.street_address += component.short_name;
                break;
            }

            case "locality": {
                address_components.city = component.short_name
                break;
            }

            case "administrative_area_level_1": {
                address_components.state = component.short_name
                break;
            }

            case "country": {
                address_components.country = component.short_name
                break;
            }

            case "postal_code": {
                address_components.zip_code = component.long_name
                break;
            }
        }
    }

    return address_components
}
