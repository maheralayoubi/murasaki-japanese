'use strict';

// 英語版のニュース
// date: '日付', text: 'ニュースの見出し文', link: 'リンク先のURL'
const newsEn = [
    {
        date: 'Dec. 20, 2023',
        text: '【twitter】 "Today\'s word" updated： 「帰化」',
        link: 'https://twitter.com/MJI_japanese/status/1737303773243220025'
    },
    {
        date: 'Dec. 19, 2023',
        text: '【twitter】 "Today\'s word" updated： 「高層ビル」',
        link: 'https://twitter.com/MJI_japanese/status/1737022979891163342'
    },
    {
        date: 'Dec. 12, 2023',
        text: '【twitter】 "Today\'s word" updated： 「〜機」',
        link: 'https://twitter.com/MJI_japanese/status/1734478797293174852'
    }
];

// 日本語版のニュース
// date: '日付', text: 'ニュースの見出し文', link: 'リンク先のURL'
const newsJa = [
    {
        date: '2023. 12. 20',
        text: '【twitter】 "Today\'s word" 更新： 「帰化」',
        link: 'https://twitter.com/MJI_japanese/status/1737303773243220025'
    },
    {
        date: '2023. 12. 19',
        text: '【twitter】 "Today\'s word" 更新： 「高層ビル」',
        link: 'https://twitter.com/MJI_japanese/status/1737022979891163342'
    },
    {
        date: '2023. 12. 12',
        text: '【twitter】 "Today\'s word" 更新： 「〜機」',
        link: 'https://twitter.com/MJI_japanese/status/1734478797293174852'}
];

// 間接教授法講座日程
// yy: '年', mm: 月, dd: 日
const indirectDate = [
    {yy: '2024', mm: 4, dd:  6},
    {yy:     '', mm: 4, dd: 7},
    {yy:     '', mm: 4, dd: 13},
    {yy:     '', mm: 4, dd: 14}
];

// 上級日本語教授法講座日程
// yy: '年', mm: 月, dd: 日
const advancedDate = {yy: '2024', mm: 6, dd:  1};



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
