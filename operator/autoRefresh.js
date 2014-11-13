var markers = [];
var tick = 10000;

Parse.initialize("qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW", "GBGfnA0ZvD52vPdKpsaNFQA4y2JIJkbmCDSc3JHF");

Initializer = {
	init : function init(){
		Initializer.refresh();
		window.setInterval(function autoRefresh(){
			Initializer.refresh();
		}, tick);
	

	},
	refresh : function refresh(){

		//called from the timer

		var Incident = Parse.Object.extend("CacheIncident");
		var query = new Parse.Query(Incident);

		var tbody = document.createElement("tbody");

		for(i=0; i<markers.length; i++) {
			markers[i].setMap(null);
		}
		markers = [];

		tbody.setAttribute("id","incident_body")
		query.find({
			success: function(incidents) {
				// The object was retrieved successfully.
				for (var i = 0; i < incidents.length; i++) { 
					var incident = incidents[i];
					var id = incident.get("incidentId");
					console.log(id);

					var name = incident.get("name");
					var description = incident.get("description");
					var status = incident.get("status");
					var location = incident.get("location");
					var resource = incident.get("resource");

					var tr = document.createElement("tr");
					tr.onclick = (function(argsId){
						return function innerFunction(){
							window.document.location='incidentDetail.php?id='+argsId;
						}
					})(id);

					var tdName = document.createElement("td");
					tdName.innerHTML = name;

					var tdDescription = document.createElement("td");
					tdDescription.innerHTML = description==undefined?"":description;

					var tdStatus = document.createElement("td");
					tdStatus.innerHTML = status==undefined?"":status;

					var tdLocation = document.createElement("td");
					tdLocation.innerHTML = location==undefined?"":location;

					var tdResource = document.createElement("td");

					if(resource==undefined){
                        var button = document.createElement("button");
                        button.setAttribute("type","button");
                        button.setAttribute("class","btn btn-primary btn-md");
                        button.setAttribute("onclick","location.href='assignResource.php?incident="+id+"'");
                        button.innerHTML = "assign resource";
                        tdResource.appendChild(button);
					}else{
						tdResource.innerHTML = resource;
					}

					tr.appendChild(tdResource);
					tr.appendChild(tdName);
					tr.appendChild(tdStatus);
					tr.appendChild(tdDescription);
					tr.appendChild(tdLocation);
					tr.appendChild(tdResource)
					tbody.appendChild(tr);

					incident_table = document.getElementById("incident_table");
					incident_body = document.getElementById("incident_body");
					incident_table.removeChild(incident_body);
					incident_table.appendChild(tbody);

					var latlong = location.split(" ");

					// adding marker
					var contentString = '<div id="content">' + '<h1>' + name + '</h1>' + '<div id="bodyContent">' + '<p>' + description + '</p>' + '</div>' + '<div>';

				    var infowindow = new google.maps.InfoWindow({
				        content: contentString,
				        maxWidth: 300
				    });

				    var markerLatLng = new google.maps.LatLng(parseFloat(latlong[0]), parseFloat(latlong[1]));

				    var marker = new google.maps.Marker({
				        position: markerLatLng,
				        map: map,
				        title: name,
				        width: window.innerWidth
				    });

				    markers.push(marker);

				    google.maps.event.addListener(marker, 'click', function() {
				        infowindow.open(map, marker);
				    });

				}
			},
			error: function(object, error) {
				// The object was not retrieved successfully.
				// error is a Parse.Error with an error code and message.
			}
		});
	
	}
}