console.log('In billing');

const switchActions         = document.querySelectorAll('[data-action="switch"]');
const collapsableBoxes      = document.querySelectorAll('.collapsable');
const billingEdit           = document.getElementById('billing-edit');
const billingButton         = document.getElementById('billing-button');
const TIMETORELOAD          = 600;

collapsableBoxes.forEach(box => {
    box.dataset.height = box.scrollHeight;
  
    if (box.classList.contains('open')) {
      box.style.height = `${box.scrollHeight}px`
    } else if (box.classList.contains('closed')) {
      box.style.height = `0`
    }
});

if (billingEdit.dataset.formSuccess === 'true') {
    billingButton.classList.remove('disabled');
} else {
    billingButton.classList.add('disabled');
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


switchActions.forEach(switchAction => {
    switchAction.addEventListener('click', function (ev) {
      handleSwitchAction.call(this, ev);
    });
});