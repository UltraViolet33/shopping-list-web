let list = (function () {
  let model = {
    data: [],
    stores: [],
  };

  model.initializeProducts = function (products) {
    const data = products;
    console.log(products);
    products.forEach(product => (product.isInList = false));

    this.data = products;

    for (const product of this.data) {
      for (const store of product.stores) {
        let storeEl = this.stores.find(el => el.name == store.storeName);

        if (!storeEl) {
          this.stores.push({
            name: store.storeName,
            amount: 0,
            unknowPrice: 0,
          });
        }
      }
    }

    console.log(this.stores);

    view.maj();
  };

  model.putProductInList = function (idProduct) {
    for (const product of this.data) {
      if (product.id_product == idProduct) {
        product.isInList = !product.isInList;
      }
    }
    this.calculateTotalStores();
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
    this.calculateTotalStores();
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
    this.calculateTotalStores();
    view.maj();
  };

  model.resetTotalStores = function () {
    this.stores.forEach(store => {
      store.amount = 0;
      store.unknowPrice = 0;
    });
  };

  model.calculateTotalStores = function () {
    this.resetTotalStores();
    for (const product of this.data) {
      for (const store of product.stores) {
        for (const storeModel of this.stores) {
          if (storeModel.name == store.storeName && product.isInList) {
            if (store.price.amount) {
              if (product.numberToBuy) {
                storeModel.amount +=
                  parseFloat(store.price.amount) *
                  parseInt(product.numberToBuy);
              } else {
                storeModel.amount +=
                  parseFloat(store.price.amount) *
                  parseInt(product.number_item);
              }
            } else {
              storeModel.unknowPrice += 1;
            }
          }
        }
      }
    }

    view.maj();
  };

  let view = {
    maj: function () {
      const tableProducts = document.getElementById("tableProducts");
      const storesDiv = document.getElementById("storesAmount");
      let html = "";

      for (product of model.data) {
        // console.log(product);
        html += `<tr><td><input type="checkbox" onchange="onChange(${
          product.id_product
        })" id="${product.id_product}" ${
          product.isInList ? "checked" : ""
        }></td>`;

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
          html += `<p>${store.storeName} - ${
            store.price.amount ?? "unknown"
          } €</p>`;
        }

        html += "</td>";
      }

      let storeHtml = "";
      for (store of model.stores) {
        storeHtml += `<p>${store.name} - ${store.amount.toFixed(2)} € ${
          store.unknowPrice > 0
            ? "-" + store.unknowPrice + " unknow products price"
            : ""
        }</p>`;
      }

      tableProducts.innerHTML = html;

      storesDiv.innerHTML = storeHtml;
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
