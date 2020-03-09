console.log('In payment');

const switchActionLinks    = document.querySelectorAll('[data-action="switch"]');
const shippingRadioButtons = document.querySelectorAll('[name="shipping"]');
const saveUserInfoButton   = document.querySelector('.save-user-info');
const TIMETORELOAD         = 600;

const handleUpdateResponse = (res) => {
  /**
   * @TODO
   * Process response
   * Update the cart
   * Show success message
   */

  /**
   * This will work as workaround
   * for version 1.0.0
   */
  if (res.succeeded) {
    setTimeout(() => window.location.reload(), TIMETORELOAD);
  } else {
    handleUpdateError(res.errors.join('\n'));
  }
};

const handleUpdateError = (err) => {
  /**
   * @TODO
   * Process response
   * Show error message
   */

  /**
   * This will work as workaround
   * for version 1.0.0
   */
  alert(err);
};

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

function handleSaveUserInfo(ev) {
  ev.preventDefault();

  console.log(this.dataset);

  const userInfoForm = document.querySelector(this.dataset.formSelector);
  const userInfoData = userInfoForm.querySelectorAll('input');
  const data         = {};

  userInfoData.forEach(input => {
    data[input.getAttribute('name')] = input.value;
  });

  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'data': data
    })
  };

  console.log(options);

  fetch('/core/api.php', options)
    .then(res => res.json())
    .then(res => {
      // setTimeout(() => {
      //   this.classList.remove('spin');
      //   cartItems.classList.remove('blur');
      // }, TIMETORELOAD);

      handleUpdateResponse(res);
    })
    .catch(err => {
      // this.classList.remove('spin');
      // cartItems.classList.remove('blur');

      handleUpdateError(err);
    });
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

saveUserInfoButton.addEventListener('click', handleSaveUserInfo);

shippingRadioButtons.forEach(radiobutton => {
  radiobutton.addEventListener('click', handleSwitchAction);
});
