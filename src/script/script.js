


// //=================================LES TESTES++++++++++++++++++++++

// // Fonction pour afficher ou masquer les popups
// function switchPopup(hidePopupId, showPopupId) {
//     const hidePopup = document.getElementById(hidePopupId);
//     const showPopup = document.getElementById(showPopupId);

//     hidePopup.style.display = 'none'; // Masque la popup actuelle
//     showPopup.style.display = 'block'; // Affiche la popup cible
// }

// console.log('Script chargé correctement');
// console.log(document.getElementById('loginPopupOverlay')); // Devrait afficher un élément DOM
// console.log(document.getElementById('registerPopupOverlay')); // Devrait afficher un élément DOM

document.addEventListener("DOMContentLoaded", function () {
    // Sélection des popups
    const loginPopup = document.getElementById('loginPopupOverlay');
    const registerPopup = document.getElementById('registerPopupOverlay');
    
    // Liens pour ouvrir les popups
    const loginLink = document.querySelector('a[data-popup-target="loginPopupOverlay"]');
    const registerLink = document.querySelector('a[data-popup-target="registerPopupOverlay"]');

    // Boutons pour fermer les popups
    const closeLoginPopup = document.getElementById('closeLoginPopup');
    const closeRegisterPopup = document.getElementById('closeRegisterPopup');

    // Bouton pour basculer entre les popups
    const createAccountButton = document.querySelector('.switch-popup');

    // Fonctions d'ouverture/fermeture
    function openPopup(popup) {
        popup.classList.add('active');
        popup.classList.remove('hidden');
    }

    function closePopup(popup) {
        popup.classList.add('hidden');
        popup.classList.remove('active');
    }

    // Gestion des événements
    if (loginLink) {
        loginLink.addEventListener('click', function () {
            openPopup(loginPopup);
            closePopup(registerPopup); // Ferme l'autre popup
        });
    }

    if (registerLink) {
        registerLink.addEventListener('click', function () {
            openPopup(registerPopup);
            closePopup(loginPopup); // Ferme l'autre popup
        });
    }

    if (closeLoginPopup) {
        closeLoginPopup.addEventListener('click', function () {
            closePopup(loginPopup);
        });
    }

    if (closeRegisterPopup) {
        closeRegisterPopup.addEventListener('click', function () {
            closePopup(registerPopup);
        });
    }

    if (createAccountButton) {
        createAccountButton.addEventListener('click', function (e) {
            e.preventDefault();
            switchPopup('loginPopupOverlay', 'registerPopupOverlay');
        });
    }

    // Fermer les popups en cliquant en dehors
    document.addEventListener('click', function (event) {
        if (event.target === loginPopup) {
            closePopup(loginPopup);
        }
        if (event.target === registerPopup) {
            closePopup(registerPopup);
        }
    });

    // Fonction de basculement
    function switchPopup(hidePopupId, showPopupId) {
        closePopup(document.getElementById(hidePopupId));
        openPopup(document.getElementById(showPopupId));
    }
});
