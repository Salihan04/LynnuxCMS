from parse_rest.connection import register
from parse_rest.datatypes import Object
import time
register("qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW", "9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL")

class Incident(Object):
    pass

reporterName = "Andy Chong"
nric = "abcde12345"
mobileNumber = "+6583937419"
address = "Some address here"
typeAssistance = "Emergency Ambulance"
incidentName = "Dengue"
incidentDescription = "My son get dengue, he is dying soon!"
priority = "1"

time.sleep(5)
incident = Incident.Query.all()

for r in incident:
	if(r.name==incidentName and
		r.description == incidentDescription and
		r.priority == priority):
		r.delete()
		print(r.objectId)
	break