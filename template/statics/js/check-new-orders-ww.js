function getLastOrder(cb) {
  var xhr = new XMLHttpRequest();
      xhr.open("GET", "../../app/pedido/ultimo");
      xhr.onload = function () {
          cb(xhr.responseText);
      };
      xhr.send();
}

function updateLastOrder() {
  var xhr = new XMLHttpRequest();
      xhr.open("GET", "../../app/pedido/ultimo/actualizar");
      xhr.send();
}

setInterval(function () {
  getLastOrder(function (response) {
    postMessage(response);
    
    setTimeout(updateLastOrder, 10000);
  });
}, 30000);
