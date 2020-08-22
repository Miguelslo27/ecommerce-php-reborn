console.log('In payment');

const switchActions         = document.querySelectorAll('[data-action="switch"]');
const collapsableBoxes      = document.querySelectorAll('.collapsable');
const shippingReceiveRadio  = document.getElementById('shipping-receive');
const shippingWithdrawRadio = document.getElementById('shipping-withdraw');
const copyBillingAddrCheck  = document.getElementById('copy-billing-address');
const shippingButton        = document.getElementById('shipping-button');
const withdrawDivs           = document.querySelectorAll('.withdraw-auxiliar');
const shippingAddressDiv    = document.getElementById('shipping-address-div');
const TIMETORELOAD          = 600;

collapsableBoxes.forEach(box => {
  box.dataset.height = box.scrollHeight;

  if (box.classList.contains('open')) {
    box.style.height = `${box.scrollHeight}px`
  } else if (box.classList.contains('closed')) {
    box.style.height = `0`
  }
});

if (shippingWithdrawRadio.checked) {
  copyBillingAddrCheck.disabled = true;
  copyBillingAddrCheck.checked = false;
  withdrawDivs.forEach(div => { div.style.height = '0' });
}

if (shippingWithdrawRadio.checked && shippingWithdrawRadio.dataset.success != 'error') {
  shippingButton.classList.remove('disabled');
}

if (shippingReceiveRadio.checked && shippingReceiveRadio.dataset.success) {
  shippingButton.classList.remove('disabled');
}

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
    if (shippingWithdrawRadio.checked) {
      withdrawDivs.forEach(div => { div.style.height = '0' });
    }
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
    if (!shippingWithdrawRadio.checked) {
      withdrawDivs.forEach(div => {
        var height = div.dataset.height;
        div.style.height = `${height}px`;
      })
    }
  }
}

shippingReceiveRadio.addEventListener('click', function (ev) {
  if (this.checked) {
    copyBillingAddrCheck.disabled = false;
    if (this.dataset.success && (shippingReceiveRadio.dataset.method == 1)) {
      shippingButton.classList.remove('disabled');
    } else {
      shippingButton.classList.add('disabled');
    }
  } 

  if (copyBillingAddrCheck.checked) {
    this.dataset.perform = 'close';
  } else {
    this.dataset.perform = 'open';
  }
  handleSwitchAction.call(this, ev);
});

shippingWithdrawRadio.addEventListener('click', function (ev) {
  if (this.checked) {
    copyBillingAddrCheck.disabled = true;
    copyBillingAddrCheck.checked = false; 
    withdrawDivs[1].style.height = '0';
  } 
  if (this.checked && this.dataset.checked == 'checked') {
    shippingButton.classList.remove('disabled');
  } else {
    shippingButton.classList.add('disabled');
  }
});

copyBillingAddrCheck.addEventListener('click', function (ev) {
  if (this.checked) {
    shippingReceiveRadio.dataset.perform = 'close';
    shippingButton.classList.add('disabled');
  } else {
    shippingReceiveRadio.dataset.perform = 'open';
    if (shippingReceiveRadio.dataset.method == 1 && shippingReceiveRadio.dataset.success) {
      shippingButton.classList.remove('disabled');
    }
  }

  if (this.checked && shippingReceiveRadio.dataset.method == 2) {
    shippingButton.classList.remove('disabled');
  } else if (!(this.checked) && shippingReceiveRadio.dataset.method == 2) {
    shippingButton.classList.add('disabled');
  }

  handleSwitchAction.call(shippingReceiveRadio, ev);
});

switchActions.forEach(switchAction => {
  switchAction.addEventListener('click', function (ev) {
    handleSwitchAction.call(this, ev);
  });
});
