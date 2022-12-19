// Zoek alle blokken met de class "order-history__order"
var blocks = document.querySelectorAll('.order-history__order');
var button = document.querySelector('button.load-more');

if(blocks.length <= 10) {
    button.style.display = 'none';
}

// Geef de eerste 10 blokken de display "block" en de overige blokken de display "none"
for (var i = 0; i < blocks.length; i++) {
    if (i < 10) {
        blocks[i].style.display = 'block';
    } else {
        blocks[i].style.display = 'none';
    }
}

button.addEventListener('click', function() {
    for (var i = 0; i < blocks.length; i++) {
        blocks[i].style.display = 'block';
    }

    button.style.display = 'none';
});