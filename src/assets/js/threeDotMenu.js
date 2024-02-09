
const threeDotMenu = document.getElementById('three-dot-menu');
const threeDotMenuUl = document.querySelector('#three-dot-menu ul');
const threeDotMenuId = document.getElementById('studymaterialId');
const threeDotIcon = document.getElementsByClassName('three-dot-icon');
const copy = document.querySelector('#three-dot-menu #copy');

function openThreeDotMenu(url) {
    threeDotMenu.classList.add('open');
    threeDotMenuUl.classList.add('open');
    document.body.classList.add('menu-open');
    // threeDotMenuId.value = postId;
    copy.setAttribute('data-clipboard-text', window.location.origin + '/studymaterial/' + postId);
}
function closeThreeDotMenu() {
    threeDotMenu.classList.remove('open');
    document.body.classList.remove('menu-open');

    threeDotMenuId.value = '';
    share.href = '';
}

