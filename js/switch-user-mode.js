var button = document.getElementById("switch");
var errorBox = document.getElementById("authError");
var divaut = document.getElementById("authentification");

function showAuthError(message) {
    if (!errorBox || !divaut) { console.error("Error box or authentication div not found."); return; }
    divaut.style.display = "block";
    errorBox.textContent = message;
    errorBox.style.display = "block";
    errorBox.classList.add("alert", "alert-danger");
    errorBox.setAttribute("role", "alert");
    errorBox.setAttribute("aria-live", "assertive");
    errorBox.setAttribute("aria-atomic", "true");
    errorBox.setAttribute("aria-hidden", "false");
}

function clearAuthError() {
    // Remove error styles and clear the error message
    if (errorBox) {
        errorBox.classList.remove("alert", "alert-danger");
        errorBox.removeAttribute("role");
        errorBox.removeAttribute("aria-live");
        errorBox.removeAttribute("aria-atomic");
        errorBox.removeAttribute("aria-hidden");
        errorBox.textContent = "";
        errorBox.style.display = "none";
    }

    // Ensure the authentication form remains visible
    if (divaut) {
        divaut.style.display = "block";
    }
}

if (button) {
    button.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default form submission
        clearAuthError();
        var form = document.getElementById("authForm");
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", form.action, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                var response = null;
                try {
                    response = JSON.parse(xhr.responseText || "{}");
                } catch (e) {
                    response = null;
                }

                if (xhr.status === 200 && response && response.success) {
                    window.location.href = response.redirectUrl;
                    return;
                }

                if (response && response.error) {
                    showAuthError(response.error);
                } else {
                    showAuthError("Une erreur est survenue. Veuillez réessayer.");
                }
            }
        };
        xhr.send(formData);
    });
}