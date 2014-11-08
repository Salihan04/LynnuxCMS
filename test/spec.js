describe('create incident function', function() {
	if(typeof(String.prototype.trim) === "undefined")
	{
	    String.prototype.trim = function() 
	    {
	        return String(this).replace(/^\s+|\s+$/g, '');
	    };
	}

	var reporterNameUI = element(by.id('txtReporterName'));
	var nricUI = element(by.id('txtNRIC'));
	var mobileNoUI = element(by.id('txtMobileNo'));
	var addressUI = element(by.id('txtAddress'));
	var typeUI = element(by.id('cboTypeOfAssistance'));
	var incidentNameUI = element(by.id('txtIncidentName'));
	var incidentDescriptionUI = element(by.id('txtIncidentDescription'));
	var priorityUI = element(by.id('cboPriority'));
	var submitButton = element(by.id('submit'));

	var window;
	var Parse;

	beforeEach(function() {
		browser.get('http://localhost/CallCenter/createincident.php');
	});

	it('should have a correct title', function() {
		expect(browser.getTitle()).toEqual('Create Incident');
	});

	it('should have fulfill all precondition', function() {
		expect(reporterNameUI).not.toEqual(null);
		expect(nricUI).not.toEqual(null);
		expect(mobileNoUI).not.toEqual(null);
		expect(addressUI).not.toEqual(null);
		expect(typeUI).not.toEqual(null);
		expect(incidentNameUI).not.toEqual(null);
		expect(incidentDescriptionUI).not.toEqual(null);
		expect(priorityUI).not.toEqual(null);
	});

	it('should be able to create new incident with all valid inputs', function() {
		var reporterName = "Andy Chong";
		var nric = "abcde12345";
		var mobileNumber = "+6583937419";
		var address = "Some address here";
		var type = "Emergency Ambulance";
		var incidentName = "Dengue";
		var incidentDescription = "My son get dengue, he is dying soon!";
		var priority = "1";

		reporterNameUI.sendKeys(reporterName);
		nricUI.sendKeys(nric);
		mobileNoUI.sendKeys(mobileNumber);
		addressUI.sendKeys(address);
		typeUI.sendKeys(type);
		incidentNameUI.sendKeys(incidentName);
		incidentDescriptionUI.sendKeys(incidentDescription);
		priorityUI.sendKeys(priority);

		submitButton.click();

		var exec = require('child_process').exec;
		exec('python testReporter.py', function (error, stdout, stderr) {
			expect(stdout).not.toEqual('');
			var reporterObjectId = stdout.trim()

			exec('python testIncident.py', function (error, stdout, stderr) {
				expect(stdout).not.toEqual('');
				var incidentObjectId = stdout.trim()
			});
		});

	});

});