document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#registerForm");
  if (!form) return;

  const statusBox = document.querySelector("#formStatus");
  const stautCon = 0;

  const map = {
    username: { input: "#username", err: "#usernameError" },
    password: { input: "#password", err: "#passwordError" },
  };

  function setStatus(type, msg) {
    if (!statusBox) return;
    if (!msg) {
      statusBox.className = "alert d-none";
      statusBox.textContent = "";
      return;
    }
    statusBox.className = `alert alert-${type}`;
    statusBox.textContent = msg;
  }

  function clearFeedback() {
    Object.keys(map).forEach((k) => {
      const input = document.querySelector(map[k].input);
      const err = document.querySelector(map[k].err);
      input.classList.remove("is-invalid", "is-valid");
      if (err) err.textContent = "";
    });
    setStatus(null, "");
  }

  function applyServerResult(data) {
    // 1) Appliquer valeurs normalisées (ex: téléphone sans espaces)
    

    // 2) Appliquer erreurs / états
    Object.keys(map).forEach((k) => {
      const input = document.querySelector(map[k].input);
      const err = document.querySelector(map[k].err);
      const msg = data.errors?.[k] || "";

      if (msg) {
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
        if (err) err.textContent = msg;
      } else {
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
        if (err) err.textContent = "";
      }
    });

    // 3) Message global si besoin
    if (data.errors?._global) {
      setStatus("warning", data.errors._global);
    }
  }

  async function callValidate() {
    const fd = new FormData(form);
    const baseUrl = form.getAttribute('action').replace('/login', '');
    const res = await fetch(baseUrl + "/api/validate/login", {
      method: "POST",
      body: fd,
      headers: { "X-Requested-With": "XMLHttpRequest" },
    });

    if (!res.ok) throw new Error("Erreur serveur lors de la validation.");
    return res.json();
  }

  function hasErrors(errors) {
    return Object.values(errors).some((error) => error !== "");
  }

  form.addEventListener("submit", async (e) => {
    e.preventDefault();
    clearFeedback();
    try {
      const data = await callValidate();
      applyServerResult(data);
      
      if (data.ok && !hasErrors(data.errors)) {
        setStatus("success", "Validation OK ✅ Connexion en cours...");

        // Envoyer le login via fetch pour gérer la réponse JSON
        const fd = new FormData(form);
        const loginRes = await fetch(form.getAttribute('action'), {
          method: "POST",
          body: fd,
          headers: { "X-Requested-With": "XMLHttpRequest" },
        });

        // Si redirection (login réussi), on suit la redirection
        if (loginRes.redirected) {
          window.location.href = loginRes.url || "/home";
          return;
        }

        // Vérifier si la réponse est du JSON
        const contentType = loginRes.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
          const loginData = await loginRes.json();
          if (loginData.ok === false) {
            applyServerResult(loginData);
            setStatus("danger", loginData.errors?.password || "Nom d'utilisateur ou mot de passe incorrect.");
          } else if (loginData.ok === true) {
            // Login réussi, rediriger
            window.location.href = loginData.redirect || "/home";
          }
        } else {
          // Réponse non-JSON, probablement une page HTML de succès
          window.location.href = "/home";
        }
      } else {
        setStatus("danger", "Veuillez corriger les erreurs.");
      }
    } catch (err) {
      setStatus("warning", err.message || "Une erreur est survenue.");
        //alert("Validation en cours catch  ...");

    }
  });

  // Optionnel : validation au blur (moins de spam que input)
  Object.keys(map).forEach((k) => {
    const input = document.querySelector(map[k].input);
    input.addEventListener("blur", async () => {
      try {
        const data = await callValidate();
        applyServerResult(data);
      } catch (_) {}
    });
  });
});