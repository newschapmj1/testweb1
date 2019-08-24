/*jslint white:true*/
(function () {
    "use strict";
    // this function is strict...
}());

/*global window, document, $, google, alert */
/*---------------------------------------------------------------------------------------------------------------------------
 Author:     Gabriel Svennerberg.
 Created:    2008-09-27
 Email:         gabriel@svennerberg.com
 Web:        svennerberg.com

 This is a demo to show a way to use microformats and javascript to extract information.
 Please note that code is not suitable for production. In a live environment more validation
 of data is neccesary.

 This demo was inspired by Jeremy Keith's adactio austin http://austin.adactio.com/ and
 the article "Get To Grips with Slippy Maps" by Andrew Turner published on 24ways.org

 Modified by John Chapman for Redbridge site October 2009,
 Dec 2010 converted to Google API 3

 to do
 default to current month
 zooming map should refilter map (ie not show all data)
 street view enabled?

 Convertion to G3 from G2
 init map
 technique for drawing group of markers
 technique for clearning markers
 technique for linking 1 infoWindow to all markers

Feb 2012 setui2 now wraps numbers of months
 ------------------------------------------------------------------------------------------------------------------------------*/

var map;
var markers = [];
var markersArray = [];
var d1 = new Date();
var infoWindow;
var events;
var ui;


function setUI2(month,position)
	{
	"use strict";		
	/* month ie to be evaluated 1-12, position start of list 1 -12
	eg Month Jan and position is Oct, output 4 as Jan is 4th month in list
	*/
	var result, adj;
    adj =  (12-position)+1;
	if (month < position)
	{
	    result = month + adj;
	}
	else
	{
	    result = (month - position) +1;
	}    

	return result;

	}

 
function clearMap() {
    "use strict";
    var i;
    for (i = 0; i < markers.length; i += 1) {
        markers[i].setVisible(false);
    }
}

function filterMap(month) {
    //month 1-12]
    "use strict";
    var i,
        d,
        eventMonth,
        c,
        bounds;
    bounds = new google.maps.LatLngBounds();
    c = 0;
    for (i = 0; i < markers.length; i += 1) {
        //    marker = markers[i];
        //        var d = new Date(marker.dtstartISO.replace('/n', ''));
        d = (events[i].dtstartISO).split("-");
        eventMonth = d[1].replace("\n", "");
        if (eventMonth != month) {
            //markers[i].hide();
            //markers[i].map.setmap(null)
            //markers[i].setmap(null)
            //		   marker.setVisible(false);
            markers[i].setVisible(false);
        } else {
            //markers[i].show();
            //markers[i].map.setmap(map)
            //markers[i].setmap(null)
            //		 marker.setVisible(true);
            markers[i].setVisible(true);
            if (events[i].latitude && events[i].longitude) {
                bounds.extend(markers[i].position);
                c = c + 1;
            }
        }
    } //for
    //	new bounding box if an event found
    if (c > 0) {
        map.fitBounds(bounds);
    }
}

// Deletes all markers in the array by removing references to them
function deleteOverlays() {
    "use strict";
var i ;

    if (markersArray) {
	for (i = 0; i < markersArray.length; i++)
  	 {markersArray[i].setMap(null);}
       }
        markersArray.length = 0;
    
} //deleteOverlays
function highLightItem(obj) {
    "use strict";
    $('#events li').removeClass('selected');
    $(obj).addClass('selected');
    $('#events').scrollTo(obj);
    //	google.maps.event.trigger(markers[5],'click');  
    google.maps.event.trigger(markers[obj.id], 'click');
}

function drawevents(events, map, infoWindow, i) {
    "use strict";
    var lat1,
        lon1,
        point,
        marker,
        d2;

    //process 1 event, create a marker and add to markers array
    d2 = events[i].dtstartISO.split("-");
    events[i].month = $.trim(d2[1]);

    //          if (events[i].getAttribute("month")==month)
    lat1 = events[i].latitude;
    lon1 = events[i].longitude;

    point = new google.maps.LatLng(
		parseFloat(events[i].latitude),
		parseFloat(events[i].longitude)
	);

    //          var icon = customIcons[type] || {};
    $(events[i]).bind('click', function (e) {

        highLightItem(this);
    });

    marker = new google.maps.Marker({

        position: point,
        map: map,
        title: 'Place number ' + i

        //            icon: icon.icon,
        //shadow: icon.shadow
    });

    (function (i, marker) {
        // Creating the event listener. It now has access to the values of
        // i and marker as they were during its creation
        google.maps.event.addListener(marker, 'click', function () {
            infoWindow.setContent("<div id='info'><b>" + events[i].summary + "</b><br><br>" + "<b>Date: </b>" + events[i].dtstart + "   " + events[i].StartTime + "<br>" + '<b>Description:</b> ' + events[i].Description + "<br>" + "<b>Explorer Map:</b> " + events[i].Exp + "<br><br>" + "<a href=\"http://streetmap.co.uk/grid/" + events[i].MapGridRef + "\"target=\"_blank\">" + events[i].GridRef + "</a><br><br>" + "<a href=\"//maps.google.co.uk/?q=" + events[i].latitude + "," + events[i].longitude + "(See%20Description%20for%20departure%20details)&z=16&t=k\" target=\"_blank\">Satellite</a><br>" + "<br>" + events[i].Grade + "<br>" + events[i].Distance);
            infoWindow.open(map, marker);

            /* commented out Dec 26		
             google.maps.event.addListener(marker, 'click', function () {
             // Check to see if the infoWindow already exists and is not null
             if (!infoWindow) {
             // if the infowindow doesn't exist, create an
             // empty InfoWindow object
             infoWindow = new google.maps.InfoWindow();
             }
             // Setting the content of the InfoWindow
             infoWindow.close();
             infoWindow.setContent("<div id='info'><h2>" + events[i].summary + "</h2><br>" + "<b>Date: </b>" + events[i].dtstart + "   " + events[i].StartTime + "<br>" + '<b>Description:</b> ' + events[i].Description + "<br>" + "<b>Explorer Map:</b> " + events[i].Exp + "<br><br>" + "<a href=\"http://streetmap.co.uk/grid/" + events[i].MapGridRef + "\"target=\"_blank\">" + events[i].GridRef + "</a><br><br>" + "<a href=\"http://maps.google.co.uk/?q=" + events[i].latitude + "," + events[i].longitude + "(See%20Description%20for%20departure%20details)&z=16&t=k\" target=\"_blank\">Satellite</a><br>" + "<br>" + events[i].Grade + "<br>" + events[i].Distance);
             // Tying the InfoWindow to the marker
             infoWindow.open(map, marker);
             */
        });

        //          bindInfoWindow(marker, map, infoWindow, html);
        //keep list in array
        //markersArray.push(marker);
        markers.push(marker);
    })(i, marker);

} //drawevents
function filterEventList(month) {
    "use strict";
    var dtstart,
        d,
        eventMonth;
    //month 1-12
    $('#events .dtstart').each(function () {
        //    $('#events .dtstartISO').each(function() {
        dtstart = $(this).attr('title').replace('\n', '');
        // dtstartISO = $(this).attr('title').replace('\n', '');
        d = dtstart.split("-");
        eventMonth = d[1];

        if (month == eventMonth) {
            $(this).parents('li.vevent').parents('li').show();
        } else {
            $(this).parents('li.vevent').parents('li').hide();
        }
    });
}

function monthName(month) {
    "use strict";
    //month 1-12
    var name = '';
    switch (month) {
    case 1:
        name = 'January';
        break;
    case 2:
        name = 'February';
        break;
    case 3:
        name = 'March';
        break;
    case 4:
        name = 'April';
        break;
    case 5:
        name = 'May';
        break;
    case 6:
        name = 'June';
        break;
    case 7:
        name = 'July';
        break;
    case 8:
        name = 'August';
        break;
    case 9:
        name = 'September';
        break;
    case 10:
        name = 'October';
        break;
    case 11:
        name = 'November';
        break;
    case 12:
        name = 'December';
        break;
    default:
        name = '';
        break;
    }
    return name;
}

function adjustElementHeights() {
    "use strict";
    var height,
        sliderHeight,
        eventHeight,
        mapHeight;
    height = $(window).height();
    sliderHeight = $('#month_select').height();
    eventHeight = height - 150;
    mapHeight = height - 150 - sliderHeight;

    $('#events').height(eventHeight);
    $('#map').height(mapHeight);
    //reduce slider width to a third of map width
    $('#month_select').width($('#map').width() / 2);
}

function initMap() {
    "use strict";
    var d,
        newui,
        i,
        html,
        d3,
        dateParts;
    d = new Date();
    if (!document.getElementById("events")) {
        return;
    }
	infoWindow = new google.maps.InfoWindow();
    $('#events').addClass('javascriptEnabled');
    $('#events').before('<div id="map-container"><div id="map"></div></div>');

    //filterEventList(d.getMonth()); //month 1-12
    //filterMap(d.getMonth()); //month 1-12
    $('#selected_month').html(monthName(d.getMonth())); //month 1-12
    $('#month_select').show();

    //"#slider").slider('value',50);
    clearMap();
    /*
     $("ol").click( function( event ) {
     $("#display").text(event.target.title);
     });
     */

    //maxmonth=7-(d.getMonth());  //start at 5 for Feb to 1 in June
    $('#date_slider').slider({
        handle: '.handle',
        steps: 6,
        min: 1,
        max: 6,
        startValue: 1,
        slide: function (e, ui) {

	    //ui is the slider value 1 to 5
            //add on x to conver to months 1-12 eg if 1st Month is Nov add 10, then mod 12
            // Changing the label to the selected monthname
       	    newui = ((ui.value + 9) % 12);
            
            if (newui === 0) {
                newui = 12;
            }
            $('#selected_month').html(monthName(newui));
            //            newui = (d.getMonth()); //1-12
            //newui = (ui.value+1); Nov 2010
            //            if (newui==0)
            //                {newui=12};
            // $('#selected_month').html(monthName(newui));
            // filtering event list
            clearMap();
            filterEventList(newui);

            // filtering markers on map
            filterMap(newui);
            //deleteOverlays();
            //drawevents(events, map, infoWindow, newui); called in initmap
        },
        change: function (e, ui) {

        }
    });
    map = new google.maps.Map(document.getElementById("map"), {

        center: new google.maps.LatLng(51.596481, 0.009785),
        //normally 9
        zoom: 9,
        mapTypeId: 'roadmap',
        streetViewControl: true,
        scaleControl: true
    });

    //retrieves all elements marked with class = "VEVENT
    events = $('.vevent');

    // for all events -JC
    for (i = 0; i < events.length; i += 1) {

        // Extrahera koordinater
        events[i].latitude = $(events[i]).find('.latitude').html();
        events[i].longitude = $(events[i]).find('.longitude').html();

        // H\E4mtar namn och beskrivning av eventet
        events[i].summary = $(events[i]).find('.summary').html();
        events[i].Description = $(events[i]).find('.Description').html();
        events[i].Distance = $(events[i]).find('.Distance').html();
        events[i].Grade = $(events[i]).find('.Grade').html();
        events[i].GridRef = $(events[i]).find('.GridRef').html();
        events[i].MapGridRef = $(events[i]).find('.MapGridRef').html();

        // Extraherar start- och slutdatum
        events[i].dtstart = $(events[i]).find('.dtstart').html();
        events[i].StartTime = $(events[i]).find('.StartTime').html();
        events[i].Exp = $(events[i]).find('.Exp').html();
        //events[i].dtend =  $(events[i]).find('.dtend').html();
        events[i].dtstartISO = $(events[i]).find('.dtstartISO').html();

        events[i].id = i;
        //If I have the coordinates so do I add them as points on the map
        if (events[i].latitude && events[i].longitude) {

            //Creates a point in Google Maps
            //var point = new google.maps.LatLng(events[i].latitude, events[i].longitude);  *** 14 Nov 2010
            //Using the extracted information to create an "information bubble"
            html = '&lt;h4&gt;' + events[i].summary + '&lt;/h4&gt;';
            html += '&lt;p class="dates"&gt;' + events[i].dtstart + ' <b>xxTimexx:</b> ' + events[i].Startime + '</p>';
            html += '<p>' + events[i].Description + '</p><br>';
            html += '<p><a href=\"http://streetmap.co.uk/grid/' + events[i].MapGridRef + '\" target=\"_blank\" >' + events[i].GridRef + '</a><br><br>';
            html += 'Explorer Map: ' + events[i].Exp + '<br>';

            events[i].html = html;
            drawevents(events, map, infoWindow, i);
            //            var d = new Date(marker.dtstart.replace(/-/g, '/'));
            //var d = dateParse2(events[i].dtstart); //.replace(/-/g, '/'));
            d3 = (events[i].dtstartISO); //yyyy-mm-dd format
            dateParts = d3.split("-");
            //         }
        } //if
    } //for
    adjustElementHeights();
    $(window).resize(function () {
        adjustElementHeights();
    });
} //initmap
// Returns the monthname
// Function for adjusting the height of the list and the map according to the available browser size.
$(document).ready(function () {
    "use strict";
    $('#events .Description, #events .geo, #events .vcard, #events .dtstartISO').hide();
    initMap();

    //set slider caption to this month
    //filterEventList(d1.getMonth()); //  commented 9/1/2011
    //filterMap(d1.getMonth()); //commented 28 dec 14:32
    //drawevents(events, map, infoWindow, d1.getmonth); //commented 9/1/2011
    $('#selected_month').html(monthName((d1.getMonth()) + 1,10)); //month 1-12
    ui = setUI2((d1.getMonth()) + 1,10); //month 1-12, eg 7 start slider in July
    $('#date_slider').slider('value', ui);
//    $('#date_slider').slider('value', ui);
    // filtering event list
    filterEventList((d1.getMonth()) + 1); //
    clearMap(); //commented 9/1/2011
    // filtering markers on map
    //clearMap();
    filterMap((d1.getMonth() + 1)); // c9/1/2010
});


