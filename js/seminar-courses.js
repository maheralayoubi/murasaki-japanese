const voiceAcc = document.querySelectorAll('.voice-each-header');
const voiceText = document.querySelectorAll('.voice-each-text');
const voicePlus = document.querySelectorAll('.voice-each-plus');

for (let i = 0; i < voiceAcc.length; i++) {
    voiceAcc[i].addEventListener('click', function () {
        if (voiceText[i].style.height) {
            voiceText[i].style.height = null;
        } else {
            voiceText[i].style.height = voiceText[i].scrollHeight + 'px';
        }

        voicePlus[i].classList.toggle('active');
    })
}

// const smoothScrollTrigger = document.querySelectorAll('a[href^="#"]');

// for (let i = 0; i < smoothScrollTrigger.length; i++) {
//     smoothScrollTrigger[i].addEventListener('click', (e) => {
//         e.preventDefault();
//         let href = smoothScrollTrigger[i].getAttribute('href');
//         let targetElement = document.getElementById(href.replace('#', ''));
//         const rect = targetElement.getBoundingClientRect().top;
//         const offset = window.pageYOffset;
//         let gap = 30;
//         if (href === '#application') gap = 0;
//         const target = rect + offset - gap;

//         window.scrollTo({
//             top: target,
//             behavior: 'smooth',
//         });
//     });
// }