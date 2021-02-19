// Changement des couleurs en live
// Changement background
let colorPickerBackground = document.querySelector('#background_color');

function watchColorPickerBackground(){
  document.querySelector("#previsualisation").style.backgroundColor = colorPickerBackground.value;
}

colorPickerBackground.addEventListener("input", watchColorPickerBackground, false);

// Changement Font
let colorPickerFont = document.querySelector('#font_color');

function watchColorPickerFont(){
  document.querySelector("#pres p").style.color = colorPickerFont.value;
}

colorPickerFont.addEventListener("input", watchColorPickerFont, false);

// Changement Link
let colorPickerLink = document.querySelector('#link_color');
document.querySelector(":root").style.setProperty(`--couleurLink`, colorPickerLink.value);

function watchColorPickerLink(){
    document.querySelector(":root").style.setProperty(`--couleurLink`, colorPickerLink.value);
}

colorPickerLink.addEventListener("input", watchColorPickerLink, false);

// Changement Link
let colorPickerLinkHover = document.querySelector('#hover_link_color');
document.querySelector(":root").style.setProperty(`--couleurHover`, colorPickerLinkHover.value);
function watchColorPickerHover(){
    document.querySelector(":root").style.setProperty(`--couleurHover`, colorPickerLinkHover.value);
}

colorPickerLinkHover.addEventListener("input", watchColorPickerHover, false);