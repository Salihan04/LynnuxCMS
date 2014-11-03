Parse.initialize("qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW", "GBGfnA0ZvD52vPdKpsaNFQA4y2JIJkbmCDSc3JHF");
var tick = 10000;

function createLabel(key,value){
	var label = document.createElement("label");
	label.setAttribute("class","col-sm-2");
	label.innerHTML = key;
	var p = document.createElement("p");
	p.setAttribute("class","col-sm-10");
	p.innerHTML = value;

	var div = document.createElement("div");
	div.appendChild(label);
	div.appendChild(p);
	return div;
}

function createH2(value){
	var h2 = document.createElement("h2");
	h2.innerHTML = value;
	return h2;
}

function createTh(value){
	var th = document.createElement("th");
	th.innerHTML = value;
	return th;
}

function createTd(value){
	var td = document.createElement("td");
	td.innerHTML = value;
	return td;
}

function getAllObjectIdofParseObject(array){
	console.log(array);
	var objectId;
	for(var i=0;i<array.length;i++){
		objectId[i] = array[i].id;
	}
	return objectId;
}

var Event = Parse.Object.extend("Event");
var Incident = Parse.Object.extend("Incident");
var Resource = Parse.Object.extend("Resource");


function refresh(){
	var query = new Parse.Query(Event);

	var eventbody = document.getElementById("event");
	while (eventbody.firstChild) {
	    eventbody.removeChild(eventbody.firstChild);
	}

	query.find().then(function(results){
		if(results.length>0){

			//A LIST OF EVENT
			for (var i = 0; i < results.length; i++) { 
				var eventNameLabel = createH2(results[i].get("name"));
				eventbody.appendChild(eventNameLabel);

				var div1 = document.createElement("div");
				div1.setAttribute("class","table-responsive");

				//create table
				var incidentTable = document.createElement("table");
				incidentTable.setAttribute("class","table table-striped table-hover");
				incidentTable.setAttribute("id","event_table");
				div1.appendChild(incidentTable);
				

				//create table header
				var thead = document.createElement("thead");
				incidentTable.appendChild(thead);
				var tr = document.createElement("tr");
				tr.appendChild(createTh("Name"));
				tr.appendChild(createTh("Status"));
				tr.appendChild(createTh("Description"));
				tr.appendChild(createTh("Location"));
				tr.appendChild(createTh("Resources"));
				thead.appendChild(tr);

				incidentsQuery = results[i].relation("incidents").query();
				incidentsQuery.find().then((function(table){
					return function(results){
						var tbody = document.createElement("tbody");

						//A LIST OF INCIDENT
						for (var i = 0; i < results.length; i++){
							var tr = document.createElement("tr");
							tr.onclick = (function(argsId){
								return function innerFunction(){
									window.document.location='incidentDetail.php?id='+argsId;
								}
							})(results[i].id);

							tr.appendChild(createTd(results[i].get("name")));
							tr.appendChild(createTd(results[i].get("status")));
							tr.appendChild(createTd(results[i].get("description")));

							var location = results[i].get("location");
							if(location!=null){
								location = location._latitude+" "+location._longitude;
							}
							tr.appendChild(createTd(location));

							var tdResource = document.createElement("td");
							tdResource.setAttribute("id","resource"+results[i].id);
							tr.appendChild(tdResource);

							var AssignResource = Parse.Object.extend("AssignResource");
							var resourseQuery = new Parse.Query(AssignResource);
							resourseQuery.equalTo("incident",results[i]);

							var promise = resourseQuery.find();
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
											button.setAttribute("class","btn btn-primary btn-md");
											button.setAttribute("onclick","location.href='assignResource.php?incident="+j+"'");
											button.innerHTML = "assign resource";
											document.getElementById("resource"+j).appendChild(button);
										}
									}
								})(results[i].id));
							tbody.appendChild(tr);
							
						}
						table.appendChild(tbody);
					};
				})(incidentTable));

				
				var div2 = document.createElement("div");
				div2.setAttribute("class","table-responsive");

				//create table
				var organizationsTable = document.createElement("table");
				organizationsTable.setAttribute("class","table table-striped table-hover");
				organizationsTable.setAttribute("id","resource_table");
				div2.appendChild(organizationsTable);
				

				//create table header
				var thead2 = document.createElement("thead");
				organizationsTable.appendChild(thead2);
				var tr2 = document.createElement("tr");
				tr2.appendChild(createTh("Name"));
				tr2.appendChild(createTh("Description"));
				thead2.appendChild(tr2);

				organizationsQuery = results[i].relation("organizations").query();
				organizationsQuery.find().then((function(table){
					return function(results){
						var tbody = document.createElement("tbody");

						//A LIST OF INCIDENT
						for (var i = 0; i < results.length; i++){
							var tr = document.createElement("tr");

							tr.appendChild(createTd(results[i].get("name")));
							tr.appendChild(createTd(results[i].get("description")));

							tbody.appendChild(tr);

						}
						console.log(tbody);
						table.appendChild(tbody);
					};
				})(organizationsTable));

				eventbody.appendChild(div1);
				eventbody.appendChild(div2);
			}

		}else{
			return;
		}
	});

}

// <table class="table table-striped table-hover" id="incident_table">
//               <thead>
//                 <tr>
//                   <th>Name</th>
//                   <th>Status</th>
//                   <th>Description</th>
//                   <th>Location</th>
//                   <th>Resources</th>
//                 </tr>
//               </thead>
//               <tbody id="incident_body">
//               </tbody>
//             </table>

function initialize(){
	refresh();
	window.setInterval(function autoRefresh(){
		refresh();
	}, tick);
}
