console.log('In payment');

const switchActions         = document.querySelectorAll('[data-action="switch"]');
const collapsableBoxes      = document.querySelectorAll('.collapsable');
const shippingReceiveRadio  = document.getElementById('shipping-receive');
const shippingWithdrawRadio = document.getElementById('shipping-withdraw');
const copyBillingAddrCheck  = document.getElementById('copy-billing-address');
const TIMETORELOAD          = 600;

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
    copyBillingAddrCheck.disabled = false;
  } else {
    copyBillingAddrCheck.disabled = true;
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
  } else {
    copyBillingAddrCheck.disabled = false;
  }
});

copyBillingAddrCheck.addEventListener('click', function (ev) {
  if (this.checked && shippingReceiveRadio.checked) {
    shippingReceiveRadio.dataset.perform = 'close';
  } else {
    shippingReceiveRadio.dataset.perform = 'open';
  }

  handleSwitchAction.call(shippingReceiveRadio, ev);
});

switchActions.forEach(switchAction => {
  switchAction.addEventListener('click', function (ev) {
    handleSwitchAction.call(this, ev);
  });
});
