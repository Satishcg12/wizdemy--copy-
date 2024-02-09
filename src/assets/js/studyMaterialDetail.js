function likeStudyMaterial(id) {
    var url = '/studymaterial/like?id=' + id;
    $.ajax({
        url: url,
        type: 'post',
        success: function (response) {
            if (response.status == 'success') {
                // update like count
                $('#likeCount').text(response.likeCount);
                // toggle like button
                $('#like-button').toggleClass('active');
            }else{
                toastMessage(response.msg, '3000', 'error');
            }   
        }
    });
}

function bookmarkStudyMaterial(id) {
    var url = '/studymaterial/bookmark?id=' + id;
    $.ajax({
        url: url,
        type: 'post',
        success: function (response) {
            console.log(response);
            if (response.status == 'success') {
                $('#bookmark-button').toggleClass('active');
            }else{
                toastMessage(response.msg, '3000', 'error');
            }   
        }
    });
}