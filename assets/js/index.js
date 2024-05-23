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
  
  
  