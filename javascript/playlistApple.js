function toggleNavbar() {
    document.getElementById('navbar').classList.toggle('show');
}

const videoList = [
    {
        video: 'https://drive.google.com/file/d/1Lfez-AsckeBufe6Qs7zE6mMH468xeJvq/preview',
        title: 'How to send message? (Aanhon pag padara hin mensahe?)'
    },
    {
        video: 'https://drive.google.com/file/d/1qo9kkvgeFwy5YzztBAnEozjvBLvHWQbE/preview',
        title: 'How to add contact? (Aanhon Pag butang hin bag o nga numero?)'
    },
    {
        video: 'https://drive.google.com/file/d/1YzCa_d8WHfiwbUTbvkIquXTqpmOrwAHl/preview',
        title: 'How to use camera? (Aanhon pag gamit hit camera?)'
    },
    {
        video: 'https://drive.google.com/file/d/1vIhCJEqQz4Od6VVuyB2g4_0zm2TWNDtb/preview',
        title: 'How to contact someone? (Aanhon pag biling han numero?)'
    },
];


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
