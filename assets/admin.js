/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/preset.scss';
import './admin/css/portal.css';
// JS
import './admin/plugins/fontawesome/js/all.min.js';
import './admin/plugins/popper.min.js'
import './admin/plugins/bootstrap/js/bootstrap.min.js'  
// import './admin/plugins/chart.js/chart.min.js'
// import './admin/js/index-charts.js' 
import './admin/js/app.js'


// start the Stimulus application
import './bootstrap';

function openForm(form, evt) {
    evt.preventDefault();
    var element = document.getElementById(form);
    element.classList.toggle("show");
    evt.currentTarget.className += " hide";
}

document.querySelector('#reply_btn').addEventListener('click', (e) => {
    openForm('reply_form', e);
})