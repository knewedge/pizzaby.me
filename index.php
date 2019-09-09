<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Pizzaby.me</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36823489-1']);
  _gaq.push(['_trackPageview']);
  (function(){
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script src="http://maps.googleapis.com/maps/api/js?key=REDACTED&sensor=false"></script>
<script src="/js/jquery.js"></script>
<script type="text/javascript">
/*Geocode*/
function google_geocode(){
	var geocoder = new google.maps.Geocoder();
	var address = document.getElementById("address").value;
	geocoder.geocode({ 'address': address},function(results, status){
		if(status == google.maps.GeocoderStatus.OK){
			document.getElementById("results").innerHTML = "";
			$("#load").show();
			google_map(results[0].geometry.location.lat(),results[0].geometry.location.lng());
			google_places(results[0].geometry.location.lat(),results[0].geometry.location.lng());
      	}else{
        	alert("Geocode was not successful for the following reason: " + status);
      	}
	});
}
/*Get Location*/
function geo_location(){
  if(navigator.geolocation){
    navigator.geolocation.getCurrentPosition(function(loc){
      var lat = loc.coords.latitude;
      var lon = loc.coords.longitude;
	  google_map(lat,lon);
      google_places(lat,lon);
    });
  }else{
    alert("not supported");
  }
}
/*Google Map*/
function google_map(lat,lon){
	var myLatlng = new google.maps.LatLng(lat,lon);
	var mapOptions = {
		zoom:13,
		center:myLatlng,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	}
	map = new google.maps.Map(document.getElementById('map'),mapOptions);
}
/*Get Places*/
function google_places(lat,lon){
	$.ajax({
		type: 'POST',
		url: 'places.php',
		data: {lat:lat,lon:lon},
		dataType:'json',
		success: function(data){
			window.data = data;
			for(var i = 0; i < data.length; i++){
				var latlng = new google.maps.LatLng(data[i].lati,data[i].long);				
        if(data[i].rate){
          var res = data[i].rate + "/5";
        }else{
          var res = "No Rating"
        }   
        document.getElementById("results").innerHTML += "<strong>"+ data[i].name + "</strong> &mdash; <span style=\"color:#0000ff;\">" + res + "</span><br />" + data[i].addr + "<br /><a href=\"tel:1" + data[i].phon.replace(/[\(\)\s+\.-]+/g,'') + "\">" + data[i].phon + "</a> | <a href=\"#"+ i +"\">Reviews</a><div id=\"reviews-" + i + "\"></div><br />";
				create_markers(latlng,data[i].name);
			}
			$("#load").hide();    
		}
	});
}
/*Creat Markers*/
function create_markers(latlng,name){
	var marker = new google.maps.Marker({
		position: latlng,
		map: map,
		title: name
	});
}
$(window).bind('hashchange',function(e){
	/*Remove Reviews*/
	$(".current").each(function(){
		if($(this).html()){
			$(this).html("");
			$(this).removeClass("current");
		}
	});
	/*Add Reviews*/
	var hash = window.location.hash.split("#");
	for(var j = 0; j < data[hash[1]].revi.length; j++){
		if(data[hash[1]].revi[j].text){
			if(j == 0){
				document.getElementById("reviews-" + hash[1]).innerHTML += data[hash[1]].revi[j].text;
				document.getElementById("reviews-" + hash[1]).className = "current";
			}else{
				document.getElementById("reviews-" + hash[1]).innerHTML += "<hr />" + data[hash[1]].revi[j].text;
				document.getElementById("reviews-" + hash[1]).className = "current";
			}
			
		}
	}
});
$(document).ready(function(){
  $("input[type='text']").click(function(){
    //alert("this feature is still in progress")
    if($(this).val() == "search by city or address"){
      $(this).val("");
    }
  });
  $("input[type='text']").blur(function(){
    if(!($(this).val())){
      $(this).val("search by city or address");
    }
  });
});
</script>
</head>
<body onload="geo_location()">
<div id="header">
  <div id="head">
    <h1>pizza by <span style="color:#bf0417;">me</span></h1>
    <em>Find pizza places by you!</em>
  </div>
</div>
<div id="search">
  <div id="form">
  	<div>
  		<input id="address" type="text" value="search by city or address"/>
  		<input type="image" src="/images/search.gif" onclick="google_geocode()"/>
  	</div>
  </div>
</div>
<div id="map"></div>
<div id="load">Ugh Loading...</div>
<div id="results"></div>
</body>
</html>
