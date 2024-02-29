'use strict';

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