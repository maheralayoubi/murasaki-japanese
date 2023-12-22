'use strict';

// ====================================================================================================
// Anchor Link                                 Anchor Link                                  Anchor Link 
// ====================================================================================================
let url = location.href;

window.addEventListener('resize', function() {
    anchorScroll(headerHeight1());
    if (url.includes('about')) aboutAnchorSame(headerHeight2());
});

window.addEventListener('load', function() {
    anchorScroll(headerHeight1());
    if (url.includes('about')) {
        aboutAnchorSame(headerHeight2());
        aboutAnchorOther(headerHeight2());
    }
});

window.addEventListener('hashchange', function() {
    url = location.href;
    aboutAnchorOther(headerHeight2());
});


// Header Height
// ----------------------------------------------------------------------------------------------------
function headerHeight1() {
    const scrollWidth = window.innerWidth;

    if (scrollWidth <= 768) {
        return [0, 60];
    } else if (scrollWidth <= 1200) {
        return [0, 100];
    } else {
        return [30, 130];
    }
}

function headerHeight2() {
    const scrollWidth = window.innerWidth;

    if (scrollWidth <= 768) {
        return 60;
    } else {
        return 100;
    }
}

// Talbe of Contents
// ----------------------------------------------------------------------------------------------------
function anchorScroll(array) {
    let gap = array[0];
    let headerHeight = array[1];
    let smoothScrollTrigger = document.querySelectorAll('a[href^="#"]');

    for (let i = 0; i < smoothScrollTrigger.length; i++) {
        smoothScrollTrigger[i].onclick = function(e) {
            e.preventDefault();
            let href = smoothScrollTrigger[i].getAttribute('href');
            let targetElement = document.getElementById(href.replace('#', ''));
            let rect = targetElement.getBoundingClientRect().top;
            let offset = window.pageYOffset;
            // if (href === '#application') gap = 0;
            let target = rect + offset - headerHeight + gap;

            window.scrollTo({
                top: target,
                behavior: 'smooth',
            });
        };
    }
}

// Footer Anchor from Other Page
// ----------------------------------------------------------------------------------------------------
function aboutAnchorOther(headerHeight) {
    if (url.includes('#') && url.indexOf('#') != -1) {
        const id = url.split('#');
        const targetElement = document.getElementById(id[id.length - 1]);
        const targetRect = targetElement.getBoundingClientRect().top;
        const offset = window.pageYOffset;
        const targetPosition = targetRect + offset - headerHeight;

        window.scrollTo({
            top: targetPosition,
        });
    }
}

// Footer Anchor from Same Page
// ----------------------------------------------------------------------------------------------------
function aboutAnchorSame(headerHeight) {
    if (url.includes('about')) {
        const jumpTrigger =  document.querySelectorAll('a[href^="/about#"');
        
        for (let i = 0; i < jumpTrigger.length; i++) {
            jumpTrigger[i].onclick = function(e) {
                e.preventDefault();
                const href2 = jumpTrigger[i].getAttribute('href');
                const targetElement2 = document.getElementById(href2.replace('/about#', ''));
                const rect2 = targetElement2.getBoundingClientRect().top;
                const offset2 = window.pageYOffset;
                const target2 = rect2 + offset2 - headerHeight;
    
                window.scrollTo({
                    top: target2,
                });
            };
        }
    }
}