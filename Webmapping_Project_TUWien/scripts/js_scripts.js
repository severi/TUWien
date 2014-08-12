/******************************************************
*******************************************************
      THE SCRIPTS BELOW ARE DOWNLOADED FROM
      http://webmap.ikgeom.tuwien.ac.at/webmapping2011/main/inc/downloadxml.js

*******************************************************
******************************************************/


/**
* Returns an XMLHttp instance to use for asynchronous
* downloading. This method will never throw an exception, but will
* return NULL if the browser does not support XmlHttp for any reason.
* @return {XMLHttpRequest|Null}
*
* Original author: Mike Williams
* Downloaded from www.geocodezip.com/scripts/downloadxml.js on 23.11.2011
*/
function createXmlHttpRequest() {
 try {
   if (typeof ActiveXObject != 'undefined') {
     return new ActiveXObject('Microsoft.XMLHTTP');
   } else if (window["XMLHttpRequest"]) {
     return new XMLHttpRequest();
   }
 } catch (e) {
   changeStatus(e);
 }
 return null;
};

/**
* This functions wraps XMLHttpRequest open/send function.
* It lets you specify a URL and will call the callback if
* it gets a status code of 200.
* @param {String} url The URL to retrieve
* @param {Function} callback The function to call once retrieved.
*/
function downloadUrl(url, callback) {
 var status = -1;
 var request = createXmlHttpRequest();
 if (!request) {
   return false;
 }

 request.onreadystatechange = function() {
   if (request.readyState == 4) {
     try {
       status = request.status;
     } catch (e) {
       // Usually indicates request timed out in FF.
     }
     if ((status == 200) || (status == 0)) {
       callback(request.responseText, request.status);
       request.onreadystatechange = function() {};
     }
   }
 }
 request.open('GET', url, true);
 try {
   request.send(null);
 } catch (e) {
   changeStatus(e);
 }
};

/**
 * Parses the given XML string and returns the parsed document in a
 * DOM data structure. This function will return an empty DOM node if
 * XML parsing is not supported in this browser.
 * @param {string} str XML string.
 * @return {Element|Document} DOM.
 */
function xmlParse(str) {
  if (typeof ActiveXObject != 'undefined' && typeof GetObject != 'undefined') {
    var doc = new ActiveXObject('Microsoft.XMLDOM');
    doc.loadXML(str);
    return doc;
  }

  if (typeof DOMParser != 'undefined') {
    return (new DOMParser()).parseFromString(str, 'text/xml');
  }

  return createElement('div', null);
}

/**
 * Appends a JavaScript file to the page.
 * @param {string} url
 */
function downloadScript(url) {
  var script = document.createElement('script');
  script.src = url;
  document.body.appendChild(script);
}


/******************************************************
*******************************************************
The scripts below are made by me (Severi Haverila)

*******************************************************
******************************************************/
var markersArray = {};
var map;
var directionsService;
var directionsDisplay;
var infoWindow;

function showMarkers(cat, s_cat, show)
{
  for (var i = 0; i < markersArray[cat][s_cat].length; i++ ) {
    if (show){
      markersArray[cat][s_cat][i].setMap(map);
    }
    else {
      markersArray[cat][s_cat][i].setMap(null);
    }
  }
}
function showMarker(cat, s_cat, title,show)
{
  for (var i = 0; i < markersArray[cat][s_cat].length; i++ ) {
    if (markersArray[cat][s_cat][i].getTitle()!=title)continue;

    if (show){
      markersArray[cat][s_cat][i].setMap(map);
    }
    else {
      markersArray[cat][s_cat][i].setMap(null);
    }
  }
}

function checkboxChecked(cat,s_cat,title)
{
  if (s_cat=='NULL'){
    var boxes = document.getElementsByName("main_category");
    for (var i =0; i < boxes.length; i++) {
      if (boxes[i].getAttribute("value")!=cat) continue;

      var s_boxes = document.getElementsByName("sub_category");
      for (var j =0; j < s_boxes.length; j++) {
        console.log(s_boxes.length+' '+s_boxes[j].getAttribute("value"));
        if (s_boxes[j].getAttribute("value").split(";")[0]!=cat) continue;
          s_boxes[j].checked=boxes[i].checked;
          console.log("NYT!!!!");
          showMarkers(cat,s_boxes[j].getAttribute("value").split(";")[1], boxes[i].checked);
      }

      var p_boxes = document.getElementsByName("place");
      for (var j =0; j < p_boxes.length; j++) {
        console.log(p_boxes[j].getAttribute("value"));
        if (p_boxes[j].getAttribute("value").split(";")[0]!=cat) continue;
        p_boxes[j].checked=boxes[i].checked;
        showMarker(cat,p_boxes[j].getAttribute("value").split(";")[1],
                    p_boxes[j].getAttribute("value").split(";")[2],boxes[i].checked);
      }
    }
  }
  else if(title=='NULL'){
      var boxes = document.getElementsByName("sub_category");
      var checkMain = false;
      for (var i=0;i<boxes.length;i++){
        var category = boxes[i].getAttribute("value").split(";")[0];
        var s_category = boxes[i].getAttribute("value").split(";")[1];


        if (category!=cat)continue;
        if (boxes[i].checked) {
          checkMain = true;
        }
        if (s_category!=s_cat) continue;
        showMarkers(category,s_category, boxes[i].checked);
        var p_boxes = document.getElementsByName("place");
        for (var j =0; j < p_boxes.length; j++) {
          console.log(p_boxes[j].getAttribute("value"));
          if (p_boxes[j].getAttribute("value").split(";")[0]!=cat) continue;
          if (p_boxes[j].getAttribute("value").split(";")[1]!=s_cat) continue;
          p_boxes[j].checked=boxes[i].checked;
          showMarker(cat,p_boxes[j].getAttribute("value").split(";")[1],
                      p_boxes[j].getAttribute("value").split(";")[2],boxes[i].checked);
        }
      }
      document.getElementById("cat:"+cat).checked=checkMain;
  }
  else{
    var boxes = document.getElementsByName("place");
    var checkSub = false;
    var checkMain = false;
    for (var i=0;i<boxes.length;i++){
      var category = boxes[i].getAttribute("value").split(";")[0];
      var s_category = boxes[i].getAttribute("value").split(";")[1];
      var name = boxes[i].getAttribute("value").split(";")[2];

      if (category!=cat)continue;
      if (boxes[i].checked) checkMain = true;
      if (s_category!=s_cat) continue;
      if (boxes[i].checked) checkSub = true;
      if (name!=title) continue;
      showMarker(category,s_category, title,boxes[i].checked);
    }
    document.getElementById("cat:"+cat).checked=checkMain;
    document.getElementById("s_cat:"+cat+";"+s_cat).checked=checkSub;
  }
}

function addSelectBox()
{
  var select_html = '<form action="">';
  var inputFrom_html='<p>From: <select id="routeSelectionFrom" value="From:">';
  var inputTo_html='<p>To: <select id="routeSelectionTo" value="To:">';
  var input_html='';
  if (navigator.geolocation) {
    input_html+='<option value="MyLocation">MyLocation</option>';
  }
  select_html +='<ul>'

  for (var cat in markersArray) {
    select_html += '<li id="ctrl_cat"><input type="checkbox" onclick="checkboxChecked(\''+cat+'\',\'NULL\',\'NULL\')" name="main_category" value="'+cat+'" id="cat:'+cat+'"checked> <img src="icons/'+cat+'.png">'+cat+'</li>';
    select_html +='<ul>'
    for (var s_cat in markersArray[cat] ) {
      select_html += '<li id="ctrl_scat"><input type="checkbox" onclick="checkboxChecked(\''+cat+'\',\''+s_cat+'\',\'NULL\')" name="sub_category" value="'+cat+';'+s_cat+'" id="s_cat:'+cat+';'+s_cat+'" checked>'+s_cat+'</li>';
      select_html +='<ul>'
      for (var i=0;i<markersArray[cat][s_cat].length;i++){
        var title=markersArray[cat][s_cat][i].getTitle()
        input_html+='<option value="'+title+'">'+title+'</option>';
        select_html += '<li id="ctrl_loc"><input type="checkbox" onclick="checkboxChecked(\''+cat+'\',\''+s_cat+'\',\''+title+'\')" name="place" value="'+cat+';'+s_cat+';'+title+'" checked>'+title+'</li>';
      }
      select_html +='</ul>'
    };
    select_html +='</ul>'
  };
  select_html +='</ul>'
  select_html += '</form>';
  input_html+='</select></p>';
  inputBtn_html='<p><form><input type="button" value="Calculate Route!" onclick="calcRoute()"></form></p>';

  document.getElementById("ctrl").innerHTML = select_html;
  document.getElementById("routeFrom").innerHTML = inputFrom_html+input_html;
  document.getElementById("routeTo").innerHTML = inputTo_html+input_html;
  document.getElementById("routeButton").innerHTML = inputBtn_html;
}

function getMarkerByName(name){
  for (var cat in markersArray){
    for (var s in markersArray[cat]){
      for (var i=0;i<markersArray[cat][s].length; i++){
        if (name==markersArray[cat][s][i].getTitle()){
          return markersArray[cat][s][i];
        }
      }
    }
  }
}

function calcRoute() {
  var el = document.getElementById('routeSelectionFrom');
  var fromPl = el.options[el.selectedIndex].innerHTML;
  el = document.getElementById('routeSelectionTo');
  var toPl = el.options[el.selectedIndex].innerHTML;
  /*
  *   Check if knowledge about current location needed
  */
  if (fromPl=="MyLocation" || toPl=="MyLocation"){
    navigator.geolocation.getCurrentPosition(function (position) {
      var myLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
      var el = document.getElementById('routeSelectionFrom');
      var fromPl = el.options[el.selectedIndex].innerHTML;
      el = document.getElementById('routeSelectionTo');
      var toPl = el.options[el.selectedIndex].innerHTML;

      var request = {
          origin:     fromPl=="MyLocation"?myLocation:getMarkerByName(fromPl).getPosition(),
          destination:toPl=="MyLocation"?myLocation:getMarkerByName(toPl).getPosition(),
          travelMode: google.maps.TravelMode.WALKING
      };
      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
        }
      });
    });
  }
  else {
    var el1 = document.getElementById('routeSelectionFrom');
    var el2 = document.getElementById('routeSelectionTo');

    var request = {
        origin:     getMarkerByName(el1.options[el1.selectedIndex].innerHTML).getPosition(),
        destination:getMarkerByName(el2.options[el2.selectedIndex].innerHTML).getPosition(),
        travelMode: google.maps.TravelMode.WALKING
    };
    directionsService.route(request, function(response, status) {
      if (status == google.maps.DirectionsStatus.OK) {
        directionsDisplay.setDirections(response);
      }
    });
  }
}


/*
 * Returns path to the icon according to the category
 * @param {String} category The icon category
 * @return {String} path to the icon.
 */
function getIcon(category)
{
  var color='icons/Sightseeing.png';
  switch(category)
  {
  case "Bar":
    color='icons/Bar.png';
    break;
  case "Restaurant":
    color='icons/Restaurant.png';
    break;
  }
  return color;
}

/*
 * Creates a marker according to the information provided in the parameters
 * @param {String} point position of the marker
 * @param {String} info information window content
 * @param {google.maps.Map} map the map where the marker is to be added
 * @param {String} cat marker category (restaurant, bar, ...)
 */

function createMarker(point,info,map, cat, s_cat, name)
{
  infoWindow = new google.maps.InfoWindow();
   var myMarkerOpts = {
     position: point,
     map: map,
     icon: getIcon(cat),
     title: name
  };
  var marker = new google.maps.Marker(myMarkerOpts);

  google.maps.event.addListener(marker, 'click', function() {
   infoWindow.close();
   infoWindow.setContent(info);
   infoWindow.open(map,marker);
  });

  if(!markersArray[cat]){
      markersArray[cat]= {};
  }
  if (!markersArray[cat][s_cat]){
    markersArray[cat][s_cat] = new Array();
    console.log("ADDED!"+cat+' '+s_cat);
  }
  markersArray[cat][s_cat].push(marker);
}

/*
 * Initialization of the map
 */
function initialize()
{
  directionsService = new google.maps.DirectionsService();
  directionsDisplay = new google.maps.DirectionsRenderer();
  var mapOptions = {
    center: new google.maps.LatLng(48.198977,16.369701),
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.ROAD
  };

  map = new google.maps.Map(document.getElementById("map-canvas"),
      mapOptions);
  directionsDisplay.setMap(map);

  downloadUrl("data.xml", function(data)
  {
      var xmlDoc = xmlParse(data);
      var records = xmlDoc.getElementsByTagName("marker");
      for (var i = 0; i < records.length; i++)
      {
        var rec = records[i];
        var name = rec.getAttribute("name");
        var desc = rec.getAttribute("desc");
        var lat = parseFloat(rec.getAttribute("lat"));
        var lng = parseFloat(rec.getAttribute("lng"));
        var category = rec.getAttribute("category");
        var sub_category = rec.getAttribute("sub_category");
        var point = new google.maps.LatLng(lat,lng);
        var html = "<strong>" + name + "</strong><br/><p>"+desc+"</p>";
        createMarker(point,html,map,category, sub_category,name);
      }
      addSelectBox();
  });
}
