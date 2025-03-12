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

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth'
    });
    calendar.render();
  });

reloadBookings();
