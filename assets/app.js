/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
const $ = require('jquery');

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './bootstrap.js';
// start the Stimulus application
import 'bootstrap/dist/js/bootstrap.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';

const axios = require('axios');

function onClickFavoris(event) {

    event.preventDefault();
    let url = this.href;
    var fav = this.querySelector("i");

    axios.get(url)
        .then(function(response) {
            let favoris = response.data.nombre;

            if (fav.classList.contains("fas")) {
                console.log("fas");
                fav.classList.replace("fas", "far")
            } else {
                console.log("far");
                fav.classList.replace("far", "fas")
            }
        })
        .catch(function(error) {
            if (error.response.status === 403) {
                $('#myModal').removeClass('myClassHide');
                $('#myModal').addClass('myClassShow');
                console.log('error 2');
            }

        })
        .then(function() {

        });

}

document.querySelectorAll("a.js-favoris").forEach(function(link) {
    link.addEventListener("click", onClickFavoris)
});