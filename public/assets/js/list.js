fetch("/getList")
  .then(res => res.json())
  .then(res => {
    createTable(res);
  });

const createTable = products => {
  let stores = [];

  const tableBody = document.querySelector("#tableProducts");

  for (const product of products) {
    const row_element = document.createElement("tr");
    const columnCheckboxe = document.createElement("td");

    const checkboxe = document.createElement("input");
    checkboxe.setAttribute("type", "checkbox");
    checkboxe.classList.add("products-check");

    checkboxe.setAttribute("name", "products[]");
    checkboxe.setAttribute("value", product.id_products);
    columnCheckboxe.appendChild(checkboxe);

    const columnName = document.createElement("td");
    columnName.textContent = product.name;
    const columnNumberToBuy = document.createElement("td");

    let numberToBuy = product.number_item;
    numberToBuy = numberToBuy == 0 ? 1 : numberToBuy;
    columnNumberToBuy.textContent = numberToBuy;
    const columnPrice = document.createElement("td");

    stores = [];

    for (const item of product.stores) {
      stores.push({
        idStore: item.idStore,
        storeName: item.storeName,
        total: 0,
      });
      columnPrice.innerHTML += `<p>${item.storeName} : ${
        item.price ? item.price.amount + " €" : "no price"
      }</p>`;
    }

    row_element.appendChild(columnCheckboxe);
    row_element.appendChild(columnName);
    row_element.appendChild(columnNumberToBuy);
    row_element.appendChild(columnPrice);
    tableBody.appendChild(row_element);
  }

  displayStores(stores);
  handleCheck(products, stores);
};

const displayStores = stores => {
  const stores_div = document.querySelector("#stores");
  stores_div.innerHTML = "";
  for (const item of stores) {
    stores_div.innerHTML += `<p>${item.storeName} : ${item.total} € </p>`;
  }
};

const handleCheck = (products, stores) => {
  const checkboxProducts = document.querySelectorAll(".products-check");

  for (const check of checkboxProducts) {
    check.addEventListener("change", function (event) {
      const idProduct = check.getAttribute("value");
      const product = products.filter(item => item.id_products == idProduct)[0];
      for (const store of stores) {
        for (const storeProduct of product.stores) {
          if (storeProduct.idStore == store.idStore) {
            if (check.checked) {
              store.total += storeProduct.price
                ? parseInt(storeProduct.price.amount)
                : 0;
            } else {
              store.total -= storeProduct.price
                ? parseInt(storeProduct.price.amount)
                : 0;
            }

            displayStores(stores);
          }
        }
      }
    });
  }
};
