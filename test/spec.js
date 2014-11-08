describe('create incident function', function() {
	var reporterNameUI = element(by.id('txtReporterName'));
	var nricUI = element(by.id('txtNRIC'));
	var mobileNoUI = element(by.id('txtMobileNo'));
	var addressUI = element(by.id('txtAddress'));
	var typeUI = element(by.id('cboTypeOfAssistance'));
	var incidentNameUI = element(by.id('txtIncidentName'));
	var incidentDescriptionUI = element(by.id('txtIncidentDescription'));
	var priorityUI = element(by.id('cboPriority'));

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

	// it('should add one and two', function() {
	// 	firstNumber.sendKeys(1);
	// 	secondNumber.sendKeys(2);

	// 	goButton.click();

	// 	expect(latestResult.getText()).toEqual('3');
	// });

	// it('should add four and six', function() {
	// 	// Fill this in.
	// 	firstNumber.sendKeys(4);
	// 	secondNumber.sendKeys(6);

	// 	goButton.click();

	// 	expect(latestResult.getText()).toEqual('10');
	// });
});