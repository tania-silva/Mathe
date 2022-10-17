<?php require("statistics/database.php"); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
	  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	  crossorigin=""/>

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
	    integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
	    crossorigin=""></script>
<link rel="stylesheet" href="./mapview/map.css">
<style>
 #mapid {
     height: 500px;
     width: 100%;
     margin: 0 auto;
     border-radius: 1em;
     border-style: solid;
     border-color: #01aef0
 }
</style>

<div id="mapid"></div>
<script>
 var countries = <?php mathe_data("institutionData", $key = 'country_code'); ?>;
 var institutions = <?php mathe_data("institutionLocation", $key = 'university'); ?>
</script>
<script src="./mapview/countries.js"></script>
<script src="./mapview/color.js"></script>
<script src="./mapview/map.js"></script>
