import SwiperCore, { Navigation, Pagination } from 'swiper/core';
import Swiper from 'swiper';
import Masonry from 'masonry-layout';
import Accordion from 'accordion-js';
import Litepicker from 'litepicker';

window.disableLitepickerStyles = true;

const browserLang = navigator.language;
const lang = 'fr-FR';
const dateFormat = 'YYYY-MM-DD';
const url = window.location.origin;
const fetchHeaders = function () {
    let headers = new Headers({
        'Content-Type': 'application/json',
        'X-Api-Header': 'call'
    })
    return  {
        method: 'GET',
        headers: headers,
        mode: 'cors',
        cache: 'default'
    };
}


/**
 * Entete qui réduit au scroll
 */
window.onscroll = function () {
    if (document.documentElement.scrollTop > 155) {
        document.getElementById("navHeader").classList.add('scroll');
        document.body.classList.add('sticky-header')
    } else {
        document.getElementById("navHeader").classList.remove('scroll');
        document.body.classList.remove('sticky-header')
    }
};


/**
 * Menu
 */
// effet accordéons sur les menu avec sous-menu
let menuItems = document.querySelectorAll('.menu-item-has-children');
menuItems.forEach((item) => {
    item.addEventListener('click', () => {
        item.classList.toggle("dropped");
    })
})

// Désactive le scroll quand le menu est ouvert
let burgerInput = document.getElementById('burger');
burgerInput.addEventListener('click', () => {
    if (burgerInput.checked === true) {
        document.body.style.overflow = "hidden"
        // Ferme le menu si on clique en dehors de celui-ci
        if (document.querySelector('.main-menu-wrapper').offsetHeight > 0) {
            window.onclick = (event) => {
                if (event.target.matches('.main-menu-wrapper') || event.target.matches('.main-menu')) {
                    if (burgerInput.checked) {
                        burgerInput.checked = false
                    }
                }
            }
        }
    } else {
        document.body.style.overflowY = "auto"
    }
})


/**
 * Effet accordéons (page accordéons)
 */
let accordionElem = document.querySelector('.accordions');
if (accordionElem) {
    new Accordion('.accordions', {
        duration: 400,
        openOnInit: [0],
        elementClass: 'accordion',
    });
}


/**
 * Effet masonery (faits marquants et communiqués de presse)
 */
let pressMsnryElem = document.querySelector('.press-releases')
let HighligthsMsnryElem = document.querySelector('.highlights')
let pressMsnry, HighligthsMsnry;

if (pressMsnryElem) {
    pressMsnry = new Masonry(pressMsnryElem, {
        itemSelector: '.press-release',
        columnWidth: 540,
        percentPosition: true,
        horizontalOrder: true,
        gutter: 30
    });
}

if (HighligthsMsnryElem) {
    HighligthsMsnry = new Masonry(HighligthsMsnryElem, {
        itemSelector: '.highlight',
        columnWidth: 540,
        percentPosition: true,
        horizontalOrder: true,
        gutter: 30
    });
}


/**
 * Diaporama
 */
SwiperCore.use([Navigation, Pagination]);
new Swiper('.swiper-container', {
    direction: 'horizontal',
    spaceBetween: 130,
    speed: 600,
    parallax: true,
    loop: true,
    lazy: true,
    slidesPerView: 'auto',
    centeredSlides: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});


/**
 * Filtres des événements, faits marquants et communiqués de presse
 */
// Filtre par étiquettes et date à l'aide d'un calendrier
let calendar = document.getElementById('calendarPicker')
if (calendar) {
    let toolTipTxt;
    if (document.documentElement.lang === lang || browserLang === lang) {
        toolTipTxt = {"one":"jour","other":"jours"};
    } else {
        toolTipTxt = {"one":"day","other":"days"};
    }
    const datePicker = new Litepicker({
        element: calendar,
        lang: lang,
        format: dateFormat,
        tooltipText: toolTipTxt,
        inlineMode: true,
        singleMode: false,
    });

    datePicker.on('selected', (date1, date2) => {
        let select = document.getElementById('events-filter');
        let value = select.value;
        if (value === '') {
            value = 'all'
        }
        window.location.href = '/evenements/' + value + '/' + date1.format(dateFormat) + ',' + date2.format(dateFormat);
    });
}
// Filtre par étiquettes seulement
const eventsFilter = document.getElementById('events-filter');
const highlightsFilter = document.getElementById('highlights-filter');
const pressReleaseFilter = document.getElementById('press-release-filter');

//Filtres les évènements
if (eventsFilter) {
    eventsFilter.addEventListener('change', (e) => {
        let value = e.target.value;
        window.location.href = '/evenements/' + value
    })
}

//Filtres les faits marquants
if (highlightsFilter) {
    setSelectedOptionFromRequest(highlightsFilter)
    highlightsFilter.addEventListener('change', (e) => {
        let value = e.target.value;
        getFilteredPosts('faits-marquants', value, '.highlights', '.highlight');
    })
}

//Filtres les communiqués de presses
if (pressReleaseFilter) {
    setSelectedOptionFromRequest(pressReleaseFilter)
    pressReleaseFilter.addEventListener('change', (e) => {
        let value = e.target.value;
        getFilteredPosts('communiques-de-presse', value, '.press-releases', '.press-release');
    })
}

function setSelectedOptionFromRequest(selectedElement)
{
    let pathname = window.location.pathname
    for (let i = 0; i < selectedElement.options.length; i++) {
        let val = selectedElement.options[i].value
        if (val !== '') {
            if (pathname.includes('/'+val)) {
                selectedElement.options[0].selected = false;
                selectedElement.options[i].selected = true;
            }
        }
    }
}

/**
 * Génère le HTML des articles filtrés
 * @param {string} uriPart
 * @param {string} value
 * @param {string} main
 * @param {string} itemSelector
 * @param {array} dates
 */
const getFilteredPosts = async function (uriPart, value, main, itemSelector, dates = undefined) {

    const pageUri = '/' + uriPart;
    let uri = '';

    if (value === '' && !dates) {
        document.location.href = pageUri;
        return;
    } else {
        if (dates !== undefined && value === '') {
            uri = url + pageUri + '/all/' + dates + '/';
        } else {
            uri = url + pageUri + '/' + value + '/';
        }
    }

    let fetchParams = fetchHeaders();
    try {
        let response = await fetch(uri, fetchParams);
        if (response.ok) {
            let data = await response.json();
            if (data.success) {
                // Créer les éléments HTML qui accueillerons les données
                let wrapperNewEvents = document.createElement('div');
                let wrapperNewPagination = document.createElement('div');

                // Récupérer les éléments de la page courante
                let oldEvents = document.querySelector(main);
                let mainElement = oldEvents.parentNode;
                let oldPaginationElement = document.querySelector('.pagination');

                // Mettre les données dans les éléments HTML créer précédement
                wrapperNewEvents.innerHTML = data.result;
                if (data.pagination) {
                    wrapperNewPagination.innerHTML = data.pagination;
                } else {
                    wrapperNewPagination.innerHTML = '<div class="pagination"></div>';
                }
                let newEvents = wrapperNewEvents.firstChild;
                let newPagination = wrapperNewPagination.firstChild;

                // Insérer les données dans la page
                mainElement.removeChild(oldEvents);
                mainElement.insertBefore(newEvents, oldPaginationElement);
                mainElement.removeChild(oldPaginationElement);
                mainElement.appendChild(newPagination);

                // relancer l'effet masonry pour les faits marquants et les communiqués
                if (main !== '.events') {
                    new Masonry(newEvents, {
                        itemSelector: itemSelector,
                        columnWidth: 540,
                        percentPosition: true,
                        horizontalOrder: true,
                        gutter: 30
                    });
                }
            } else {
                document.location.href = pageUri + '/'
            }
        } else {
            console.error('erreur', response);
        }
    } catch (e) {
        console.error(e)
    }
}


/**
 * Bouton en tête de page
 */
// ajoute la classe active sur le bouton d'entête de la page en cour de consultation
let headerButtons = document.querySelectorAll('.btn-header');
if (headerButtons) {
    headerButtons.forEach((button)=> {
        if (button.href === window.location.href + '#') {
            button.classList.add('active')
        }
    })
    headerButtons.forEach((btn)=>{
        if (btn.classList.contains('page')) {
            btn.addEventListener('click' , (e) => {
                e.preventDefault();
                let target = new URL(btn.href);
                getPageContent(target, 'main', btn.classList[1])
                headerButtons.forEach((b) => {
                    if(b.href === window.location.href + '#') {
                        b.href = window.location.href
                    }
                    if (b.classList.contains('active')) {
                        b.classList.remove('active')
                    }
                })
                btn.classList.add('active')
            })
        }
    })
}

const getPageContent = async function (url, replace , currentPageClass) {
    let options = {
        method: "GET",
        headers: {
            "Content-Type": "text/html;charset=UTF-8"
        },
    }
    try {
        let response = await fetch(url, options);
        if (response.ok) {
            let html = await response.text();
            let parser = new DOMParser();
            let distantDoc=  parser.parseFromString(html, 'text/html');
            let distantMain = distantDoc.querySelector(replace)
            distantMain.classList.remove('current_light_blue')
            distantMain.classList.add(currentPageClass)
            let currentMain = document.querySelector(replace)
            let currentMainParent = currentMain.parentNode
            if(currentMainParent.classList.contains('events-page')) {
                currentMain = currentMainParent.querySelector(replace)
                currentMainParent.replaceWith(currentMain)
            }
            currentMain.replaceWith(distantMain)
        } else {
            console.warn('Erreur du serveur : ', response.error());
        }
    } catch (err) {
        console.warn('Il y a eu un problème. ', err);
    }
}