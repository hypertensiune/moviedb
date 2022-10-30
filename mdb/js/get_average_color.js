let colorThief = new ColorThief();
let img = document.getElementById("poster-img");

window.addEventListener('load', () => {
    let rgb = colorThief.getColor(img);
    $(":root")[0].style.setProperty("--primaryColor", rgb[0] + "," + rgb[1] + "," + rgb[2]);
    if (contrast(rgb, [0, 0, 0]) < 4.5) {
        $(":root")[0].style.setProperty("--fontColor", "white");
    }
});