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
    fetch(`../admin-api/getBooking.php?bookingID=${bookingID}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("Booking Details:", data);
            displayBookingDetails(data);
        })
        .catch((error) => console.error("Error fetching booking details:", error));
}

function reloadBookings() {
    fetch("../admin-api/pendingBooking.php")
        .then((res) => res.json())
        .then((pendingBookings) => {
            console.log("Pending Bookings:", pendingBookings);
            updateTable("#pending-booking tbody", pendingBookings);
        })
        .catch((error) => console.error("Error fetching bookings:", error));
}

function displayBookingDetails(data) {
    const detailsContainer = document.querySelector("#room-info tbody");
    const customerContainer = document.querySelector("#customer-info tbody");

    const weekdayRate    = data.pricingRateRoom * 1;
    const weekendRate    = data.pricingRateRoom * 1.015;
    const weekdaySubtotal = weekdayRate * data.weekdayCount;
    const weekendSubtotal = weekendRate * data.weekendCount;
    const holidaySubtotal = data.pricingRateRoom * 1.02 * 0;
    const total = weekdaySubtotal + weekendSubtotal + holidaySubtotal;

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
                    <option value="PENDING" ${data.status === "PENDING" ? "selected" : ""}>PENDING</option>
                    <option value="FOR APPROVAL" ${data.status === "FOR APPROVAL" ? "selected" : ""}>FOR APPROVAL</option>
                    <option value="APPROVED" ${data.status === "APPROVED" ? "selected" : ""}>APPROVED</option>
                    <option value="CANCELLED" ${data.status === "CANCEL" ? "selected" : ""}>CANCELLED</option>
                    <option value="DECLINED" ${data.status === "DECLINED" ? "selected" : ""}>DECLINED</option>
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
    
    document.getElementById("room-type").innerText = data.roomType;
    document.getElementById("weekday-count").innerText = data.weekdayCount;
    document.getElementById("weekday-rate").innerText = "₱" + weekdayRate.toFixed(2);
    document.getElementById("weekday-subtotal").innerText = "₱" + weekdaySubtotal.toFixed(2);
    
    document.getElementById("weekend-count").innerText = data.weekendCount;
    document.getElementById("weekend-rate").innerText = "₱" + weekendRate.toFixed(2);
    document.getElementById("weekend-subtotal").innerText = "₱" + weekendSubtotal.toFixed(2);
    
    document.getElementById("holiday-count").innerText = 0;
    document.getElementById("holiday-rate").innerText = "₱" + (data.pricingRateRoom * 1.02).toFixed(2);
    document.getElementById("holiday-subtotal").innerText = "₱" + holidaySubtotal.toFixed(2);
    
    document.getElementById("total-price").innerText = "₱" + total.toFixed(2);

    document.querySelector("#status-select").addEventListener("change", function () {
        let bookingID = this.getAttribute("data-id");
        let newStatus = this.value;
        updateBookingStatus(bookingID, newStatus);
    });
}

function resetInfo(){
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
            <td>Please Select a Record</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>Please Select a Record</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>Please Select a Record</td>
        </tr>
        <tr>
            <td>Price</td>
            <td>Please Select a Record</td>
        </tr>
    `;

    customerContainer.innerHTML = `
        <tr>
            <th>Desc.</th>
            <th>Info.</th>
        </tr>
        <tr>
            <td>Name</td>
            <td>Please Select a Record</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>Please Select a Record</td>
        </tr>
        <tr>
            <td>Mobile No.</td>
            <td>Please Select a Record</td>
        </tr>
    `;
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
            resetInfo();
        } else {
            alert("Failed to update status: " + data.error);
        }
    })
    .catch((error) => console.error("Error updating booking status:", error));
}


reloadBookings();
