function display_custom_toast(message, message_type, seconds) {
  let bg = "";
  let color = "";
  if (message_type === "success") {
    bg = "green";
    color = "white";
  } else if (message_type === "danger") {
    bg = "red";
    color = "white";
  }

  var customMessage = document.getElementById("customMessage");
  var messageText = document.getElementById("messageText");
  messageText.textContent = message;

  customMessage.classList.add("show-message");
  customMessage.style.background = bg;
  customMessage.style.color = color;

  var closeButton = document.getElementById("closeButton");
  closeButton.addEventListener("click", function () {
    customMessage.classList.remove("show-message");
  });

  setTimeout(function () {
    customMessage.classList.remove("show-message");
  }, seconds);
}

function isValidEmail(email) {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(email);
}

function hideModal(modalId) {
  $("#" + modalId).modal("hide");
}

function formatDateTime(datetimeString) {
  // Parse the datetime string
  var datetime = new Date(datetimeString);

  // Months array
  var months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  // Get the components of the datetime
  var year = datetime.getFullYear();
  var month = months[datetime.getMonth()];
  var day = datetime.getDate();
  var hours = datetime.getHours();
  var minutes = datetime.getMinutes();
  var seconds = datetime.getSeconds();

  // Convert hours to 12-hour format
  var ampm = hours >= 12 ? "PM" : "AM";
  hours = hours % 12;
  hours = hours ? hours : 12; // Handle midnight (0 hours)

  // Format the datetime
  var formattedDatetime =
    month +
    " " +
    day +
    ", " +
    year +
    ", " +
    hours +
    ":" +
    (minutes < 10 ? "0" : "") +
    minutes +
    ":" +
    (seconds < 10 ? "0" : "") +
    seconds +
    " " +
    ampm;

  return formattedDatetime;
}

function removeTime(datetimeStr) {
  // Split the datetime string by commas
  let parts = datetimeStr.split(",");

  // Extract the month-day part and the year part
  let monthDayPart = parts[0].trim();
  let yearPart = parts[1].trim();

  // Combine the month-day and year parts
  let result = `${monthDayPart}, ${yearPart}`;

  return result;
}

function hideModal(modalId) {
  // Select the modal element by ID
  var $modal = $("#" + modalId);

  if ($modal.length) {
    // Hide the modal
    $modal.modal("hide");

    // Ensure the modal-backdrop elements are removed
    $(".modal-backdrop").remove();

    // Reset the body class and styles to remove modal-related styles
    $("body").removeClass("modal-open");
    $("body").css("padding-right", "");
  } else {
    console.error('Modal with ID "' + modalId + '" not found.');
  }
}

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}
