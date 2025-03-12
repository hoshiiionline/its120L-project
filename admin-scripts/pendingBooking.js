function reloadBookings() {
    fetch("../admin-api/pendingBooking.php")
        .then((res) => res.json())
        .then((pendingBookings) => {
            console.log("Pending Bookings:", pendingBookings);
            updateTable("#pending-booking tbody", pendingBookings);
        })
        .catch((error) => console.error("Error fetching bookings:", error));
}

function updateTable(tableSelector, bookings) {
    const tableBody = document.querySelector(tableSelector);
    if (!tableBody) {
        console.error(`Table with selector '${tableSelector}' not found.`);
        return;
    }

    tableBody.innerHTML = "";

    bookings.forEach((room) => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${room.roomType}</td>
            <td>${room.occupancyType}</td>
            <td>${room.dateReservedStart} - ${room.dateReservedEnd}</td>
            <td title="Email: ${room.emailAddress} | Contact: ${room.mobileNo}">
                ${room.firstName} ${room.lastName}
            </td>
            <td>${room.pricingRateRoom}</td>
            <td>
                <button class="view-booking" data-id="${room.bookingID}">View</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    document.querySelectorAll(".view-booking").forEach((button) => {
        button.addEventListener("click", function () {
            let bookingID = this.getAttribute("data-id");
            fetchBookingDetails(bookingID);
        });
    });
}

function fetchBookingDetails(bookingID) {
    fetch(`../admin-api/pendingBooking.php?bookingID=${bookingID}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("Booking Details:", data);
            displayBookingDetails(data[0]);
        })
        .catch((error) => console.error("Error fetching booking details:", error));
}

function displayBookingDetails(data) {
    const detailsContainer = document.querySelector("#room-info tbody");
    const customerContainer = document.querySelector("#customer-info tbody");

    if (!detailsContainer || !customerContainer) return;

    detailsContainer.innerHTML = `
        <tr>
            <th>Desc.</th>
            <th>Info.</th>
        </tr>
        <tr>
            <td>Room Type</td>
            <td>${data.roomType}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>${data.dateReservedStart} - ${data.dateReservedEnd}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <select id="status-select" data-id="${data.bookingID}">
                    <option value="PENDING" ${data.status === "PENDING" ? "selected" : ""}>Pending</option>
                    <option value="FOR APPROVAL" ${data.status === "FOR APPROVAL" ? "selected" : ""}>For Approval</option>
                    <option value="APPROVED" ${data.status === "APPROVED" ? "selected" : ""}>Approved</option>
                    <option value="CANCELLED" ${data.status === "CANCELLED" ? "selected" : ""}>Cancelled</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Price</td>
            <td>${data.pricingRateRoom}</td>
        </tr>
    `;

    customerContainer.innerHTML = `
        <tr>
            <th>Desc.</th>
            <th>Info.</th>
        </tr>
        <tr>
            <td>Name</td>
            <td>${data.firstName} ${data.lastName}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>${data.emailAddress}</td>
        </tr>
        <tr>
            <td>Mobile No.</td>
            <td>${data.mobileNo}</td>
        </tr>
    `;

    // Add event listener to handle status change
    document.querySelector("#status-select").addEventListener("change", function () {
        let bookingID = this.getAttribute("data-id");
        let newStatus = this.value;
        updateBookingStatus(bookingID, newStatus);
    });
}

function updateBookingStatus(bookingID, newStatus) {
    fetch("../admin-api/updateBooking.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ bookingID: bookingID, status: newStatus }),
    })
    .then((response) => response.json())
    .then((data) => {
        console.log("Update Response:", data);
        if (data.success) {
            alert("Booking status updated successfully!");
            reloadBookings();
        } else {
            alert("Failed to update status: " + data.error);
        }
    })
    .catch((error) => console.error("Error updating booking status:", error));
}


reloadBookings();
