function loadCart() {
  fetch("../api/getCart.php")
    .then((response) => response.json())
    .then((cart) => {
      const cartTable = document.querySelector("#in-cart tbody");
      if (!cartTable) {
        console.error("Cart table not found.");
        return;
      }
      cartTable.innerHTML = "";

      cart.forEach((room) => {
        let row = document.createElement("tr");
        row.innerHTML = `
                    <td>${room.roomType}</td>
                    <td>${room.roomPackage}</td>
                    <td>${room.occupancyType}</td>
                    <td>${room.occupancyMax}</td>
                    <td>${room.pricingRatePackage}</td>
                    <td>
                        <img class="remove-from-cart"
                    data-room="${room.roomType}"
                    src="../assets/minus.png"
                    alt="Remove from Cart" width=30 height=30>
                    </td>
                `;
        cartTable.appendChild(row);
      });

      document.querySelectorAll(".remove-from-cart").forEach((button) => {
        button.addEventListener("click", function () {
          removeFromCart(this.getAttribute("data-room"));
        });
      });
    })
    .catch((error) => console.error("Error loading cart:", error));
}

function removeFromCart(roomType) {
  fetch("../api/removeItem.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ roomType }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        loadCart(); // Refresh cart
        reloadRooms(); // Refresh available rooms
      } else {
        alert(data.message);
      }
    })
    .catch((error) => console.error("Error:", error));
}

function reloadRooms() {
  Promise.all([
    fetch(
      `../api/roomAvailability.php?start-date=2025-03-06&end-date=2025-03-08`
    ).then((response) => response.json()),
    fetch("../api/getCart.php").then((response) => response.json()),
  ])
    .then(([availableRooms, cart]) => {
      console.log("Rooms data received:", availableRooms);
      console.log("Cart data received:", cart);

      // Remove booked rooms from availableRooms
      availableRooms = availableRooms.filter(
        (room) => !cart.some((cartItem) => cartItem.roomType === room.roomType)
      );

      const roomsTable = document.querySelector("#available-rooms tbody");
      if (!roomsTable) {
        console.error("Table with id 'available-rooms' not found.");
        return;
      }

      roomsTable.innerHTML = ""; // Clear the table

      availableRooms.forEach((room) => {
        let row = document.createElement("tr");
        row.innerHTML = `
                <td>${room.roomType}</td>
                <td>${room.roomPackage}</td>
                <td>${room.occupancyType}</td>
                <td>${room.occupancyMax}</td>
                <td>${room.pricingRatePackage}</td>
                <td>
                <img class="add-to-cart" 
                    data-room='${JSON.stringify(room)}' 
                    src="../assets/plus.png" 
                    alt="Add to Cart" width=30 height=30>
                </td>
            `;
        roomsTable.appendChild(row);
      });

      // Reattach event listeners for dynamically added buttons
      document.querySelectorAll(".add-to-cart").forEach((button) => {
        button.addEventListener("click", function () {
          let roomData = JSON.parse(this.getAttribute("data-room"));
          addToCart(roomData);
        });
      });
    })
    .catch((error) => console.error("Error fetching rooms or cart:", error));
}

function addToCart(roomData) {
  fetch("../api/toCart.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(roomData),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        reloadRooms(); // Refresh available rooms
        loadCart(); // Refresh cart
      } else {
        alert(data.message);
      }
    })
    .catch((error) => console.error("Error adding to cart:", error));
}

loadCart();
reloadRooms();
