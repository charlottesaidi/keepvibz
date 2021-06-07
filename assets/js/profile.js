function openSection(evt, sectionName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(sectionName).style.display = "block";
    evt.currentTarget.className += " active";
}
document.querySelector('#prof-link').addEventListener('click', (e) => {
    openSection(e, 'profil')
})
document.querySelector('#contrib-link').addEventListener('click', (e) => {
    openSection(e, 'contributions')
})
document.querySelector('#fav-link').addEventListener('click', (e) => {
    openSection(e, 'favoris')
})
document.querySelector('#mess-link').addEventListener('click', (e) => {
    openSection(e, 'messagerie')
})