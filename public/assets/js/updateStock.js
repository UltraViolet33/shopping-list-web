// fetch("http://shopping-list.test/product/updatestock", {
//     method: "POST",
//     headers: {
//         "Content-type": "application/json",
//       },
//       body: JSON.stringify({test: "test"}),
//     })
// .then(res => res.json())
// .then((res) => console.log(res))

const addStock_btns = document.getElementsByClassName("addStockBtn");

// for (const btn of addStock_btns) {
//   btn.addEventListener("click", function () {
//       let idProduct = parseInt(btn.parentElement.getAttribute('idProduct'));
//     let stock = btn.getAttribute("stock");
//     const newStock = parseInt(stock) + 1;
//     console.log(newStock);
//     const data = {
//       type: "updateStock",
//       idProduct: idProduct,
//       value: newStock,
//     };
//     postData(data, "http://shopping-list.test/product/updatestock");
//   });
// }

function updateStock(element) {
  console.log("ok");

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
  console.log(newStock);
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
