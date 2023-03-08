let list = (function () {
  let model = {
    data: [],
  };

  model.initializeProducts = function (products) {
    const data = products;
    products.forEach(product => (product.isInList = false));
    this.data = products;
    view.maj();
  };

  model.putProductInList = function (idProduct) {
    for (const product of this.data) {
      if (product.id_product == idProduct) {
        product.isInList = !product.isInList;
      }
    }
    view.maj();
  };

  model.addItem = function (idProduct) {
    for (const product of this.data) {
      if (product.id_product == idProduct) {
        if (product.numberToBuy) {
          product.numberToBuy += 1;
        } else {
          product.numberToBuy = product.number_item + 1;
        }
      }
    }
    view.maj();
  };

  model.removeItem = function (idProduct) {
    for (const product of this.data) {
      if (product.id_product == idProduct) {
        if (product.numberToBuy) {
          product.numberToBuy -= 1;
        } else {
          product.numberToBuy = product.number_item - 1;
        }
      }
    }

    view.maj();
  };

  let view = {
    maj: function () {
      const tableProducts = document.getElementById("tableProducts");
      let html = "";

      for (product of model.data) {
        // console.log(product);
        html += `<tr><td><input type="checkbox" onchange="onChange(${product.id_product})" id="${product.id_product}"></td>`;

        if (product.isInList) {
          html += `<td><button class="btn btn-danger" type="button" onclick="list.removeItem(${product.id_product})">-</button>`;
          html += product.numberToBuy
            ? `${product.numberToBuy}`
            : `${product.number_item}`;
          html += `<button class="btn btn-primary" type="button" onclick="list.addItem(${product.id_product})" ">+</button></td>`;
        } else {
          html += '<td><button class="btn btn-danger" disabled>-</button>';
          html += `${product.number_item}`;
          html += '<button class="btn btn-primary" disabled>+</button></td>';
        }

        html += `<td>${product.name}</td>`;
        html += `<td>${product.number_item}</td>`;

        html += `<td>`;
        for (store of product.stores) {
          html += `<p>${store.storeName} - ${store.price.amount} €</p>`;
        }

        html += "</td>";
      }

      tableProducts.innerHTML = html;
    },
  };

  return {
    initialize: function () {
      getProducts().then(products => {
        // console.log(products);
        model.initializeProducts(products);
      });
    },

    putProductInList: function (idProduct) {
      model.putProductInList(idProduct);
    },

    addItem: function (idProduct) {
      model.addItem(idProduct);
    },

    removeItem: function (idProduct) {
      model.removeItem(idProduct);
    },


  };
})();

async function getProducts() {
  const response = await fetch("/getList");
  return response.json();
}

window.addEventListener("load", event => {
  list.initialize();
});

function onChange(id) {
  list.putProductInList(id);
}
