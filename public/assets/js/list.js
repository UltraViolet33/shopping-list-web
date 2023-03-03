fetch("/getList")
  .then(res => res.json())
  .then(res => {
    createTable(res);
  });

const createTable = products => {
  console.log(products);

  let stores = [];

  const tableBody = document.querySelector("#tableProducts");

  for (const product of products) {
    const row_element = document.createElement("tr");

    const columnCheckboxe = document.createElement("td");

    const checkboxe = document.createElement("input");

    checkboxe.setAttribute("type", "checkbox");
    checkboxe.classList.add("products-check");

    checkboxe.setAttribute("name", "products[]");
    checkboxe.setAttribute("value", product.id_product);
    columnCheckboxe.appendChild(checkboxe);

    const columnHowMany = document.createElement("td");

    const subStractBtn = document.createElement("button");
    subStractBtn.classList.add(product.id_product);
    subStractBtn.setAttribute("type", "button");

    subStractBtn.addEventListener("click", function(event)
    {
      updateNumberToBuy(this);
    });


    subStractBtn.disabled = true;
    subStractBtn.textContent = "-";
    columnHowMany.appendChild(subStractBtn);

    const userChoice = document.createElement("p");
    userChoice.setAttribute("idproduct", product.id_product);
    userChoice.textContent = product.number_item;
    columnHowMany.appendChild(userChoice);

    const addBtn = document.createElement("button");
    addBtn.classList.add(product.id_product);

    addBtn.disabled = true;
    addBtn.textContent = "+";
    columnHowMany.appendChild(addBtn);

    const columnName = document.createElement("td");
    columnName.textContent = product.name;
    const columnNumberToBuy = document.createElement("td");

    let numberToBuy = product.number_item;
    // numberToBuy = numberToBuy == 0 ? 1 : numberToBuy;
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
    row_element.appendChild(columnHowMany);

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
      console.log(idProduct);

      toggleActionBtnNumberItemProduct(idProduct);

      // const product = products.filter(item => item.id_products == idProduct)[0];
      // for (const store of stores) {
      //   for (const storeProduct of product.stores) {
      //     if (storeProduct.idStore == store.idStore) {
      //       if (check.checked) {
      //         if (storeProduct.price) {
      //           store.total +=
      //             parseFloat(storeProduct.price.amount) * product.number_item;
      //         } else {store.total = store.total;
      //         }
      //       } else {
      //         if (storeProduct.price) {
      //           store.total -=
      //             parseFloat(storeProduct.price.amount) * product.number_item;
      //         } else {
      //           store.total = store.total;
      //         }
      //       }

      //       displayStores(stores);
      //     }
      //   }
      // }
    });
  }
};


function updateNumberToBuy()
{
  console.log("ok")

}

function toggleActionBtnNumberItemProduct(idProduct) {
  const btnProduct = document.getElementsByClassName(idProduct);

  console.log(btnProduct);

  for (btn of btnProduct) {
    btn.disabled = !btn.disabled;
  }
}
