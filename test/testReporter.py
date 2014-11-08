from parse_rest.connection import register
from parse_rest.datatypes import Object
import time
register("qjArPWWC0eD8yFmAwRjKkiCQ82Dtgq5ovIbD5ZKW", "9Yl2TD1DcjR6P1XyppzQ9NerO6ZwWBQnpQiM0MkL")

class Reporter(Object):
    pass

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
reporter = Reporter.Query.all()

for r in reporter:
	if(r.name==reporterName and
		r.NRIC == nric and
		r.mobile_no == mobileNumber and
		r.address == address and
		r.typeOfAssistance == typeAssistance):
		r.delete()
		print(r.objectId)
		break