var dt = new Date();
document.getElementById("date").innerHTML = (("0"+(dt.getMonth()+1)).slice(-2)) +"/"+ (("0"+dt.getDate()).slice(-2)) +"/"+ (dt.getFullYear());

const input = document.querySelector(".clear-input")
const clearButton = document.querySelector(".clear-button")

const handleButtonClick = (e) => {
input.value = ''
input.focus()
input.classList.remove("clear-input--touched")
}

clearButton.addEventListener("click", handleButtonClick)

function barcodeFocus() {
  document.getElementById("barcode").focus();
}

function showScanCustom() {
document.getElementById('scan-custom').style.display = 'block';

document.getElementById('scan-custom').style.visibility = 'hidden';
}

function hideScanCustom() {
document.getElementById('scan-custom').style.display = 'none';
document.getElementById('scan-custom').style.visibility = 'visible';
}