// ====================================================================================================
// Scroll & Menu 1200                      Scroll & Menu 1200                        Scroll & Menu 1200 
// ====================================================================================================

const max1200 = window.matchMedia('(max-width:1200px)');
max1200.onchange = function() {mqChange1200(max1200)};
mqChange1200(max1200);

function mqChange1200(e) {
    if (e.matches) {
        headerScroll().header.classList.remove('scroll');
        window.onscroll = function() {return false};
        headerMenu();
    } else {
        headerScroll();
    }
}

// Scroll
// ----------------------------------------------------------------------------------------------------

function headerScroll() {
    const header = document.querySelector('.header-area');
    const y = window.scrollY;
    header.classList.toggle('scroll', y > 100);

    window.onscroll = function(e) {
        const y = window.scrollY;
        header.classList.toggle('scroll', y > 100);
    }

    return {header};
}

// Menu
// ----------------------------------------------------------------------------------------------------

function headerMenu() {
    const headerNav = document.querySelector('.header-nav');
    const hmbg = document.querySelector('.humburger');
    const body = document.querySelector('body');
    const indexHeader = document.querySelector('.body-index .header-area');
    headerNav.style.transition = '';

    headerNav.classList.remove('active');
    hmbg.classList.remove('active');
    body.classList.remove('fixed');
    if (indexHeader) indexHeader.classList.remove('active');

    hmbg.onclick = function() {
        headerNav.style.transition = 'opacity .4s, visibility .4s, top .4s';
        hmbg.classList.toggle('active');
        headerNav.classList.toggle('active');
        body.classList.toggle('fixed');
        if (indexHeader) indexHeader.classList.toggle('active');
    }
}



// ====================================================================================================
// Smart Phone Accordion 768            Smart Phone Accordion 768             Smart Phone Accordion 768
// ====================================================================================================

const max768 = window.matchMedia('(max-width: 768px)');

max768.onchange = function() {mqChange768(max768)};
mqChange768(max768);

function mqChange768(e) {
    if (e.matches) {
        spAcc();
    }
}

// Accordion
// ----------------------------------------------------------------------------------------------------

function spAcc() {
    const navAccordion= document.querySelectorAll('.nav-accordion');
    const courseList= document.querySelectorAll('.course-list, .seminar-list');
    const navArrowContainer = document.querySelectorAll('.nav-arrow-container');
    const navArrow = document.querySelectorAll('.nav-arrow');
    
    for (let i = 0; i < navAccordion.length; i++) {
        const accordionHeight = courseList[i].offsetHeight;

        navAccordion[i].style.height = null;
        
        if (navArrow[i].classList.contains('active')) {
            navArrow[i].classList.remove('active');
        }
    
        navArrowContainer[i].onclick = function() {
            navArrow[i].classList.toggle('active');
            if (navAccordion[i].style.height) {
                navAccordion[i].style.height = null;
            } else {
                navAccordion[i].style.height = accordionHeight + 'px';
            }
        };
    }
}



// ====================================================================================================
// Smart Phone Language 500              Smart Phone Language 500              Smart Phone Language 500
// ====================================================================================================

const max500 = window.matchMedia('(max-width: 500px)');

max500.onchange = function() {mqChange500(max500)};
mqChange500(max500);

function mqChange500(e) {
    spAcc();

    if (e.matches) {
        spLang();
    }
}

// Language
// ----------------------------------------------------------------------------------------------------

function spLang() {
    const headerLanguage = document.querySelector('.header-language');
    const spHeaderLanguage = document.querySelector('.sp-header-language-area');
    
    headerLanguage.onclick = function() {
        spHeaderLanguage.classList.toggle('active');
    }
}



// ====================================================================================================
// Smart Phone Viewport 374              Smart Phone Viewport 374              Smart Phone Viewport 374
// ====================================================================================================

const max374 = window.matchMedia('(max-width: 374px)');
const viewportContent = document.querySelector("meta[name='viewport']");

if (max374.matches) {
    viewportContent.setAttribute("content", "width=375, user-scalable=no, shrink-to-fit=yes");
}



// ====================================================================================================
// Language Jump                       Language Jump                       Language Jump
// ====================================================================================================

const currentUrl = location.pathname;
const languageUrl = document.querySelector('.language-link');
const languageUrlSp = document.querySelector('.language-link-sp');
console.log(languageUrl);

let languageJump;
if (currentUrl.includes('/seminars/')) {
    languageJump = '/';
} else if (currentUrl.includes('/ja/')) {
    languageJump = currentUrl.replace('/ja/', '/');
} else if (currentUrl.includes('tips')) {
    languageJump = '/ja/';
} else {
    languageJump = '/ja' + currentUrl;
}

languageUrl.setAttribute('href', languageJump);
languageUrlSp.setAttribute('href', languageJump);
languageUrlSp.style.textDecoration = "none";