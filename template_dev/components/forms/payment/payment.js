console.log('In payment');

const switchActionLinks    = document.querySelectorAll('[data-action="switch"]');
const shippingRadioButtons = document.querySelectorAll('[name="shipping"]');
const collapsableBoxes     = document.querySelectorAll('.collapsable');
const TIMETORELOAD         = 600;

collapsableBoxes.forEach(box => {
  box.dataset.height = box.scrollHeight;

  if (box.classList.contains('open')) {
    box.style.height = `${box.scrollHeight}px`
  }
});

function handleSwitchAction(ev) {
  const target         = document.querySelector(this.dataset.selector);
  const height         = target.dataset.height;
  const preventDefault = this.dataset.preventDefault;

  if (preventDefault) {
    ev.preventDefault();
  }

  if (target.classList.contains('open')) {
    target.style.height = `0`;
    target.classList.remove('open');
    target.classList.add('closed');
  } else {
    target.style.height = `${height}px`;
    target.classList.remove('closed');
    target.classList.add('open');
  }
}

switchActionLinks.forEach(link => {
  link.addEventListener('click', function (ev) {
    handleSwitchAction.call(this, ev);
  });
});

shippingRadioButtons.forEach(radiobutton => {
  radiobutton.addEventListener('click', handleSwitchAction);
});
