console.log('In payment');

const switchActionLinks = document.querySelectorAll('[data-action="switch"]');
const shippingRadioButtons = document.querySelectorAll('[name="shipping"]');

function handleSwitchAction(ev, callback) {
  const target         = document.querySelector(this.dataset.selector);
  const scrollHeight   = target.scrollHeight || null;
  const height         = this.dataset.height || scrollHeight;
  const preventDefault = this.dataset.preventDefault;
  let switchIsOn       = false;
  
  if (preventDefault) {
    ev.preventDefault();
  }

  if (target.style.height != `${height}px`) {
    target.style.height = `${height}px`;
    switchIsOn = true;
  } else {
    target.style.height = '0px';
    switchIsOn = false;
  }

  if (callback) {
    callback(switchIsOn);
  }
}

switchActionLinks.forEach(link => {
  link.addEventListener('click', function (ev) {
    handleSwitchAction.call(this, ev, (switchIsOn) => {
      const saveUserInfoButton = document.querySelector('.save-user-info');
      if (switchIsOn) {
        saveUserInfoButton.classList.add('visible');
      } else {
        saveUserInfoButton.classList.remove('visible');
      }
    });
  });
});

shippingRadioButtons.forEach(radiobutton => {
  radiobutton.addEventListener('click', handleSwitchAction);
});
