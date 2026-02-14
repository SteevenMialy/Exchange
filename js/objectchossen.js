let chosenPrice = null;

const targetInput = document.getElementById("targetId");
const possessorInput = document.getElementById("possessorId");


const baseUrl = (window.BASE_URL || "").replace(/\/$/, "");

document.querySelectorAll(".choosen-btn").forEach(btn => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();

        let id = this.dataset.id;
        if (!id) {
            return;
        }


        fetch(baseUrl + "/exchange/chossen/" + id)
            .then(res => res.json())
            .then(data => {

                chosenPrice = parseFloat(data.prix);

                // afficher l'objet choisi
                let container = document.getElementById("objectChosenContainer");

                let imgHtml = data.image
                    ? `<img src="${baseUrl}/uploads/object/${data.image}" class="img-thumbnail me-3" style="width:80px;height:80px;object-fit:cover;">`
                    : `<div class="img-thumbnail me-3" style="width:80px;height:80px;">Aucune</div>`;

                container.innerHTML = `
                    <ul class="list-group mt-3">
                        <li class="list-group-item d-flex align-items-center">
                            ${imgHtml}
                            <div class="flex-grow-1 ml-4">
                                ${data.obj_name}
                            </div>
                            <div class="ms-3">
                                Prix : ${data.prix}€
                            </div>
                        </li>
                    </ul>
                `;

                targetInput.value = data.id;
                possessorInput.value = data.id_owner;

                // calcul bénéfice / perte
                document.querySelectorAll(".object-item").forEach(item => {
                    let prixObjet = parseFloat(item.dataset.prix);
                    let resultSpan = item.querySelector(".result");

                    let diff = prixObjet - chosenPrice;

                    if (diff > 0) {
                        resultSpan.innerHTML = ` <span class="text-danger">Perte : ${diff}€</span>`;
                    } else if (diff < 0) {
                        resultSpan.innerHTML = ` <span class="text-success">Bénéfice : ${-1*diff}€</span>`;
                    } else {
                        resultSpan.innerHTML = ` <span class="text-secondary">Égalité</span>`;
                    }
                });
            })
            .catch(err => console.error("Erreur:", err));
    });
});

document.querySelectorAll(".details-btn").forEach(btn => {
    btn.addEventListener("click", function () {
        const id = this.dataset.id;
        if (!id) {
            return;
        }

        const baseUrl = (window.BASE_URL || "").replace(/\/$/, "");
        const detailsRow = document.getElementById("detailsRow" + id);
        if (!detailsRow) {
            return;
        }

        const isOpen = !detailsRow.classList.contains("d-none");
        if (isOpen) {
            detailsRow.classList.add("d-none");
            return;
        }

        detailsRow.classList.remove("d-none");

        if (detailsRow.dataset.loaded === "1") {
            return;
        }

        fetch(baseUrl + "/api/object/" + id)
            .then(res => res.json())
            .then(data => {
                if (!data) {
                    detailsRow.innerHTML = `<div class="text-danger small">Objet introuvable.</div>`;
                    return;
                }

                const pictures = Array.isArray(data.pictures) ? data.pictures : [];
                const thumbs = pictures.slice(0, 3).map(p => {
                    const safe = String(p).replace(/"/g, "&quot;");
                    return `<img src="${baseUrl}/uploads/object/${safe}" alt="" class="img-thumbnail" style="width:70px;height:70px;object-fit:cover;">`;
                }).join("");

                const categoryHtml = data.category ? `<span class="badge bg-primary">${data.category}</span>` : ``;
                const ownerHtml = data.owner ? `<div class="small text-muted">Possesseur : ${data.owner}</div>` : ``;
                const descriptHtml = data.descript ? `<div class="small text-muted">${String(data.descript).replace(/\n/g, "<br>")}</div>` : `<div class="small text-muted">Aucune description.</div>`;

                detailsRow.innerHTML = `
                    <div class="d-flex align-items-start" style="gap: 12px;">
                        <div class="d-flex" style="gap: 8px; flex-wrap: wrap;">
                            ${thumbs || `<div class="text-muted small">Aucune image.</div>`}
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center" style="gap: 10px; flex-wrap: wrap;">
                                <div class="font-weight-semi-bold">${data.obj_name || ""}</div>
                                ${categoryHtml}
                                <div class="small text-muted">Prix : ${data.prix}€</div>
                            </div>
                            <div class="mt-2">
                                ${descriptHtml}
                                ${ownerHtml}
                            </div>
                        </div>
                    </div>
                `;

                detailsRow.dataset.loaded = "1";
            })
            .catch(() => {
                detailsRow.innerHTML = `<div class="text-danger small">Erreur lors du chargement.</div>`;
            });
    });
});

var exchangeForm = document.getElementById("exchangeForm");

exchangeForm.addEventListener("submit", function (e) {
    e.preventDefault();

    if(!targetInput.value || !possessorInput.value) {
        alert("Veuillez choisir un objet à échanger.");
        return;
    }

    var fd = new FormData(this);
    fetch(baseUrl + "/propose", {
        method: "POST",
        body: fd
    })
    .then(response => {
        if (response.ok) {
            let rep = response.json();
            rep.then(data => {
                if (data.success && confirm(data.message + "\nVoulez-vous retourner à l'accueil ?")) {
                    window.location.href = baseUrl + "/home";
                } else {
                    alert("Erreur lors de l'échange.");
                }
            });
        } else {
            alert("Erreur lors de l'échange.");
        }
    })
    .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur lors de l'échange.");
    });
});