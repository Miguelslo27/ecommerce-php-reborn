function getLastOrder(cb) {
  var xhr = new XMLHttpRequest();
      xhr.open("GET", "../../app/pedido/ultimo");
      xhr.onload = function () {
          cb(xhr.responseText);
      };
      xhr.send();
}

setInterval(function () {
  getLastOrder(function (response) {
    postMessage(response);
  });
}, 60000);
