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

const admin = document.getElementById("adminLink");
const simpleUserLink = document.getElementById("simpleUserlink");
const homeAdmin = document.getElementById("adminHome");
const homeSimpleUser = document.getElementById("usersimpleHome");

// Appliquer l'état sauvegardé au chargement de la page
function applyUserMode() {
    const isAdminMode = sessionStorage.getItem("isAdminMode");
    if (admin && simpleUserLink) {
        if (isAdminMode === "true") {
            admin.classList.add("d-none");
            simpleUserLink.classList.remove("d-none");
            homeAdmin.classList.remove("d-none");
            homeSimpleUser.classList.add("d-none");
        } else {
            admin.classList.remove("d-none");
            simpleUserLink.classList.add("d-none");
            homeAdmin.classList.add("d-none");
            homeSimpleUser.classList.remove("d-none");
        }
    }
}

// Appliquer l'état au chargement
applyUserMode();

function openAuth() {
    //document.getElementById("password").value = "";
    document.getElementById("authentification").style.display = "block";
    document.getElementById("overlay").style.display = "block";
}

function closeAuth() {
    document.getElementById("authentification").style.display = "none";
    document.getElementById("overlay").style.display = "none";
}

/* script de validation */
function handleAuthSubmit(event) {
    event.preventDefault();
    const password = document.getElementById("password").value;
    if (password.trim() === "") {
        alert("Please enter a password.");
        return;
    }
    // Submit the form
    document.getElementById("authForm").submit();
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
                    sessionStorage.setItem("isAdminMode", "true");
                    closeAuth();
                    window.location.href = response.redirectUrl;
                } else if (response && response.error) {
                    showAuthError(response.error);
                } else {
                    const errorMessage = `Une erreur est survenue. Code d'erreur: ${xhr.status}`;
                    showAuthError(errorMessage);
                }
            }
        };
        xhr.send(formData);
    });
}

if (simpleUserLink) {
    simpleUserLink.addEventListener("click", function (event) {
        event.preventDefault();
        // Supprimer l'état admin du sessionStorage
        sessionStorage.setItem("isAdminMode", "false");
        window.location.href = simpleUserLink.href;
    });
}