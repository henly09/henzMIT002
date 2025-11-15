document.getElementById('barcode').addEventListener("input", function countdown() {
    document.getElementById('scanning').style.visibility = 'visible';
    const time = setTimeout(a, 2000);
    document.getElementById('barcode').addEventListener("input", function countdown() {
        clearTimeout(time);
    })
})

function a() {
    document.getElementById('check-button-custom').click();
}