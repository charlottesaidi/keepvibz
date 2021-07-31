/*
|---------------------------------
|   Side nav / sections
|--------------------------------- 
*/
function openSection(evt, sectionName, tab, links) {
    var i, tabcontent, tablinks, tab;

    tabcontent = document.getElementsByClassName(tab);
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName(links);
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(sectionName).style.display = "block";
    evt.currentTarget.className += " active";
}
document.querySelector('#prof-link').addEventListener('click', (e) => {
    openSection(e, 'profil', 'tabcontent', 'tablinks')
})
document.querySelector('#top-link').addEventListener('click', (e) => {
    openSection(e, 'toplines', 'tabcontent', 'tablinks')
})
document.querySelector('#instru-link').addEventListener('click', (e) => {
    openSection(e, 'instrus', 'tabcontent', 'tablinks')
})
document.querySelector('#text-link').addEventListener('click', (e) => {
    openSection(e, 'textes', 'tabcontent', 'tablinks')
})
/*
|---------------------------------
|   Edit user infos / section-forms
|--------------------------------- 
*/
function openForm(form, evt) {
    evt.preventDefault();
    var element = document.getElementById(form);
    element.classList.toggle("show");
    evt.currentTarget.className += " hidden";
}

document.querySelector('#name-button').addEventListener('click', (e) => {
    openForm('edit-name', e);
})
document.querySelector('#avatar-button').addEventListener('click', (e) => {
    openForm('edit-avatar', e)
})
document.querySelector('#email-button').addEventListener('click', (e) => {
    openForm('edit-email', e)
})
document.querySelector('#desc-button').addEventListener('click', (e) => {
    openForm('edit-desc', e)
})
document.querySelector('#competence-button').addEventListener('click', (e) => {
    openForm('edit-competence', e)
})
document.querySelector('#town-button').addEventListener('click', (e) => {
    openForm('edit-town', e)
})
document.querySelector('#phone-button').addEventListener('click', (e) => {
    openForm('edit-phone', e)
})
document.querySelector('#visibility-button').addEventListener('click', (e) => {
    openForm('edit-visibility', e)
})
document.querySelector('#delete-button').addEventListener('click', (e) => {
    openForm('delete', e)
})
document.querySelector('#password-button').addEventListener('click', (e) => {
    openForm('edit-password', e)
})
