// Uselful variables
let max_professors = 0;
let max_students = 0;
let geoJson;
let markers = [];
let last_clicked_feature = false;

// Used for coloring
Number.prototype.clamp = function(min, max) {
    return Math.min(Math.max(this, min), max);
};

// Calculate max_professors and max_students
for (country_code in countries) {
    max_professors = Math.max(max_professors,
                              parseInt(countries[country_code].professor_count));
    max_students = Math.max(max_students,
                            parseInt(countries[country_code].student_count));
}

// Creating the map instance
let mymap = L.map('mapid').setView([48.98, 11.25], 4);

// Setup the label layers
mymap.createPane('labels');
mymap.getPane('labels').style.zIndex = 550;
mymap.getPane('labels').style.pointerEvents = 'none';

// Add tile with map voundaries
L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
    attribution: '©OpenStreetMap, ©CartoDB',
    maxZoom: 18,
    id: 'mapid',
}).addTo(mymap);

// Add tile layer with country names
L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
    attribution: '©OpenStreetMap, ©CartoDB',
    maxZoom: 18,
    id: 'mapid',
    pane: 'labels'
}).addTo(mymap);

function highlight(e) {
    e.target.setStyle({
        fillOpacity: 0.2
    });
    info_numbers.update(countries[e.target.feature.properties.iso_a2.toLocaleLowerCase()]);
}

function popStyle(e) {
    jsonLayer.resetStyle(e.target);
    info_numbers.update();
}

function mouseout(layer){
    // Avoid removing the style from the clicked country
    if (layer.target != last_clicked_feature.target){
        popStyle(layer);
    }
}

// Removes all markers from map and add the ones for the specific country
// here, as a geoJson feature.
function addInstituitonMarkers(layer) {

    markers.forEach( m => m.remove() );

    let currentCountry = layer.target.feature.properties.iso_a2.toLocaleLowerCase();
    markers = Object.values(institutions)
        .filter( ({country_code}) => {return country_code === currentCountry;})
        .map( institution => {
            console.log("LATLONG", [institution.latitude, institution.longitude]);
            let marker = L.marker([institution.latitude, institution.longitude],
                                  {keyboard: false,
                                   title: institution.university});
            let info = `<b>${institution.university}</b></br><ul>` +
                `<li>Professors: ${institution.professor_count}</li>`+
                `<li>Students: ${institution.student_count}</li>`
            '</ul>';

            marker.bindPopup(info);
            marker.addTo(mymap);
            return marker;
        });
}

function zoomAndPin(layer) {
    if (last_clicked_feature) {
        popStyle(last_clicked_feature);
    }
    last_clicked_feature = layer;
    highlight(layer);
    addInstituitonMarkers(layer);
    mymap.fitBounds(layer.target.getBounds());
    layer.target.bringToFront();
}

function onEachFeature(feature, layer) {
    layer.on({
        click: zoomAndPin,
        mouseover: highlight,
        mouseout: mouseout
    })
}

function countryInDatabase(feature) {
    return countries.hasOwnProperty(feature.properties.iso_a2.toLocaleLowerCase());
}

function geoStyle(feature){
    
    return { stroke: true,
             fill: true,
             fillColor: '#008aac',
             fillOpacity: 0.6,
             color: '#164652',
             weight: 2 };
};

let jsonLayer = L.geoJson(countryFeatures,
                          {
                              style: geoStyle,
                              onEachFeature: onEachFeature,
                              filter: countryInDatabase
                          }).addTo(mymap);

// Control with country name and student/professor count
let info_numbers = L.control();
info_numbers.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
}

info_numbers.update = function (country_info) {
    this._div.innerHTML = country_info ?
        `<p><b>${country_info.country}</b></br> Professors: ${country_info.professor_count}</br> Students: ${country_info.student_count}</br> Institutions: ${country_info.institution_count}</p>` :
        '<p>Hover the mouse over a country</p>';
}
info_numbers.addTo(mymap);

// Controll with map color scale
let color_scale = L.control({position: "bottomright"});
color_scale.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info scale');
    this._bar = L.DomUtil.create('div', 'bar', this._div);
    this._colors = {from:'red', to:'green'};
    
    this.changeColor();
    return this._div;
}

color_scale.changeColor = function (colors) {
    this._colors = colors || this._colors;
    this._bar.style.backgroundImage = `linear-gradient(${this._colors.from}, ${this._colors.to})`;
}

// color_scale.addTo(mymap);
