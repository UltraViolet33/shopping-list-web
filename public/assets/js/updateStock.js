const addStock_btns = document.getElementsByClassName("addStockBtn");

function updateStock(element) {
  let newStock = null;
  let idProduct = parseInt(element.parentElement.getAttribute("idProduct"));
  let stock = element.getAttribute("stock");
  if (element.textContent === "+") {
    newStock = parseInt(stock) + 1;
  } else if (element.textContent === "-") {
    newStock = parseInt(stock) - 1;
  } else {
    return false;
  }
  const data = {
    type: "updateStock",
    idProduct: idProduct,
    value: newStock,
  };
  postData(data, "http://shopping-list.test/product/updatestock");
}

const postData = (data, path) => {
  fetch(path, {
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => response.json())
    .then((response) => displayProductsHTML(response.products));
};

const displayProductsHTML = (productsHTML) => {
  const tableProducts = document.querySelector("#tableProducts");
  tableProducts.innerHTML = productsHTML;
};
