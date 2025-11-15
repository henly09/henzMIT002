function updateTime() {
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    var timeString = hours + ':' + minutes + ' ' + ampm;
    document.getElementById('live-time-custom').innerHTML = timeString;
    var years = now.getFullYear();
    var months = now.getMonth();
    var days = now.getDate();
    var dateString = /*(months + 1) + '/' + days + '/' + years*/ years + '-' + (months + 1) + '-' + days;
    document.getElementById('live-date-custom').innerHTML = dateString;
    document.getElementById('live-date').value = dateString;
    document.getElementById('live-time').value = Date.getTime();
}

function startClock() {
    updateTime(); 
    setInterval(updateTime, 1000);
}


window.onload = startClock;