let list = (function () {
  let model = {
    data: [],
    stores: [],
    cheaperList: [],
  };

  model.initializeProducts = function (products) {
    // const data = products;
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

        storeEl = this.cheaperList.find(el => el.name == store.storeName);
        if (!storeEl) {
          this.cheaperList.push({
            name: store.storeName,
            amount: 0,
            products: [],
            unknowPrice: 0,
          });
        }
      }
    }

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

  model.resetCheaperList = function () {
    this.cheaperList.forEach(store => {
      store.amount = 0;
      store.unknowPrice = 0;
      store.products = [];
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
    this.calculateCheaperList();

    view.maj();
  };

  model.calculateCheaperList = function () {
    this.resetCheaperList();
    const productsInList = this.getAllProductsInList();

    for (const product of productsInList) {
      const cheaperStore = this.getCheaperStorePrice(product);
      if (cheaperStore) {
        this.addProductToCheaperList(product, cheaperStore);
      }
    }
  };

  model.addProductToCheaperList = function (product, store) {
    let storeCheaperList = this.cheaperList.find(
      st => st.name == store.storeName
    );

    storeCheaperList.products.push(product);

    for (const storeProduct of product.stores) {
      if (storeProduct.storeName == storeCheaperList.name) {
        if (product.numberToBuy) {
          storeCheaperList.amount +=
            parseFloat(storeProduct.price.amount) *
            parseInt(product.numberToBuy);
        } else {
          storeCheaperList.amount +=
            parseFloat(storeProduct.price.amount) *
            parseInt(product.number_item);
        }
      }
    }
  };

  model.getCheaperStorePrice = function (product) {
    let cheaperStore = product.stores[0];

    for (const store of product.stores) {
      if (store.price) {
        if (
          parseFloat(store.price.amount) < parseFloat(cheaperStore.price.amount)
        ) {
          cheaperStore = store;
        }
      }
    }

    if (cheaperStore.price) {
      return cheaperStore;
    }

    return false;
  };

  model.getAllProductsInList = function () {
    return this.data.filter(product => product.isInList);
  };

  let view = {
    maj: function () {
      const tableProducts = document.getElementById("tableProducts");
      const storesDiv = document.getElementById("storesAmount");
      const cheaperListDiv = document.getElementById("cheaper-list");

      let html = "";

      for (product of model.data) {
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

      let totalCheaperList = 0;
      for (const store of model.cheaperList) {
        totalCheaperList += store.amount;
      }

      let cheaperListHtml = `<h3>Liste de courses pour payer moins cher - ${totalCheaperList.toFixed(2)} €</h3>`;
      for (const store of model.cheaperList) {
        cheaperListHtml += `<h4>${store.name} - ${store.amount.toFixed(2)} € </h4>`;

        for (const product of store.products) {
          cheaperListHtml += `<p>${product.name}</p>`;
        }
      }
      cheaperListDiv.innerHTML = cheaperListHtml;
    },
  };

  return {
    initialize: function () {
      getProducts().then(products => {
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
