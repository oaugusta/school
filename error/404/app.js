function short() {
    var wl = 40;
    var fs = window.location.toString();
    var fl = fs.length;
    var el = fl - 4;
    var ss = fs.substring(0,wl) + '...' + fs.substring(el,fl);
    if (fl <= wl) {
        document.getElementById('adresa').textContent = fs;
    } else {
        document.getElementById('adresa').textContent = ss;
    }
}