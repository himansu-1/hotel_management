<?php require_once('../../config/config.php'); ?>
<?php require_once('../../config/ifNotLogin.php'); ?>
<?php require_once('../middleware/checkAccess.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Booking History</title>
  <?php require_once('../components/header_script.php'); ?>
</head>

<body>
  <?php require_once('../components/header.php'); ?>
  <!-- Main content Start -->


  <div class="row">
    <div class="w-100">
      <div class="card">
        <div class="card-body">
          <div class="card-title">
            <h4 class="position-relative py-1">
              Booking History
              <span class="position-absolute top-0 end-0">
                <a class="badge rounded-pill bg-primary text-decoration-none shadow p-2 px-3" type="button" data-bs-toggle="modal" data-bs-target="#bookingModal">
                  CREATE BOOKING
                </a>
              </span>
            </h4>
            <hr>
          </div>
          <!-- Card body -->
          <div class="card-body">
            <div class="table-responsive">
              <table class="table w-100" id="roomsTable">
                <thead>
                  <tr>
                    <th>Sl.</th>
                    <th>Name</th>
                    <th>Room No.</th>
                    <th>Status</th>
                    <th>Checkin</th>
                    <th>Checkout</th>
                    <th>Type</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="bookingsList">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- View Booking Modal -->
  <div class="modal fade" id="viewBookingModal" tabindex="-1" aria-labelledby="viewBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewBookingModalLabel">Booking Details <span id="viewId" class="d-none"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td><strong>Room Number: </strong><span id="viewRoomNumber"></span></td>
                <td><strong>Serial Number: </strong><span id="viewSerialNumber"></span></td>
              </tr>
              <tr>
                <td width="50%"><strong>Booking ID: </strong><span id="viewBookingId"></span></td>
                <td><strong>Booking Type: </strong><span id="viewBookingType"></span></td>
              </tr>
              <tr>
                <td width="50%"><strong>Name: </strong><span id="viewBookingName"></span></td>
                <td><strong>Email: </strong><span id="viewEmail"></span></td>
              </tr>
              <tr>
                <td><strong>Mobile: </strong><span id="viewMobile"></span></td>
                <td><strong>Aadhar No.: </strong><span id="viewAadhar"></span></td>
              </tr>
              <tr>
                <td><strong>Address: </strong><span id="viewAddress"></span></td>
                <td><strong>Other: </strong><span id="viewOther"></span></td>
              </tr>
              <tr>
                <td><strong>Check-in: </strong><span id="viewCheckin"></span></td>
                <td><strong>Check-out: </strong><span id="viewCheckout"></span></td>
              </tr>
              <tr>
                <td><strong>Status: </strong><span id="viewStatus"></span></td>
                <td><strong>Stying: </strong><span id="viewStaying"></span></td>
              </tr>
              <tr><td><strong>Payment Mode: </strong></td><td class="text-end"><span id="viewPayMode"></span></td></tr>
              <tr><td><strong>Sub Total: </strong></td><td class="text-end"><span id="viewSubTotal"></span></td></tr>
              <tr><td><strong>CGST: </strong></td><td class="text-end"><span id="viewCGST"></span></td></tr>
              <tr><td><strong>SGST: </strong></td><td class="text-end"><span id="viewSGST"></span></td></tr>
              <tr><td><strong>Discount: </strong></td><td class="text-end"><span id="viewDiscount"></span></td></tr>
              <tr><td><strong>Total Amount: </strong></td><td class="text-end"><span id="viewTotalAmount"></span></td></tr>
              <tr><td><strong>Paid Amount: </strong></td><td class="text-end"><span id="viewPaidAmount"></span></td></tr>
              <tr><td><strong>Due Amount: </strong></td><td class="text-end"><span id="viewDueAmount"></span></td></tr>
            </tbody>
          </table>

          <!-- Payment Details Section -->
          <h5 class="mt-4">Payment Details</h5>
          <div id="paymentDetails"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" onclick="editBooking()">Edit</button>
          <button class="btn btn-success" onclick="addPayment()">Add Payment</button>
          <button class="btn btn-warning" onclick="checkoutBooking()">Checkout</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a id="printButton" class="btn btn-info" target="_blank">Print</a>
        </div>
      </div>
    </div>
  </div>



  <!-- Create Rooms Modal -->
  <!-- <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="bookingModalLabel">Create Room</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form class="forms-sample" id="createRoomForm">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="category">Select Category</label>
                  <select class="form-select" id="category" name="category">
                    <option>Select Category</option>
                    <option value="ac">AC</option>
                    <option value="non_ac">Non AC</option>
                  </select>
                </div>
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="room_number">Room Number</label>
                  <input type="text" class="form-control" id="room_number" name="room_number" placeholder="Room Number">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="floor">Floor</label>
                  <select name="floor" id="floor" class="form-select">
                    <option disabled>Select Floor Number</option>
                    <option value="1">First</option>
                    <option value="2">Second</option>
                    <option value="3">Third</option>
                  </select>
                </div>
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="price">Price</label>
                  <input type="number" class="form-control" id="price" name="price" step="0.01" placeholder="Enter Price">
                </div>
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="reserve">Reserve</label>
                <select name="reserve" id="reserve" class="form-select">
                  <option value="unreserved" selected>Unreserved</option>
                  <option value="Goibibo">Goibibo</option>
                  <option value="OYO">OYO</option>
                  <option value="MakeMyTrip">MakeMyTrip</option>
                  <option value="Yatra">Yatra</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <button type="reset" class="btn btn-light">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> -->

  <!-- Edit Room Modal -->
  <!-- <div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBookingModalLabel">Edit Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editBookingForm">
          <input type="hidden" id="roomId">
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="roomCategory">Select Category</label>
                  <select class="form-select" id="roomCategory" name="roomCategory">
                    <option>Select Category</option>
                    <option value="ac">AC</option>
                    <option value="non_ac">Non AC</option>
                  </select>
                </div>
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="roomNumber">Room Number</label>
                  <input type="text" class="form-control" id="roomNumber" name="roomNumber" placeholder="Room Number">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="roomFloor">Floor</label>
                  <select name="roomFloor" id="roomFloor" class="form-select">
                    <option disabled>Select Floor Number</option>
                    <option value="1">First</option>
                    <option value="2">Second</option>
                    <option value="3">Third</option>
                  </select>
                </div>
                <div class="form-group mb-1">
                  <label class="mb-0 mt-1" for="roomPrice">Price</label>
                  <input type="number" class="form-control" id="roomPrice" name="roomPrice" step="0.01" placeholder="Enter Price">
                </div>
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="roomDescription">Description</label>
                <input type="text" class="form-control" id="roomDescription" name="roomDescription">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="roomReserve">Reserve</label>
                <select name="roomReserve" id="roomReserve" class="form-select">
                  <option value="">Change Reservation</option>
                  <option value="unreserved">Unreserved</option>
                  <option value="Goibibo">Goibibo</option>
                  <option value="OYO">OYO</option>
                  <option value="MakeMyTrip">MakeMyTrip</option>
                  <option value="Yatra">Yatra</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-primary mr-2" onclick="updateRoom()">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div> -->



  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
  <script>
    $(document).ready(function() {
      // fetch the rooms list
      fetchBookings();
    });

    $("#editBookingModal").on("shown.bs.modal", function() {
      $(this).trigger("focus");
    });

    // Fetch bookings
    function fetchBookings() {
      $.ajax({
        url: "../../api/bookings/read.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
          if (data.success) {
            let html = "";
            data.bookings.forEach((booking) => {
              html += `
                <tr>
                  <td data-order="${booking.checkin_date}">${booking.sl_no}</td>
                  <td>${booking.name}</td>
                  <td>${booking.room_number}</td>
                  <td>${booking.status}</td>
                  <td>${booking.checkin_date}</td>
                  <td>${booking.checkout_date}</td>  
                  <td style="text-transform: capitalize;">${booking.booking_type}</td>  
                  <td class="d-flex gap-1">
                    <button 
                    type="button" class="btn btn-primary btn-sm text-light px-2 py-1 rounded-circle" 
                    onclick="viewBooking('${booking.id}')">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                  </td>
                </tr>`;
            });

            // Destroy old DataTable instance before updating
            if ($.fn.DataTable.isDataTable("#roomsTable")) {
              $("#roomsTable").DataTable().destroy();
            }

            $("#bookingsList").html(html); // Update table body

            // Reinitialize DataTable
            $("#roomsTable").DataTable({
              order: [
                [0, "desc"]
              ],
              columnDefs: [{
                  targets: [0],
                }, // Hide the first column
              ],
            });
          } else {
            $("#bookingsList").html('<tr><td class="text-center" colspan="5">No Rooms found.</td></tr>');
          }
        },
        error: function(err) {
          console.error("Error fetching rooms:", err);
        },
      });
    }

    function viewBooking(booking_id) {
      $.ajax({
        url: "../../api/bookings/fetch_single_booking.php",
        type: "GET",
        data: {
          booking_id: booking_id
        },
        dataType: "json",
        success: function(response) {
          if (response.success) {
            let booking = response.booking;
            let payments = response.payments;

            // Populate booking details
            $("#viewId").text(booking.id);

            $("#viewRoomNumber").text(booking.room_number);
            $("#viewSerialNumber").text(booking.sl_no);
            $("#viewBookingId").text(booking.booking_id);
            $("#viewBookingType").text(booking.booking_type);
            $("#viewBookingName").text(booking.name);
            $("#viewEmail").text(booking.mail);
            $("#viewMobile").text(booking.mobile);
            $("#viewAadhar").text(booking.aadhar_no);
            $("#viewAddress").text(booking.address);
            $("#viewAddress").text(booking.address);
            $("#viewOther").text(booking.other);
            $("#viewCheckin").text(booking.checkin_date);
            $("#viewCheckout").text(booking.checkout_date);
            $("#viewStatus").text(booking.status);
            $("#viewStaying").text(booking.staying);

            $("#viewPayMode").text(booking.pay_mode);
            $("#viewSubTotal").text(booking.sub_total);
            $("#viewCGST").text(booking.cgst);
            $("#viewSGST").text(booking.sgst);
            $("#viewDiscount").text(booking.discount);
            $("#viewTotalAmount").text(booking.total_amount);
            $("#viewPaidAmount").text(booking.paid_amount);
            $("#viewDueAmount").text(booking.due_amount);

            // Populate payment details in a table
            let paymentTable = `
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Type</th>
                <th>Payment Mode</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
        `;

            if (payments.length > 0) {
              payments.forEach(payment => {
                paymentTable += `
              <tr>
                <td>${payment.id || "N/A"}</td>
                <td>${payment.date || "N/A"}</td>
                <td>${payment.type || "N/A"}</td>
                <td>${payment.pay_mode || "N/A"}</td>
                <td>${payment.amount || "N/A"}</td>
              </tr>
            `;
              });
            } else {
              paymentTable += `<tr><td colspan="5">No payment records found.</td></tr>`;
            }

            paymentTable += `</tbody></table>`;
            $("#paymentDetails").html(paymentTable);

            // Update Print Button Link
            $("#printButton").attr("href", `print_booking.php?booking_id=${booking.id}`);

            // Show the modal
            $("#viewBookingModal").modal("show");
          } else {
            alert("Failed to fetch booking details.");
          }
        },
        error: function(err) {
          console.error("Error fetching booking:", err);
          alert("An error occurred while fetching the booking details.");
        }
      });
    }

    // Function to Open Edit Modal
    function editBooking() {
      let booking_id = $("#viewBookingId").text();
      // Open edit modal and fetch details
      $("#editBookingModal").modal("show");
    }

    // Function to Open Add Payment Modal
    function addPayment() {
      let booking_id = $("#viewBookingId").text();
      $("#paymentBookingId").val(booking_id);
      $("#addPaymentModal").modal("show");
    }

    // Function to Checkout Booking
    function checkoutBooking() {
      let booking_id = $("#viewId").text();

      $.ajax({
        url: "../../api/bookings/checkout_booking.php",
        type: "POST",
        data: {
          booking_id: booking_id
        },
        dataType: "json",
        success: function(response) {
          if (response.success) {
            alert("Booking checked out successfully!");
            $("#viewBookingModal").modal("hide");
            fetchBookings();
          } else {
            alert("Failed to checkout booking.");
          }
        },
        error: function(err) {
          console.error("Error checking out:", err);
          alert("An error occurred while processing checkout.");
        }
      });
    }
    // // Handle Create Room Form Submission
    // $("#createRoomForm").submit(function(event) {
    //   event.preventDefault();
    //   let formData = new FormData(this);

    //   $.ajax({
    //     url: "../../api/rooms/create.php",
    //     type: "POST",
    //     data: formData,
    //     contentType: false,
    //     processData: false,
    //     success: function(result) {
    //       console.log(result);

    //       let notifyType = result.success ? "success" : "danger"; // Success or Error type
    //       let notifyIcon = result.success ? "fa fa-check-circle" : "fa fa-exclamation-circle";
    //       let notifyMessage = result.success ? "Room Created Successfully!" : (result.message || "Some error occurred!");

    //       // Show notification
    //       $.notify({
    //         title: "<strong>Notification</strong><br>",
    //         message: notifyMessage,
    //         icon: notifyIcon
    //       }, {
    //         type: notifyType,
    //         allow_dismiss: true,
    //         delay: 3000,
    //         animate: {
    //           enter: 'animated fadeInDown',
    //           exit: 'animated fadeOutUp'
    //         },
    //         placement: {
    //           from: "top",
    //           align: "right"
    //         },
    //         offset: {
    //           x: 20,
    //           y: 70
    //         },
    //         z_index: 1051
    //       });

    //       if (result.success) {
    //         fetchBookings();
    //         $("#createRoomForm")[0].reset(); // Reset the form
    //         $("#bookingModal").modal("hide"); // Close the modal
    //       } else {
    //         setTimeout(fetchBookings, 500); // ✅ Delay to ensure fresh data is fetched
    //       }
    //     },
    //     error: function() {
    //       $.notify({
    //         title: "<strong>Notification</strong><br>",
    //         message: "Some error occurred!",
    //         icon: "fa fa-exclamation-circle"
    //       }, {
    //         type: "danger",
    //         allow_dismiss: true,
    //         delay: 3000,
    //         animate: {
    //           enter: 'animated fadeInDown',
    //           exit: 'animated fadeOutUp'
    //         },
    //         placement: {
    //           from: "top",
    //           align: "right"
    //         },
    //         offset: {
    //           x: 20,
    //           y: 70
    //         },
    //         z_index: 1051
    //       });

    //       fetchBookings();
    //       $("#createRoomForm")[0].reset(); // Reset the form
    //       $("#bookingModal").modal("hide"); // Close the modal
    //     }
    //   });
    // });
  </script>
</body>

</html>