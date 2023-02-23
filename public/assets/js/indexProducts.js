const getProducts = () => {
  console.log("fetch");
  fetch("products/all")
    .then(response => response.json())
    .then(response => displayProductsHTML(response.products));
};

const displayProductsHTML = productsHTML => {
  const tableProducts = document.querySelector("#tableProducts");
  tableProducts.innerHTML = productsHTML;
};

const addStock_btns = document.getElementsByClassName("addStockBtn");

function updateStock(element) {
  let newStock = null;
  let idProduct = parseInt(element.parentElement.getAttribute("idProduct"));
  let stock = element.getAttribute("stock");
  if (element.textContent === "+") {
    newStock = parseInt(stock) + 1;
  } else if (element.textContent === "-") {
    if (parseInt(stock) == 0) {
      newStock = 0;
    } else {
      if (parseInt(stock) == 100) {
        newStock = stock;
      } else {
        newStock = parseInt(stock) - 1;
      }
    }
  } else {
    return false;
  }
  const data = {
    type: "updateStock",
    idProduct: idProduct,
    value: newStock,
  };
  postData(data, "/product/updatestock");
}

const postData = (data, path) => {
  fetch(path, {
    method: "POST",
    headers: {
      "Content-type": "application/json",
    },
    body: JSON.stringify(data),
  }).then(response => getProducts());
};

window.addEventListener("load", event => {
  getProducts();
});


function confirmDelete() {
  return confirm("Voulez vous vraiment supprimer ce produit ?");
}
