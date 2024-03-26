// Track the number of clicks
var clickCount = 0;

document.getElementById('likes-number').addEventListener('click', function () {
    clickCount++;
    console.log('Clicked');
    document.getElementById('click-count').innerText = clickCount;
});

