/* ==============================================
GOOGLE MAP
=============================================== */

	$(document).ready(function() {

			'use strict';

			// Map Coordination

			var latlng = new google.maps.LatLng(-15.799896,-47.8823319);

			// Map Options
			var myOptions = {
				zoom: 15,
				center: latlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				disableDefaultUI: true,
				scrollwheel: false,
				// Google Map Color Styles
				styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:65},{visibility:"on"}]},{featureType:"poi",stylers:[{saturation:-100},{lightness:51},{visibility:"simplified"}]},{featureType:"road.highway",stylers:[{saturation:-100},
				{visibility:"simplified"}]},{featureType:"road.arterial",stylers:[{saturation:-100},{lightness:30},{visibility:"on"}]},{featureType:"road.local",stylers:[{saturation:-100},{lightness:40},{visibility:"on"}]},{featureType:"transit",stylers:[{saturation:-100},
				{visibility:"simplified"}]},{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}
				]/**/},{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:-25},{saturation:-100}]},{featureType:"water",elementType:"geometry",stylers:[{hue:"#ffff00"},{lightness:-25},{saturation:-97}]}]
			};

			var map = new google.maps.Map(document.getElementById('google-map'), myOptions);

			// Marker Image
			var image = 'images/marker.png';
			
		  	/* ========= First Marker ========= */

		  	// First Marker Coordination
			
			var myLatlng = new google.maps.LatLng(-15.799896,-47.8823319);

			// Your Texts 

			 var contentString = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '</div>'+
			  '<h4>' +

			  'BSB-TI Education'+

			  '</h4>'+
			  '<p>' +

			  'Setor Bancário Sul Quadra 02 Bloco E Numero 12, Ed. Prime Sala 206 Parte K5' +

			  '</p>'+
			  '</div>';
			

			var marker = new google.maps.Marker({
				  position: myLatlng,
				  map: map,
				  title: 'Hello World!',
				  icon: image
			  });


			var infowindow = new google.maps.InfoWindow({
			  content: contentString
			  });

			  
			 google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			  });

			 /* ========= End First Marker ========= */




			 /* ========= Second Marker ========= */

			 // Second Marker Coordination

			 var myLatlngSecond = new google.maps.LatLng(41.858774,-87.685328);

			 // Your Texts

			 var contentStringSecond = '<div id="content">'+
			  '<div id="siteNotice">'+
			  '</div>'+
			  '<h4>' +

			  'Office 2'+

			  '</h4>'+
			  '<p>' +

			  'Your description is here.' +

			  '</p>'+
			  '</div>';

			  var infowindowSecond = new google.maps.InfoWindow({
				  content: contentStringSecond,
				  });

			 var markerSecond = new google.maps.Marker({
				  position: myLatlngSecond,
				  map: map,
				  title: 'Hello World!',
				  icon: image
			  });

			 google.maps.event.addListener(markerSecond, 'click', function() {
				infowindowSecond.open(map,markerSecond);
			  });

			 /* ========= End Second Marker ========= */
		
		})