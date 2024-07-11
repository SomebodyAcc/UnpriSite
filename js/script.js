let gridItems = 3;

function createGridItems(count) {
  let grid = document.getElementById("grid");
  grid.innerHTML = "";
  for (let i = 0; i < count; i++) {
    let gridItem = document.createElement("div");
    gridItem.className = "grid-item";
    gridItem.textContent = `Item ${i + 1}`;
    grid.appendChild(gridItem);
  }
}

function expandGrid() {
  gridItems++;
  let grid = document.getElementById("grid");
  grid.classList.add("expanded");
  createGridItems(gridItems);
}

document.addEventListener("DOMContentLoaded", function () {
  createGridItems(gridItems);
});
