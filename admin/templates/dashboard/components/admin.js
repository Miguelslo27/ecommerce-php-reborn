const itemsLink = document.querySelectorAll('.link');
const closeBoxs = document.querySelectorAll('.close-box');

var previousItem = null;

const handleMenuLink = function () {
  if (this.dataset.open === "false") {
    if (previousItem !== null) {
      console.log('entra')
      document.getElementById(previousItem).classList.add('disabled');
      document.querySelector('.item-' + previousItem).children[1].classList.add('disabled');
      document.querySelector('.item-' + previousItem).dataset.open = "false";
    }
    this.dataset.open = "true";
    document.getElementById(this.dataset.type).classList.remove('disabled');
    //remove disabled to triangle
    this.children[1].classList.remove('disabled');
    previousItem = this.dataset.type;
  } else {
    this.dataset.open = "false";
    document.getElementById(this.dataset.type).classList.add('disabled');
    //add disabled to triangle
    this.children[1].classList.add('disabled');
  }
}

const handleCloseMenuLink = function () {
  document.getElementById(this.dataset.closeType).classList.add('disabled');
  document.querySelector('.item-' + this.dataset.closeType).children[1].classList.add('disabled');
  document.querySelector('.item-' + this.dataset.closeType).dataset.open = "false";
}

itemsLink.forEach(link => { link.addEventListener('click', handleMenuLink) });
closeBoxs.forEach(box => { box.addEventListener('click', handleCloseMenuLink) });

