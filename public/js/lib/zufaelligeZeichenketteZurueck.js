// https://attacomsian.com/blog/javascript-generate-random-string
function zufaelligeZeichenketteZurueck(laenge) {
    return Math.random().toString(16).substr(2, laenge);
}
