document.addEventListener('DOMContentLoaded', function() {
    var toasts = document.querySelectorAll('#toastModal ul li');
    // add toast class to each li after 0.5s delay
    toasts.forEach(function (toast, index) {
        var duration = toast.getAttribute('data-duration');
        toast.setAttribute('data-duration', parseInt(duration)+index*400);
        setTimeout(function () {
            toast.classList.add('toast');
        }, index * 400);
    });

    // remove toast after duration
    toasts.forEach(function (toast) {
        var duration = toast.getAttribute('data-duration');
        //animate toast
        setTimeout(function () {
            toast.classList.remove('toast');
            toast.classList.add('toast-hide');
        }, duration - 100);
        //remove toast
        setTimeout(function () {
            toast.remove();
        }, duration);

    });


    // remove toast on click
    toasts.forEach(function(toast) {
        toast.addEventListener('click', function () {
            setTimeout(function () {
                toast.classList.remove('toast');
                toast.classList.add('toast-hide');
            }, 0);
            setTimeout(function () {
                toast.remove();
            }, 100);
        });
    });

});

function toast(message, duration = 3000, type = 'primary') {
    var toast = document.createElement('div');
    toast.classList.add('toast', 'toast-' + type);
    toast.setAttribute('data-duration', duration);
    toast.innerHTML = message;
    document.body.appendChild(toast);
}
