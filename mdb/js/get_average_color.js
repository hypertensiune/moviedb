let colorThief = new ColorThief();
let img = document.getElementById("poster-img");

function luminance(r, g, b) {
    let a = [r, g, b].map(v => {
        v /= 255;
        return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
    });
    return a[0] * 0.2126 + a[1] * 0.7125 + a[2] * 0.722;
}

function contrast(rgb1, rgb2) {
    let lum1 = luminance(rgb1[0], rgb1[1], rgb1[2]);
    let lum2 = luminance(rgb2[0], rgb2[1], rgb2[2]);
    let brightest = Math.max(lum1, lum2);
    let darkest = Math.min(lum1, lum2);
    return (brightest + 0.05) / (darkest + 0.05);
}

window.addEventListener('load', () => {
    let rgb = colorThief.getColor(img);
    $(":root")[0].style.setProperty("--primaryColor", rgb[0] + "," + rgb[1] + "," + rgb[2]);
    if (contrast(rgb, [0, 0, 0]) < 4.5) {
        $(":root")[0].style.setProperty("--fontColor", "white");
    }
});