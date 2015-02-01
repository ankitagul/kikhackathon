<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../../css/mystyle.css">
    <title>Kik Hackathon</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=panoramio,places"></script>
	<script>
	/*! simpleWeather v3.0.2 - http://simpleweatherjs.com */
(function($) {
  "use strict";

  function getAltTemp(unit, temp) {
    if(unit === 'f') {
      return Math.round((5.0/9.0)*(temp-32.0));
    } else {
      return Math.round((9.0/5.0)*temp+32.0);
    }
  }

  $.extend({
    simpleWeather: function(options){
      options = $.extend({
        location: '',
        woeid: '',
        unit: 'f',
        success: function(weather){},
        error: function(message){}
      }, options);

      var now = new Date();
      var weatherUrl = 'https://query.yahooapis.com/v1/public/yql?format=json&rnd='+now.getFullYear()+now.getMonth()+now.getDay()+now.getHours()+'&diagnostics=true&callback=?&q=';
      if(options.location !== '') {
        weatherUrl += 'select * from weather.forecast where woeid in (select woeid from geo.placefinder where text="'+options.location+'" and gflags="R" limit 1) and u="'+options.unit+'"';
      } else if(options.woeid !== '') {
        weatherUrl += 'select * from weather.forecast where woeid='+options.woeid+' and u="'+options.unit+'"';
      } else {
        options.error({message: "Could not retrieve weather due to an invalid location."});
        return false;
      }

      $.getJSON(
        encodeURI(weatherUrl),
        function(data) {
          if(data !== null && data.query !== null && data.query.results !== null && data.query.results.channel.description !== 'Yahoo! Weather Error') {
            var result = data.query.results.channel,
                weather = {},
                forecast,
                compass = ['N', 'NNE', 'NE', 'ENE', 'E', 'ESE', 'SE', 'SSE', 'S', 'SSW', 'SW', 'WSW', 'W', 'WNW', 'NW', 'NNW', 'N'],
                image404 = "https://s.yimg.com/os/mit/media/m/weather/images/icons/l/44d-100567.png";

            weather.title = result.item.title;
            weather.temp = result.item.condition.temp;
            weather.code = result.item.condition.code;
            weather.todayCode = result.item.forecast[0].code;
            weather.currently = result.item.condition.text;
            weather.high = result.item.forecast[0].high;
            weather.low = result.item.forecast[0].low;
            weather.text = result.item.forecast[0].text;
            weather.humidity = result.atmosphere.humidity;
            weather.pressure = result.atmosphere.pressure;
            weather.rising = result.atmosphere.rising;
            weather.visibility = result.atmosphere.visibility;
            weather.sunrise = result.astronomy.sunrise;
            weather.sunset = result.astronomy.sunset;
            weather.description = result.item.description;
            weather.city = result.location.city;
            weather.country = result.location.country;
            weather.region = result.location.region;
            weather.updated = result.item.pubDate;
            weather.link = result.item.link;
            weather.units = {temp: result.units.temperature, distance: result.units.distance, pressure: result.units.pressure, speed: result.units.speed};
            weather.wind = {chill: result.wind.chill, direction: compass[Math.round(result.wind.direction / 22.5)], speed: result.wind.speed};

            if(result.item.condition.temp < 80 && result.atmosphere.humidity < 40) {
              weather.heatindex = -42.379+2.04901523*result.item.condition.temp+10.14333127*result.atmosphere.humidity-0.22475541*result.item.condition.temp*result.atmosphere.humidity-6.83783*(Math.pow(10, -3))*(Math.pow(result.item.condition.temp, 2))-5.481717*(Math.pow(10, -2))*(Math.pow(result.atmosphere.humidity, 2))+1.22874*(Math.pow(10, -3))*(Math.pow(result.item.condition.temp, 2))*result.atmosphere.humidity+8.5282*(Math.pow(10, -4))*result.item.condition.temp*(Math.pow(result.atmosphere.humidity, 2))-1.99*(Math.pow(10, -6))*(Math.pow(result.item.condition.temp, 2))*(Math.pow(result.atmosphere.humidity,2));
            } else {
              weather.heatindex = result.item.condition.temp;
            }

            if(result.item.condition.code == "3200") {
              weather.thumbnail = image404;
              weather.image = image404;
            } else {
              weather.thumbnail = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+result.item.condition.code+"ds.png";
              weather.image = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+result.item.condition.code+"d.png";
            }

            weather.alt = {temp: getAltTemp(options.unit, result.item.condition.temp), high: getAltTemp(options.unit, result.item.forecast[0].high), low: getAltTemp(options.unit, result.item.forecast[0].low)};
            if(options.unit === 'f') {
              weather.alt.unit = 'c';
            } else {
              weather.alt.unit = 'f';
            }

            weather.forecast = [];
            for(var i=0;i<result.item.forecast.length;i++) {
              forecast = result.item.forecast[i];
              forecast.alt = {high: getAltTemp(options.unit, result.item.forecast[i].high), low: getAltTemp(options.unit, result.item.forecast[i].low)};

              if(result.item.forecast[i].code == "3200") {
                forecast.thumbnail = image404;
                forecast.image = image404;
              } else {
                forecast.thumbnail = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+result.item.forecast[i].code+"ds.png";
                forecast.image = "https://s.yimg.com/zz/combo?a/i/us/nws/weather/gr/"+result.item.forecast[i].code+"d.png";
              }

              weather.forecast.push(forecast);
            }

            options.success(weather);
          } else {
            options.error({message: "There was an error retrieving the latest weather information. Please try again.", error: data.query.results.channel.item.title});
          }
        }
      );
      return this;
    }
  });
})(jQuery);

	</script>
	<script>
var geocoder;
var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var fromTo = new Array();
var coordinates = new Array();
var imageUrls = new Array();
var markers;

function initialize() {
  geocoder = new google.maps.Geocoder();
  directionsDisplay = new google.maps.DirectionsRenderer({
    polylineOptions: {
      strokeColor: "black"
    }
  });
  var mapOptions = {
    zoom: 16,
    center: new google.maps.LatLng(47.651743, -122.349243)
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

	  var startDestination =document.getElementById('startDestination');
	  var endDestination = document.getElementById('endDestination');
	  
	  var autocomplete = new google.maps.places.Autocomplete(startDestination);
  autocomplete.bindTo('bounds', map);
  
  var infowindow = new google.maps.InfoWindow();
  var marker = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });
  
  google.maps.event.addListener(autocomplete, 'place_changed', function() {
    infowindow.close();
    marker.setVisible(false);
    var place = autocomplete.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    marker.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindow.open(map, marker);
  });
  
  var autocompleteend = new google.maps.places.Autocomplete(endDestination);
  autocompleteend.bindTo('bounds', map);
  
  var infowindowend = new google.maps.InfoWindow();
  var markerend = new google.maps.Marker({
    map: map,
    anchorPoint: new google.maps.Point(0, -29)
  });
  
  google.maps.event.addListener(autocompleteend, 'place_changed', function() {
    infowindowend.close();
    markerend.setVisible(false);
    var place = autocompleteend.getPlace();
    if (!place.geometry) {
      return;
    }

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);  // Why 17? Because it looks good.
    }
    markerend.setIcon(/** @type {google.maps.Icon} */({
      url: place.icon,
      size: new google.maps.Size(71, 71),
      origin: new google.maps.Point(0, 0),
      anchor: new google.maps.Point(17, 34),
      scaledSize: new google.maps.Size(35, 35)
    }));
    markerend.setPosition(place.geometry.location);
    markerend.setVisible(true);

    var address = '';
    if (place.address_components) {
      address = [
        (place.address_components[0] && place.address_components[0].short_name || ''),
        (place.address_components[1] && place.address_components[1].short_name || ''),
        (place.address_components[2] && place.address_components[2].short_name || '')
      ].join(' ');
    }

    infowindowend.setContent('<div><strong>' + place.name + '</strong><br>' + address);
    infowindowend.open(map, marker);
  });
  
  var panoramioLayer = new google.maps.panoramio.PanoramioLayer();
  panoramioLayer.setMap(map);
  
  directionsDisplay.setMap(map);

  var photoPanel = document.getElementById('photo-panel');
  map.controls[google.maps.ControlPosition.RIGHT_TOP].push(photoPanel);

  google.maps.event.addListener(panoramioLayer, 'mouseup', function(photo) {
	photo.InfoWindow();
  });


  google.maps.event.addListener(panoramioLayer, 'click', function(photo) {
    var li = document.createElement('li');
    var link = document.createElement('a');
    var lat = photo.latLng.lat();
    var lng = photo.latLng.lng();
	var photoId = photo.featureDetails.photoId;
	var start = photo.infoWindowHtml.indexOf('http');
	var end = photo.infoWindowHtml.indexOf('jpg');
	
	var imageUrl = photo.infoWindowHtml.substring(start,end);
	imageUrl = imageUrl + "jpg";

	imageUrls[photoId] = imageUrl;
	
	var coord = "'" + lat + "," + lng + "'";
    var picHtml = "<img src='" + imageUrl + "' class='displayimg'><br/><span id='midWeather' class='weather'></span><br/><input id='add-button' type='button' class='Button' value='Add' onclick=\"addCoordinates("+coord+","+photoId+")\">";
    jQuery( "#selectedPics" ).html( picHtml );
	jQuery('.gm-style-iw').parent().parent().hide();
    jQuery.simpleWeather({
    location: lat+','+lng,
    woeid: '',
    unit: 'f',
    success: function(weather) {
      html = weather.temp+'&deg;'+weather.units.temp+', '+weather.region+', '+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed;
	  jQuery("#midWeather").html(html);
    },
    error: function(error) {
    }
  });
	// populate yor box/field with lat, lng
    //alert("Lat=" + lat + "; Lng=" + lng);

    /*link.innerHTML = photo.featureDetails.title + ': ' +
        photo.featureDetails.author + ':' + photo.featureDetails.photoId ;
console.log(photo.featureDetails);
console.log(6+4);
    link.setAttribute('href', photo.featureDetails.url);
    li.appendChild(link);
    photoPanel.appendChild(li);
    photoPanel.style.display = 'block'; */
  });
}

function addCoordinates(latLng, photoId) {
	coordinates[photoId] = latLng;
	var imagehtml = "<a id='"+photoId+"' href='javascript:restorePic("+photoId+")'><img class='smallimg' src='"+imageUrls[photoId]+"'></a>";
	jQuery('#displayPics').append(imagehtml);
	jQuery('#selectedPics').html('');
}

function restorePic(photoId) {
	var imageUrl = imageUrls[photoId];
	var coord = String(coordinates[photoId]);
var picHtml = "<img class='displayimg' src='" + imageUrl + "' ><br/><input type='button' class='Button' id='delete-button' value='Delete' onclick=\"deleteCoordinates("+photoId+")\">";
    jQuery( "#selectedPics" ).html( picHtml );
	//var elem = document.getElementById(photoId);
	//elem.parentNode.removeChild(elem);
}

function deleteCoordinates(photoId) {
delete imageUrls[photoId];
delete coordinates[photoId];
jQuery("#selectedPics").html('');
var elem = document.getElementById(photoId);
	elem.parentNode.removeChild(elem);
}
function codeAddress() {
  var address = document.getElementById('startDestination').value;
  jQuery.simpleWeather({
    location: address,
    woeid: '',
    unit: 'f',
    success: function(weather) {
      html = weather.temp+'&deg;'+weather.units.temp+', '+weather.region+', '+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed;
	  jQuery("#fromWeather").html(html);
    },
    error: function(error) {
    }
  });

  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
	fromTo.push(results[0].geometry.location.k,results[0].geometry.location.D);
	console.log(fromTo);	//lat,lng
	//markers = results[0].geometry.location;
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	  calcRoute();
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });


}


function codeAddress1() {
  
  fromTo.splice(0, fromTo.length);
  //jQuery('#selectedPics').html('');
  //jQuery('#displayPics').html('');
  var address = document.getElementById('endDestination').value;
  jQuery.simpleWeather({
    location: address,
    woeid: '',
    unit: 'f',
    success: function(weather) {
      html = weather.temp+'&deg;'+weather.units.temp+', '+weather.region+', '+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed;
	  jQuery("#toWeather").html(html);
    },
    error: function(error) {
    }
  });

  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
	fromTo.push(results[0].geometry.location.k,results[0].geometry.location.D);
	console.log(fromTo);	//lat,lng
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
	  codeAddress();
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

function calcRoute() {
  var start = new google.maps.LatLng(fromTo[2], fromTo[3]);
  var end = new google.maps.LatLng(fromTo[0], fromTo[1]);
  var waypts = [];
  for (var key in coordinates) {
      waypts.push({
          location:coordinates[key],
          stopover:true
      });
  }
  var request = {
      origin:start,
      destination:end,
	  waypoints:waypts,
	  optimizeWaypoints:true,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
  var startaddress = document.getElementById('startDestination').value;
  var endaddress = document.getElementById('endDestination').value;
  jQuery.ajax({
   url:"home/add",
   type:"POST",
   data:"from="+startaddress+"&to="+endaddress,
   success:function(result){
  }});
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <ul id="photo-panel">
      <li><strong>Photos clicked</strong></li>
    </ul>


	
    <script>
	/*jQuery('#address').keyup(function(e) {
    clearTimeout($.data(this, 'timer'));
    if (e.keyCode == 13)
      search(jQuery('#address').val());
    else
      $(this).data('timer', setTimeout(search, 500));
});
function search(value) {
    if (!force && value.length < 3) return; //wasn't enter, not > 2 char
    $.get('/Tracker/Search/' + value, function(data) {
        $('div#results').html(data);
        $('#results').show();
    });
}*/
	</script>



    <div id="map-canvas"></div>
	<div id="right-sidebar">
	<a href="http://www.kikhackathon.com/index.php/home/interests"><input type="button" value="View Past Interests!" style="background: none repeat scroll 0% 0% rgb(244, 84, 53); border: medium none; color: rgb(255, 255, 255); font-size: 18px; font-weight: bold; line-height: 27px; padding: 4px 20px;margin-top: 8px;"></a>
      		
	<div id="panel" class="RightEl">
			<input id="startDestination" type="textbox" class="InputField">
    <span id="fromWeather" class="weather"></span>
      	<br/><br/>
      		<input id="endDestination" type="textbox" class="InputField">
		<span id="toWeather" class="weather"></span>
      		<!--<input type="button" value="To" onclick="codeAddress1()" style="background: none repeat scroll 0% 0% rgb(244, 84, 53); border: medium none; color: rgb(255, 255, 255); font-size: 18px; font-weight: bold; line-height: 27px; padding: 4px 20px;margin-top: 8px;"> -->
	</div>
	<div id="selectedPics" class="RightEl">
	<img src="../../images/logo.jpg" id="logoImg"/>
	</div>
	<div id="displayPics" class="RightEl">
	
	</div>
	<div>
	<input id="submit-button" type="button" value="Submit" onclick="codeAddress1()" class="Button">
	<div>
	</div>
  </body>
</html>


