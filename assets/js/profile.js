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
/*
|---------------------------------
|   Side nav / sections
|--------------------------------- 
*/
document.querySelector('#prof-link').addEventListener('click', (e) => {
    openSection(e, 'profil', 'tabcontent', 'tablinks')
})
document.querySelector('#contrib-link').addEventListener('click', (e) => {
    openSection(e, 'contributions', 'tabcontent', 'tablinks')
})
document.querySelector('#fav-link').addEventListener('click', (e) => {
    openSection(e, 'favoris', 'tabcontent', 'tablinks')
})
document.querySelector('#mess-link').addEventListener('click', (e) => {
    openSection(e, 'messagerie', 'tabcontent', 'tablinks')
})

/*
|---------------------------------
|   Edit user infos / section-forms
|--------------------------------- 
*/
document.querySelector('#name-button').addEventListener('click', (e) => {
    openSection(e, 'edit-name', 'formsection', 'formbuttons');
})
document.querySelector('#avatar-button').addEventListener('click', (e) => {
    openSection(e, 'edit-avatar', 'formsection', 'formbuttons')
})
document.querySelector('#email-button').addEventListener('click', (e) => {
    openSection(e, 'edit-email', 'formsection', 'formbuttons')
})
document.querySelector('#competence-button').addEventListener('click', (e) => {
    openSection(e, 'edit-competence', 'formsection', 'formbuttons')
})
document.querySelector('#delete-button').addEventListener('click', (e) => {
    openSection(e, 'delete', 'formsection', 'formbuttons')
})
document.querySelector('#password-button').addEventListener('click', (e) => {
    openSection(e, 'edit-password', 'formsection', 'formbuttons')
})