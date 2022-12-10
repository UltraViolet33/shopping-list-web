fetch("/getList")
  .then(res => res.json())
  // .then(res => console.log(res))
  .then(res => createTable(res));

const createTable = products => {
  const tableBody = document.querySelector("#tableProducts");

  for (const product of products) {

    const row_element = document.createElement("tr");
    const columnCheckboxe = document.createElement("td");

    const checkboxe = document.createElement("input");
    checkboxe.setAttribute("type", "checkbox");

    columnCheckboxe.appendChild(checkboxe);


    const columnName = document.createElement("td");
    columnName.textContent = product.name;

    const columnNumberToBuy = document.createElement("td");
    let numberToBuy = product.stock_min - product.stock_actual;
    numberToBuy == 0 ? 1 : numberToBuy;
    columnNumberToBuy.textContent = numberToBuy;

    row_element.appendChild(columnCheckboxe);

    row_element.appendChild(columnName);
    row_element.appendChild(columnNumberToBuy);
    tableBody.appendChild(row_element);
  }
};
