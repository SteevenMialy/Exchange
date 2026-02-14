const baseUrl = (typeof BASE_URL !== 'undefined' ? BASE_URL : "").replace(/\/$/, "");

function acceptProposal(id) {
    if (confirm("Êtes-vous sûr d'accepter cette proposition ?")) {
        fetch(baseUrl + "/propose/accept/" + id, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert("Erreur lors de l'acceptation de la proposition.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Erreur lors de l'acceptation de la proposition.");
            });
    }
}

function refuseProposal(id) {
    if (confirm("Êtes-vous sûr de refuser cette proposition ?")) {
        fetch(baseUrl + "/propose/refuse/" + id, {
            method: "GET"
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert("Erreur lors du refus de la proposition.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Erreur lors du refus de la proposition.");
            });
    }
}

function seedetails(id) {
    window.location.href = baseUrl + "/propose/details/" + id;
}