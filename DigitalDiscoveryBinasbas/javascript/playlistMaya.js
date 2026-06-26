function toggleNavbar() {
    document.getElementById('navbar').classList.toggle('show');
}

const videoList = [
    {
        video: 'https://drive.google.com/file/d/1msAdvBxgx42FYzRnnDXySGnohY1Nk1ng/preview',
        title: 'How to Create Account MAYA App? (Aanhon pag himo hit account ha MAYA App?)'
    },
    {
        video: 'https://drive.google.com/file/d/1PxY5cg2ynR7zhZIsg-L0mzE4lQHqbt93/preview',
        title: 'How to transfer money on MAYA App? (Aanhon pag balhin hit kwarta ha MAYA App?)'
    },
]

const categories = [...new Set(videoList.map((item) => item))];
document.getElementById('videoList').innerHTML = categories.map((item) => {
    var { video, title } = item;
    return (
        `<div class="list active">
            <video src="${video}" class="list-video"></video>
            <h3 class="list-title">${title}</h3>
        </div>`
    );
}).join('');

let videoItems = document.querySelectorAll('.video-list-container .list');
videoItems.forEach(remove => { remove.classList.remove('active') });
videoItems.forEach(vid => {
    vid.onclick = () => {
        videoItems.forEach(remove => { remove.classList.remove('active') });
        vid.classList.add('active');
        let src = vid.querySelector('.list-video').src;
        let title = vid.querySelector('.list-title').innerHTML;
        document.querySelector('.video-wrapper .main-video').src = src;
        document.querySelector('.video-wrapper .main-video').play();
        document.querySelector('.video-wrapper .main-vid-title').innerHTML = title;
    };
});
