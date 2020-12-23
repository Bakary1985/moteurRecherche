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
const formInput = document.querySelector("#loginForm");
const searchParams = new URLSearchParams();
console.log(formInput)
function onClickFavoris(event) {

    event.preventDefault();
    let url = this.href;
    var fav = this.querySelector("i");

    axios.get(url)
        .then(function(response) {
            console.log(response)
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
                
            }

        })
        .then(function() {

        });

}

document.querySelectorAll("a.js-favoris").forEach(function(link) {
    link.addEventListener("click", onClickFavoris)
});

function onClickCatégories(e){
    const formData = new FormData(formInput);
    formData.forEach((key, value)=>{
        searchParams.append(value, key)
        console.log(searchParams.toString());
    });

    //const url = new URL(window.location.href);
    //console.log(url.pathname + "?" + searchParams.toString() + "&ajax=1")
    /*axios.get(url.pathname + "?" + searchParams.toString() + "&ajax=1")
        .then(function (response) {
            console.log(response.data) 
        });*/
    
}
document.querySelectorAll("#loginForm input").forEach(function (link) {
    link.addEventListener("change", onClickCatégories)
});