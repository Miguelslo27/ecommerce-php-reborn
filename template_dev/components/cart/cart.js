console.log('In Cart');

const updateCartButtons = document.querySelectorAll('.update-cart-button');
const deleteCartButtons = document.querySelectorAll('.delete-cart-button');
const cartItems         = document.querySelector('.cart-items');
const TIMETORELOAD      = 600;

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

const handleUpdate = function (ev) {
  ev.preventDefault();

  this.classList.add('spin');
  cartItems.classList.add('blur');

  const qtyInput = document.getElementById(this.dataset.inputId);
  const qtyAdd   = qtyInput.value - this.dataset.currentQty;
  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'aid': this.dataset.aid,
      'qty': qtyAdd
    })
  };

  fetch('/core/api.php', options)
    .then(res => res.json())
    .then(res => {
      setTimeout(() => {
        this.classList.remove('spin');
        cartItems.classList.remove('blur');
      }, TIMETORELOAD);

      handleUpdateResponse(res);
    })
    .catch(err => {
      this.classList.remove('spin');
      cartItems.classList.remove('blur');

      handleUpdateError(err);
    });
}

const handleDelete = function (ev) {
  document.getElementById(this.dataset.inputId).value = 0;
  handleUpdate.apply(this, [ev]);
}

updateCartButtons.forEach((updateButton) => updateButton.addEventListener('click', handleUpdate));
deleteCartButtons.forEach((deleteButton) => deleteButton.addEventListener('click', handleDelete))
