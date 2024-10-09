const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

// Define an array of alert parameters and corresponding element IDs
const alertMappings = [
    { param: 'notifications1', elementId: 'alertBox' },
    { param: 'notifications2', elementId: 'alertBox2' },
    { param: 'success_message', elementId: 'alertBoxSuccess' },
    // Add more mappings as needed for other alerts
];

// Iterate through each mapping and check if the corresponding parameter exists in the URL
alertMappings.forEach(mapping => {
    const alertValue = urlParams.get(mapping.param);
    if (alertValue) {
        // If the parameter exists, show the corresponding alert box
        const alertElement = document.getElementById(mapping.elementId);
        if (alertElement) {
            alertElement.style.display = 'block';
            
            // Hide the alert box after 5 seconds
            setTimeout(function() {
                alertElement.style.display = 'none';
            }, 5000);
        }
    }
});
