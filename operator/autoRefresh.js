var tick = 10000;

Parse.initialize("qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW", "GBGfnA0ZvD52vPdKpsaNFQA4y2JIJkbmCDSc3JHF");

Initializer = {
	init : function init(){
		Initializer.refresh();
		// window.setInterval(function autoRefresh(){
		// 	Initializer.refresh();
		// }, tick);
	

	},
	refresh : function refresh(){

		//called from the timer

		var Incident = Parse.Object.extend("Incident");
		var query = new Parse.Query(Incident);

		var tbody = document.createElement("tbody");
		tbody.setAttribute("id","incident_body")
		query.find({
			success: function(incidents) {
				// The object was retrieved successfully.
				for (var i = 0; i < incidents.length; i++) { 
					var incident = incidents[i];
					var id = incident.id;
					var name = incident.get("name");
					var description = incident.get("description");
					var status = incident.get("status");
					var location = incident.get("location");
					if(location!=null){
						location = location._latitude+" "+location._longitude;
					}

					var reporter = incident.get("reporter");

					var tr = document.createElement("tr");
					tr.onclick = function(){
						window.document.location='#';
					};
					
					var a = document.createElement("a");

					var tdId = document.createElement("td");
					tdId.innerHTML = id;


					var tdName = document.createElement("td");
					tdName.innerHTML = name;

					var tdDescription = document.createElement("td");
					tdDescription.innerHTML = description;

					var tdStatus = document.createElement("td");
					tdStatus.innerHTML = status;

					var tdLocation = document.createElement("td");
					tdLocation.innerHTML = location;

					var tdResource = document.createElement("td");
					tdResource.setAttribute("id","resource"+id);
					tr.appendChild(tdResource);

					var tdReporter = document.createElement("td");
					if(reporter!=null){
						tdReporter.setAttribute("id","reporter"+reporter.id);
					}

					var tdCreated = document.createElement("td");
					tdCreated.innerHTML = incident.createdAt;
					console.log(incident.createdAt);

					tr.appendChild(tdId);
					tr.appendChild(tdName);
					tr.appendChild(tdStatus);
					tr.appendChild(tdDescription);
					tr.appendChild(tdLocation);
					tr.appendChild(tdResource)
					tr.appendChild(tdReporter);
					tr.appendChild(tdCreated);
					tbody.appendChild(tr);

					incident_table = document.getElementById("incident_table");
					incident_body = document.getElementById("incident_body");
					incident_table.removeChild(incident_body);
					incident_table.appendChild(tbody);

					var AssignResource = Parse.Object.extend("AssignResource");
					var resourseQuery = new Parse.Query(AssignResource);
					resourseQuery.equalTo("incident",incident);


					var promise = resourseQuery.find();
					promise.oid = id;

					promise = promise.then((function(j) {
				        return function innerFunction(results) { // inner function
								if(results.length>0){
									
									for(var k=0;k<results.length;k++){

										results[k].get("resource").fetch().then((function(kFake){
											return function innerFunction(result){
												var html = "";
												html += results[kFake].get("resource").get("name") + "&nbsp";
												document.getElementById("resource"+j).innerHTML += html;
											}
										})(k));
									}
								}
								else{
									var button = document.createElement("button");
									button.setAttribute("type","button");
									button.setAttribute("onclick","location.href='assignResource.php?incident="+j+"'");
									button.innerHTML = "assign resource";
									document.getElementById("resource"+j).appendChild(button);
								}
							}
						})(id));

					promise.oid = id;

					if(reporter != null){
						reporter.fetch().then(function(realReporter){
							document.getElementById("reporter"+realReporter.id).innerHTML = realReporter.get("username");
						});
					}


				}
			},
			error: function(object, error) {
				// The object was not retrieved successfully.
				// error is a Parse.Error with an error code and message.
			}
		});
	
	}
}