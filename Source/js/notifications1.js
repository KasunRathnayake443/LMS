const queryString = window.location.search;
const urlParams = new URLSearchParams(queryString);

const alertMappings = [
  { param: "notifications1", elementId: "alertBox" },
  { param: "notifications2", elementId: "alertBox2" },
  { param: "login_error", elementId: "alertBox" },
  { param: "success_message", elementId: "alertBoxSuccess" },
  { param: "notifications3", elementId: "alertBox3" },
  { param: "notifications4", elementId: "alertBox4" },
];

alertMappings.forEach((mapping) => {
  if (urlParams.has(mapping.param)) {
    const alertElement = document.getElementById(mapping.elementId);
    if (alertElement) {
      alertElement.style.display = "block";

      setTimeout(function () {
        alertElement.style.display = "none";
      }, 5000);
    }
  }
});
