fetch("/getList")
  .then(res => res.json())
  // .then(res => console.log(res))
  .then(res => {
    createTable(res.products)
    displatStores(res.stores)
  });

const createTable = products => {
  const tableBody = document.querySelector("#tableProducts");

  for (const product of products) {

    const row_element = document.createElement("tr");
    const columnCheckboxe = document.createElement("td");

    const checkboxe = document.createElement("input");
    checkboxe.setAttribute("type", "checkbox");

    checkboxe.setAttribute("name", "products[]");
    checkboxe.setAttribute("value", product.id_products);


    columnCheckboxe.appendChild(checkboxe);


    const columnName = document.createElement("td");
    columnName.textContent = product.name;

    const columnNumberToBuy = document.createElement("td");
    let numberToBuy = product.stock_min - product.stock_actual;
    
    numberToBuy = numberToBuy == 0 ? 1 : numberToBuy;
    console.log(numberToBuy);
    columnNumberToBuy.textContent = numberToBuy;

    row_element.appendChild(columnCheckboxe);

    row_element.appendChild(columnName);
    row_element.appendChild(columnNumberToBuy);
    tableBody.appendChild(row_element);
  }
};

const displatStores = stores => {
    const stores_div = document.querySelector("#stores");

    for(const store of stores)
    {
        const p_element = document.createElement("p");
        p_element.textContent = `Store : ${store.name}, price : ${store.totalPrice} €`;
        stores_div.appendChild(p_element);
    }
}
