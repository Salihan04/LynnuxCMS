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

function refresh(){
	var Event = Parse.Object.extend("Event");
	var query = new Parse.Query(Event);

	var eventbody = document.getElementById("event");

	query.find().then(function(results){
		if(results.length>0){
			while (eventbody.firstChild) {
			    eventbody.removeChild(eventbody.firstChild);
			}			

			for (var i = 0; i < results.length; i++) { 
				var eventNameLabel = createLabel("Name",results[i].get("name"));
				eventbody.appendChild(eventNameLabel);

				// var table = document.createElement("table");
				// table.setAttribute("class","table table-striped table-hover");
				// table.setAttribute("event_table");

				// var thead = document.createElement("thead");
				// table.appendChild(thead);

				// var tr = document.createElement("tr");

				// var thName = document.createElement("th");
				// thName.innerHTML = 

			}
		}else{

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
