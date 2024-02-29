// ====================================================================================================
// Swiper                                        Swiper                                          Swiper 
// ====================================================================================================

const myDelay = 5000; //各スライドの時間
const mySpeed = 1000; //フェードの時間
const slide = document.querySelectorAll('.swiper-container .swiper-slide');
const slideLength = slide.length;
const mji = document.querySelector('.mji-fill');

let routine = 0;

const updateProgress = (index) => {

    // 各スライドの始点・終点
    const start = Math.abs(Math.floor(index / slideLength * 100 - 100));
    const end = Math.abs(Math.floor((index + 1) / slideLength * 100 - 100));

    // 周毎のbackground設定
    if (routine % 2 == 0) {
        mji.style.setProperty('--my-gradient', 'var(--to-left)');
    } else {
        mji.style.setProperty('--my-gradient', 'var(--to-right)');
    };

    // スライド間隔
    let myDuration = '';

    if (index == 0 && routine == 0) {
        myDuration = myDelay;
    } else {
        myDuration = myDelay + mySpeed;
    }

    // スタート位置
    mji.style.backgroundPosition = start + '%';
    setTimeout(() => {
    // ゴール位置
    mji.style.backgroundPosition = end + '%';
    }, 100);

    mji.animate(
        [
            {backgroundPosition: start + '%' },
            {backgroundPosition: end + '%'},
        ],
        {
            duration: myDuration,
        }
    );

    if (index == slideLength - 1) {
        routine += 1;
    };
};

let swipeOption = {
    loop: true,
    effect: 'fade',
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    speed: 1500,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    on: {
        afterInit: () => {
            updateProgress(0);
        },

        realIndexChange: (swiper) => {
            updateProgress(swiper.realIndex);
        },
    },
}

new Swiper('.swiper-container', swipeOption);



// ====================================================================================================
// Why Accordion                             Why Accordion                                Why Accordion
// ====================================================================================================
const whyAcc = document.querySelectorAll('.why-each-header');
const whyText = document.querySelectorAll('.why-each-text');
const whyArr = document.querySelectorAll('.why-arrow');

for (let i = 0; i < whyAcc.length; i++) {
    whyAcc[i].addEventListener('click', function () {
        if (whyText[i].style.height) {
            whyText[i].style.height = null;
        } else {
            whyText[i].style.height = whyText[i].scrollHeight + 'px';
        }

        whyArr[i].classList.toggle('active');
    })
}



// ====================================================================================================
// VH                                             VH                                                 VH
// ====================================================================================================
const vh = window.innerHeight * 0.01;
document.documentElement.style.setProperty('--vh', `${vh}px`);

