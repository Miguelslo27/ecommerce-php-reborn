//NAVBAR
const itemsLink = document.querySelectorAll('.link');
const closeBoxs = document.querySelectorAll('.close-box');
var previousItem = null;

const handleMenuLink = function () {
  if (this.dataset.open === "false") {
    if (previousItem !== null) {
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


//NETWORKS
const buttons             = document.querySelectorAll('button[type=button]');
const n_facebook          = document.getElementById('network_facebook');
const n_instagram         = document.getElementById('network_instagram');
const n_twitter           = document.getElementById('network_twitter');
const n_youtube           = document.getElementById('network_youtube');
const addNetworkButton    = document.querySelector('.add-network-button');
const editNetworkButton    = document.querySelector('.edit-network-button');
const deleteNetworkButton = document.querySelectorAll('.remove-network-button');
const form                = document.querySelector('.form');
const addSelectInput      = document.querySelector('.add-network');
const TIMETORELOAD      = 600;

const handleUpdateResponse = (res, type) => {
  console.log(res);
  if (res.succeeded) {
    if (type === 'edit') {
      var url = (window.location.origin + window.location.pathname + '?sid=redes');
      setTimeout(() => window.location.assign(url), 600);
    } else if (type == 'add-admin' || type == 'edit-admin') {
      var url = (window.location.origin + window.location.pathname + '?sid=admins');
      setTimeout(() => window.location.assign(url), 600);
    } else {
      setTimeout(() => window.location.reload(), 600);
    }
  } else {
    handleUpdateError(res.errors.join('\n'));
  }
}

const handleUpdateError = (err) => {
  alert(err);
}

const handleNetwork = function (ev) {
  ev.preventDefault();

  form.classList.add('blur');
  var inputValue = null;
  if (this.dataset.type === "add") {
    var tag = addSelectInput.value;
  } else {
    var tag = this.dataset.network;
  }

  if (this.dataset.type === "edit") {
    var inputValue = document.getElementById(this.dataset.input).value;
  }

  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'type': this.dataset.type,
      'tag': tag,
      'input': inputValue
    })
  };

  fetch('/core/api.php', options)
    .then(res => res.json())
    .then(res => {
      setTimeout(() => {
        form.classList.remove('blur');
      }, TIMETORELOAD);

      handleUpdateResponse(res, this.dataset.type);
    })
    .catch(err => {
      form.classList.remove('blur');

      handleUpdateError(err);
    });
}

const handleDeleteNetwrok = function (ev) {
  handleNetwork(this, [ev]);
}

if (addNetworkButton !== null) {
  addNetworkButton.addEventListener('click', handleNetwork);
}

if (editNetworkButton !== null) {
  editNetworkButton.addEventListener('click', handleNetwork);
}

deleteNetworkButton.forEach(deleteButton => { deleteButton.addEventListener('click', handleNetwork) });

//ADMINS
const addAdminButton = document.querySelector('.add-admin-button');
const removeAdminButtons = document.querySelectorAll('.remove-admin-button');


const handleAdmin = function (ev) {
  ev.preventDefault();
  form.classList.add('blur');
  var inputValue = null;
  var roleValue = null;

  if (this.dataset.type === "add-admin" || this.dataset.type === "edit-admin") {
    var inputValue = document.getElementById(this.dataset.input).value;
    var roleValue = document.getElementById(this.dataset.role).value;
  } else if (this.dataset.type === "remove-admin") {
    var inputValue = this.dataset.input;
  }
  console.log(roleValue);

  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'type': this.dataset.type,
      'input': inputValue,
      'role': roleValue
    })
  };

  fetch('/core/api.php', options)
    .then(res => res.json())
    .then(res => {
      setTimeout(() => {
        form.classList.remove('blur');
      }, TIMETORELOAD);

      handleUpdateResponse(res, this.dataset.type);
    })
    .catch(err => {
      form.classList.remove('blur');
      handleUpdateError('error');
    });
}

if (addAdminButton !== null) {
  addAdminButton.addEventListener('click', handleAdmin);
}

removeAdminButtons.forEach(removeButton => { removeButton.addEventListener('click', handleAdmin) });
