let url = "http://localhost:8000/traitement.php";

let patronyme = document.querySelector("#patronyme");
let numpro = document.querySelector("#numpro");
let portable = document.querySelector("#portable");
let telephone = document.querySelector("#telephone");
let adresse = document.querySelector("#adresse");

let fetchbyid = (id) => {
    fetch(`${url}?id=${id}`)
        .then(response => response.json())
        .then(response => {
            patronyme.textContent = `${response.prenom} ${response.nom}`
            numpro.textContent = response.numero_pro
            portable.textContent = 0 + response.tel_pro.toString().replace(/\B(?=(\d{2})+(?!\d))/g, ' ')
            telephone.textContent = 0 + response.tel_perso.toString().replace(/\B(?=(\d{2})+(?!\d))/g, ' ')
            adresse.textContent = `${response.numero} ${response.rue} ${response.cp} ${response.ville}`

        })
        .catch(err => {
            console.error(err)
        })
}

let exampleModal = document.getElementById('exampleModal')

exampleModal.addEventListener('show.bs.modal', function (event) {

    let button = event.relatedTarget

    let idinfirmier = button.getAttribute('data-bs-id')

    fetchbyid(idinfirmier);

})