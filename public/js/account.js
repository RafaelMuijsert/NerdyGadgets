$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var hash = $(e.target).attr('href');
    if (history.pushState) {
        history.pushState(null, null, hash);
    } else {
        location.hash = hash;
    }
});

var hash = window.location.hash;
if (hash) {
    $('.nav-link[href="' + hash + '"]').tab('show');
}

if(window.location.hash === ''){
    location.href = '#v-pills-home';
    document.querySelector('#v-pills-home-tab').classList.add('active');
}

setTimeout(function(){
    document.querySelector('#v-pills-tabContent').style.opacity = 1;
}, 100);