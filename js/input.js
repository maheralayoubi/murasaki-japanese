const newsEn = [
    {
        date: 'Oct. 18, 2023',
        text: '【twitter】 "Today\'s word" updated： 「必須」',
        link: 'https://twitter.com/MJI_japanese/status/1714490562093666623'
    },
    {
        date: 'Oct. 10, 2023',
        text: '【twitter】 "Today\'s word" updated： 「記者会見」',
        link: 'https://twitter.com/MJI_japanese/status/1711585964622274603'
    },
    {
        date: 'Oct. 01, 2023',
        text: 'JLPT Preparation Course for the test in December is starting on October 07.',
        link: 'courses/jlpt'
    }
];

const newsJa = [
    {
        date: '2023. 10. 18',
        text: '【twitter】 "Today\'s word" 更新： 「必須」',
        link: 'https://twitter.com/MJI_japanese/status/1714490562093666623'
    },
    {
        date: '2023. 10. 10',
        text: '【twitter】 "Today\'s word" 更新： 「記者会見」',
        link: 'https://twitter.com/MJI_japanese/status/1711585964622274603'
    },
    {
        date: '2023. 10. 01',
        text: '【JLPTコース】12月の試験対策（10月7日スタート）のお申し込み受付中です。',
        link: 'courses/jlpt'
    },
    {
        date: '2023. 10. 01',
        text: '【日本語教師向け研修】間接教授法講座のビデオ視聴による受講が可能です。',
        link: 'seminars/indirect-method'
    }
];



const indirectDate = [
    {yy: '2023', mm: 9, dd:  9},
    {yy:     '', mm: 9, dd: 10},
    {yy:     '', mm: 9, dd: 16},
    {yy:     '', mm: 9, dd: 17}
];

const advancedDate = 
    {yy: '2023', mm: 7, dd:  8};





if (currentUrl.includes('indirect-method')) {
    indirectSchedule();
} else if (currentUrl.includes('advanced-japanese')) {
    advancedSchedule();
} else if (currentUrl.includes('seminars')) {
    indirectSchedule();
    advancedSchedule();
} else if (currentUrl.includes('/ja/')) {
    indexNews(newsJa);
} else {
    indexNews(newsEn);
}

function indirectSchedule() {
    const yy01 = document.querySelectorAll('.yy01');
    const mm01 = document.querySelectorAll('.mm01');
    const dd01 = document.querySelectorAll('.dd01');

    for (let i = 0; i < indirectDate.length; i++) {
        if (indirectDate[i]['yy']) {
            yy01[i].textContent = indirectDate[i]['yy'] + '年';
        }
        mm01[i].textContent = indirectDate[i]['mm'];
        dd01[i].textContent = indirectDate[i]['dd'];
    }
}

function advancedSchedule() {
    const yy02 = document.querySelector('.yy02');
    const mm02 = document.querySelector('.mm02');
    const dd02 = document.querySelector('.dd02');
    yy02.textContent = advancedDate['yy'] + '年';
    mm02.textContent = advancedDate['mm'];
    dd02.textContent = advancedDate['dd'];
}

function indexNews(news) {
    const newsList = document.querySelector('.news-list');

    for (let i = 0; i < news.length; i++) {
        const insertList = `<li><p>${news[i]['date']}</p><p><a href="${news[i]['link']}">${news[i]['text']}</a></p></li>`;
        newsList.insertAdjacentHTML('beforeend', insertList);
    }
}