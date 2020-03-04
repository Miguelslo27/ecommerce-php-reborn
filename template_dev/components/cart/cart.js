console.log('In Cart');

const updateCartButtons = document.querySelectorAll('.update-cart-button');

const handleUpdateResponse = (res) => {
  console.log(res);
};

const handleUpdateError = (err) => {
  console.error(err);
};

const handleUpdate = function (ev) {
  ev.preventDefault();
  
  const qtyInput = document.getElementById(this.dataset.inputId);
  const qtyAdd   = qtyInput.value - this.dataset.currentQty;
  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': 'add_to_cart',
      'aid': this.dataset.aid,
      'qty': qtyAdd
    })
  };

  console.log(options);

  fetch('/core/api.php', options)
    .then(res => res.json())
    .then(handleUpdateResponse)
    .catch(handleUpdateError);
}

updateCartButtons.forEach((updateButton) => updateButton.addEventListener('click', handleUpdate));
