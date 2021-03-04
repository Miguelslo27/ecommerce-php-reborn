//NAVBAR
const itemsLink = document.querySelectorAll('.link');
const closeBoxs = document.querySelectorAll('.close-box');
var previousItem = null;

const handleMenuLink = function () {
  if (this.dataset.open === "false") {
    if (previousItem !== null) {
      document.getElementById(previousItem).classList.remove('show-box');
      document.getElementById(previousItem).classList.add('hide-box');
      document.querySelector('.item-' + previousItem).children[1].classList.add('disabled');
      document.querySelector('.item-' + previousItem).dataset.open = "false";
    }
    this.dataset.open = "true";
    document.getElementById(this.dataset.type).classList.remove('hide-box');
    document.getElementById(this.dataset.type).classList.add('show-box');
    //remove disabled to triangle
    this.children[1].classList.remove('disabled');
    previousItem = this.dataset.type;
  } else {
    this.dataset.open = "false";
    document.getElementById(this.dataset.type).classList.remove('show-box');
    document.getElementById(this.dataset.type).classList.add('hide-box');
    //add disabled to triangle
    this.children[1].classList.add('disabled');
  }
}

const handleCloseMenuLink = function () {
  document.getElementById(this.dataset.closeType).classList.remove('show-box');
  document.getElementById(this.dataset.closeType).classList.add('hide-box');
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
const editNetworkButton   = document.querySelector('.edit-network-button');
const deleteNetworkButton = document.querySelectorAll('.remove-network-button');
const addSelectInput      = document.querySelector('.add-network-select');
const form                = document.querySelector('.form');
const TIMETORELOAD        = 600;


const handleUpdateResponse = (res, type) => {
  console.log(res);
  if (res.succeeded)
  {
    if (type == 'edit-network')
    {
      var url = (window.location.origin + window.location.pathname + '?sid=redes');
      setTimeout(() => window.location.assign(url), 600);
    } 
    else if (type == 'add-admin' || type == 'edit-admin')
    {
      var url = (window.location.origin + window.location.pathname + '?sid=admins');
      setTimeout(() => window.location.assign(url), 600);
    }
    else
    {
      setTimeout(() => window.location.reload(), 600);
    }
  }
  else
  {
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
  if (this.dataset.type === "add-network") {
    var tag = addSelectInput.value;
  } else {
    var tag = this.dataset.network;
  }

  if (this.dataset.type === "edit-network") {
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


//CATEGORIES 
const restoreCategoryButton   = document.querySelectorAll('.restore-category-button');
const removeCategoryButtons   = document.querySelectorAll('.remove-category-button');
const saveAndCreateNewButton  = document.getElementById('save-and-create-new-button');
const categoryForm            = document.getElementById('category-form');

const handleCategory = function (ev) {
  ev.preventDefault();
  form.classList.add('blur');

  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'type': this.dataset.type,
      'id': this.dataset.id
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

const handleSecondaryButton = () => {
  let input = document.getElementById('button-action');
  input.value = "secondary-button";
}

if (saveAndCreateNewButton && saveAndCreateNewButton.dataset.success) {
  categoryForm.reset();
  document.getElementById('category_title').focus();
}

removeCategoryButtons.forEach(removeButton => { removeButton.addEventListener('click', handleCategory) });
restoreCategoryButton.forEach(restoreButton => { restoreButton.addEventListener('click', handleCategory) });
saveAndCreateNewButton ? saveAndCreateNewButton.addEventListener('click', handleSecondaryButton) : '';

//ARTICLES
const offerArticleCheckBox    = document.getElementById('article_offer');
const newArticleCheckBox      = document.getElementById('article_new');
const spentArticleCheckBox    = document.getElementById('article_spent');
const articePriceOfferInput   = document.getElementById('article_price_offer');
const articlePriceOfferLabel  = document.getElementById('article_price_offer_label');
const collapsableBox          = document.querySelector('.collapsable-box');
const restoreArticleButtons   = document.querySelectorAll('.restore-article-button');

if(collapsableBox) {
  collapsableBox.dataset.height = collapsableBox.scrollHeight;
  if (collapsableBox.classList.contains('open')) {
    collapsableBox.style.height = `${collapsableBox.scrollHeight}px`
  } else if (collapsableBox.classList.contains('closed')) {
    collapsableBox.style.height = `0`
  }
}

if (offerArticleCheckBox) {
  if (offerArticleCheckBox.checked) {
    collapsableBox.classList.add('open');
    collapsableBox.classList.remove('closed');
    collapsableBox.style.height = `${collapsableBox.dataset.height}px`;
  } else {
    collapsableBox.classList.add('closed');
    collapsableBox.classList.remove('open');
    collapsableBox.style.height = 0;
  }
}

const handleOfferArticleCheckBox = (ev) => {
  if (offerArticleCheckBox.checked) {
    offerArticleCheckBox.value = 'offer'
    collapsableBox.classList.add('open');
    collapsableBox.classList.remove('closed');
    collapsableBox.style.height = `${collapsableBox.dataset.height}px`;
  } else {
    offerArticleCheckBox.value = ''
    collapsableBox.classList.add('closed');
    collapsableBox.classList.remove('open');
    collapsableBox.style.height = 0;
  } 
}

const handleNewArticleCheckBox = (ev) => {
  ev.preventDefault;
  if (newArticleCheckBox.checked) {
    newArticleCheckBox.value = 'new';
  } else {
    newArticleCheckBox.value = '';
  }
}

const handleSpentArticleCheckBox = (ev) => {
  ev.preventDefault;
  if (spentArticleCheckBox.checked) {
    spentArticleCheckBox.value = 'spent';
  } else {
    spentArticleCheckBox.value = '';
  }
}

const handleRestorArticle = function (ev) {
  ev.preventDefault();
  form.classList.add('blur');

  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'id': this.dataset.id
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

if (offerArticleCheckBox) {
  offerArticleCheckBox.addEventListener('click', handleOfferArticleCheckBox);
  newArticleCheckBox.addEventListener('click', handleNewArticleCheckBox);
  spentArticleCheckBox.addEventListener('click', handleSpentArticleCheckBox)
}
restoreArticleButtons.forEach(button => {
  button.addEventListener("click", handleRestorArticle);
});

//USERS
const suspendUserButtons      = document.querySelectorAll('.suspend-button');
const unsuspendUserButtons    = document.querySelectorAll('.unsuspend-button');
const saveAndCreateNewUser    = document.getElementById('save-and-create-new-user');
const userForm                = document.getElementById('user-form');

const handleSuspendUser = function (ev) {
  ev.preventDefault();
  form.classList.add('blur');

  const options  = {
    method: 'POST',
    headers:{
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      'action': this.dataset.action,
      'type': this.dataset.type,
      'id': this.dataset.id
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

const handleSaveAndCreateButton = () => {
  let input = document.getElementById('button-action-user');
  input.value = "secondary-button";
}

if (saveAndCreateNewUser && saveAndCreateNewUser.dataset.success) {
  userForm.reset();
  document.getElementById('name').focus();
}

suspendUserButtons.forEach(button => {
  button.addEventListener("click", handleSuspendUser);
});

unsuspendUserButtons.forEach(button => {
  button.addEventListener("click", handleSuspendUser);
});

saveAndCreateNewUser ? saveAndCreateNewUser.addEventListener('click', handleSaveAndCreateButton) : '';
