function reloadBookings() {
    fetch("../admin-api/approvedBooking.php")
        .then((res) => res.json())
        .then((approvedBookings) => {
            console.log("Approved Bookings:", approvedBookings);
            updateTable("#approved-booking tbody", approvedBookings);
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
                <select class="status-select" data-id="${room.bookingID}">
                    <option value="PENDING" ${room.status === "PENDING" ? "selected" : ""}>Pending</option>
                    <option value="APPROVED" ${room.status === "APPROVED" ? "selected" : ""}>Approved</option>
                    <option value="CANCELLED" ${room.status === "CANCELLED" ? "selected" : ""}>Cancelled</option>
                </select>
            </td>
        `;
        tableBody.appendChild(row);
    });

    document.querySelectorAll(".status-select").forEach((dropdown) => {
        let newDropdown = dropdown.cloneNode(true);
        dropdown.replaceWith(newDropdown);

        newDropdown.addEventListener("change", function () {
            let bookingID = this.getAttribute("data-id");
            let newStatus = this.value;
            updateBookingStatus(bookingID, newStatus);
        });
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


document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: "../admin-api/genCalendar.php",
    });
    calendar.render();
  });

reloadBookings();
