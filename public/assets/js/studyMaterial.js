let lastCall = 0;
function likeMaterial(studyMaterialId, element) {
    const now = Date.now();
    const throttleTime = 1000; // 1000 milliseconds = 1 second

    if (now - lastCall < throttleTime) {
        return;
    }
    lastCall = now;
    if (element.classList.contains('active')) {
        $.ajax({
            type: 'DELETE',
            url: '/api/material/unlike/' + studyMaterialId,
            success: function (response) {
                console.log(response);
                if (response.data.status === 'success') {
                    element.classList.remove('active');
                    element.querySelector('span').innerText = parseInt(element.querySelector('span').innerText) - 1;
                }
            }
        });
    } else {
        $.ajax({
            type: 'POST',
            url: '/api/material/like/' + studyMaterialId,
            success: function (response) {
                console.log(response);
                if (response.data.status === 'success') {
                    element.classList.add('active');
                    element.querySelector('span').innerText = parseInt(element.querySelector('span').innerText) + 1;
                }
            }
        });
    }
}

function bookmarkMaterial(studyMaterialId, element) {
    
    const now = Date.now();
    const throttleTime = 1000; // 1000 milliseconds = 1 second

    if (now - lastCall < throttleTime) {
        return;
    }
    lastCall = now;
    

    if (element.classList.contains('active')) {
        $.ajax({
            type: 'DELETE',
            url: '/api/material/unbookmark/' + studyMaterialId,
            success: function (response) {
                console.log(response);
                if (response.data.status === 'success') {
                    element.classList.remove('active');
                    smallClientAlert('Removed from bookmarks');
                }
            }
        });
    } else {
        $.ajax({
            type: 'POST',
            url: '/api/material/bookmark/' + studyMaterialId,
            success: function (response) {
                console.log(response);
                if (response.data.status === 'success') {
                    element.classList.add('active');
                    smallClientAlert('Added to bookmarks');
                }
            }
        });
    }
}
