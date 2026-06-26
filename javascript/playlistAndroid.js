const videoList = [
    {
        video: 'https://drive.google.com/file/d/1zHMp5uwCBTxc4hc9fVw-kcqgnKZtpqoP/view?usp=drive_link',
        title: 'How to send message? (Aanhon pag padara hin mensahe?)'
    },
    {
        video: 'https://drive.google.com/file/d/1vpptTQAUrWu58vMXNJY8Wgbo57Vx2IcI/view?usp=drive_link',
        title: 'How to add contact? (Aanhon Pag butang hin bag o nga numero?)'
    },
    {
        video: 'https://drive.google.com/file/d/1d749ZlTMsi7nY3jGBiWbJ7N5qI1Etbh6/view?usp=sharing',
        title: 'How to use camera? (Aanhon pag gamit hit camera?)'
    },
];

// Convert Google Drive links → /preview
function getPreviewLink(link) {
    return link
        .replace("/view?usp=drive_link", "/preview")
        .replace("/view?usp=sharing", "/preview");
}

// Render Playlist
document.getElementById('videoList').innerHTML = videoList.map((item, i) => {
    return `
        <div class="list ${i === 0 ? 'active' : ''}" data-src="${getPreviewLink(item.video)}">
            <h3 class="list-title">${item.title}</h3>
        </div>
    `;
}).join("");

// Main video + title
let mainVideo = document.querySelector('.main-video');
let mainTitle = document.querySelector('.main-vid-title');
let videoItems = document.querySelectorAll('.video-list-container .list');

// Click Event
videoItems.forEach(vid => {
    vid.onclick = () => {
        videoItems.forEach(el => el.classList.remove('active'));
        vid.classList.add('active');

        mainVideo.src = vid.getAttribute('data-src'); // palit src
        mainTitle.innerHTML = vid.querySelector('.list-title').innerHTML;
    };
});
