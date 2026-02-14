const baseUrl = (window.BASE_URL || "").replace(/\/$/, "");

function acceptProposal(id) {
    alert("Proposition acceptée !");
    /* fetch(baseUrl + "/api/proposal/accept/" + id, {
        method: "GET"
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Proposition acceptée !");
            location.reload();
        } else {
            alert("Erreur : " + (data.error || "Une erreur est survenue"));
        }
    })
    .catch(err => console.error("Erreur:", err)); */
}