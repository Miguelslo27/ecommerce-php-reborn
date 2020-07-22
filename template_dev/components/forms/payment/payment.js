console.log('In payment');

const switchActions         = document.querySelectorAll('[data-action="switch"]');
const collapsableBoxes      = document.querySelectorAll('.collapsable');
const shippingReceiveRadio  = document.getElementById('shipping-receive');
const shippingWithdrawRadio = document.getElementById('shipping-withdraw');
const copyBillingAddrCheck  = document.getElementById('copy-billing-address');
const shippingButton        = document.getElementById('shipping-button');
const TIMETORELOAD          = 600;

if (shippingButton.classList.contains('pre-disabled')) {
  shippingButton.classList.add('disabled');
}

if (shippingWithdrawRadio.checked && shippingWithdrawRadio.dataset.checked == 'checked') {
  copyBillingAddrCheck.disabled = true;
  shippingButton.classList.remove('disabled');
}

console.log(shippingButton.dataset);
console.log(!(copyBillingAddrCheck.classList.contains('disabled')));

collapsableBoxes.forEach(box => {
  box.dataset.height = box.scrollHeight;

  if (box.classList.contains('open')) {
    box.style.height = `${box.scrollHeight}px`
  }
});

function handleSwitchAction(ev) {
  const target         = document.querySelectorAll(this.dataset.selector);
  const preventDefault = (this.dataset.preventDefault === 'true' ? true : false);
  const perform        = this.dataset.perform;

  if (preventDefault) {
    ev.preventDefault();
  }

  target.forEach(el => switchBox(el, perform))
}

function switchBox(target, perform) {
  const height  = target.dataset.height;

  if (
    target.classList.contains('open')
    && (
      !perform
      || perform == "close"
    )
  ) {
    target.style.height = `0`;
    target.classList.remove('open');
    target.classList.add('closed');
  } else if (
    target.classList.contains('closed')
    && (
      !perform
      || perform == "open"
    )
  ) {
    target.style.height = `${height}px`;
    target.classList.remove('closed');
    target.classList.add('open');
  }
}

shippingReceiveRadio.addEventListener('click', function (ev) {
  if (this.checked) {
    //si no se ouede usar la direccion del usuario
    if (!(copyBillingAddrCheck.classList.contains('disabled'))) {
      copyBillingAddrCheck.disabled = false;
    }
    //si el formulario esta incompleto o contiene algun error
    if (shippingButton.classList.contains('pre-disabled')) {
      shippingButton.classList.add('disabled');
      console.log('1.1');
    } else {
      shippingButton.classList.remove('disabled');
      console.log('1.2');
    }
  } else {
    copyBillingAddrCheck.disabled = true;
    console.log('2.1');
  }

  if (copyBillingAddrCheck.checked) {
    console.log('3.1');
    shippingButton.classList.remove('disabled');
    this.dataset.perform = 'close';
  } else {
    console.log('3.2');
    if (shippingButton.classList.contains('pre-disabled')) {
      shippingButton.classList.add('disabled');
    }
    this.dataset.perform = 'open';
  }

  handleSwitchAction.call(this, ev);
});

shippingWithdrawRadio.addEventListener('click', function (ev) {
  if (this.checked && this.dataset.checked == 'checked') {
    copyBillingAddrCheck.disabled = true;
    shippingButton.classList.remove('disabled');
    console.log('4.1');
  } else if (this.checked) {
    copyBillingAddrCheck.disabled = true;
    copyBillingAddrCheck.checked = false;
  } else {
    //si no se puede usar la direccion del usuario
    if (!(copyBillingAddrCheck.classList.contains('disabled'))) {
      copyBillingAddrCheck.disabled = false;
    }
  }
});

copyBillingAddrCheck.addEventListener('click', function (ev) {
  if (this.checked && shippingReceiveRadio.checked) {
    shippingReceiveRadio.dataset.perform = 'close';
    shippingButton.classList.remove('disabled');
    console.log(copyBillingAddrCheck.dataset.selected);

  } else {
    shippingReceiveRadio.dataset.perform = 'open';
    if (shippingButton.classList.contains('pre-disabled')) {
      shippingButton.classList.add('disabled');
      console.log(copyBillingAddrCheck.dataset.selected);
    }
  }

  handleSwitchAction.call(shippingReceiveRadio, ev);
});

switchActions.forEach(switchAction => {
  switchAction.addEventListener('click', function (ev) {
    handleSwitchAction.call(this, ev);
  });
});
