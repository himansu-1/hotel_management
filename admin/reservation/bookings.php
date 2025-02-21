<?php require_once('../../config/config.php'); ?>
<?php require_once('../../config/ifNotLogin.php'); ?>
<?php require_once('../middleware/checkAccess.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bookings</title>
  <?php require_once('../components/header_script.php'); ?>
  <style>
    strong {
      font-weight: 500;
    }

    .form-control {
      margin-top: 5px;
    }

    .booking-room-btn {
      display: inline-block;
      margin: 10px;
      padding: 20px;
      transition: 0.2sease-in-out;
      box-shadow: none;
    }
  </style>
</head>

<body>
  <?php require_once('../components/header.php'); ?>
  <!-- Main content Start -->

  <div class="row w-100">

    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Booking System</h4>
        <hr>
        <div id="room-container"></div>
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
          <table class="table table-borderless table-bordered">
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
              <tr>
                <td colspan="2"><strong>Documents: </strong><span id="viewDocuments1"></span><span id="viewDocuments2"></span><span id="viewDocuments3"></span></td>
              </tr>
              <tr>
                <td><strong>Payment Mode: </strong></td>
                <td class="text-end"><span id="viewPayMode"></span></td>
              </tr>
              <tr>
                <td><strong>Sub Total: </strong></td>
                <td class="text-end"><span id="viewSubTotal"></span></td>
              </tr>
              <tr>
                <td><strong>CGST: </strong></td>
                <td class="text-end"><span id="viewCGST"></span></td>
              </tr>
              <tr>
                <td><strong>SGST: </strong></td>
                <td class="text-end"><span id="viewSGST"></span></td>
              </tr>
              <tr>
                <td><strong>Discount: </strong></td>
                <td class="text-end"><span id="viewDiscount"></span></td>
              </tr>
              <tr>
                <td><strong>Total Amount: </strong></td>
                <td class="text-end"><span id="viewTotalAmount"></span></td>
              </tr>
              <tr>
                <td><strong>Paid Amount: </strong></td>
                <td class="text-end"><span id="viewPaidAmount"></span></td>
              </tr>
              <tr>
                <td><strong>Due Amount: </strong></td>
                <td class="text-end"><span id="viewDueAmount"></span></td>
              </tr>
            </tbody>
          </table>

          <!-- Payment Details Section -->
          <h5 class="mt-4">Payment Details</h5>
          <div id="paymentDetails"></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" onclick="editBooking()">Edit</button>
          <button class="btn btn-warning" onclick="checkoutBooking()">Checkout</button>
          <button class="btn btn-warning" onclick="checkoutExcludePaymentBooking()">Checkout Without Payment</button>
          <button class="btn btn-success" onclick="addPayment()">Add Payment</button>
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a id="printButton" class="btn btn-info" target="_blank">Print</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Booking Modal -->
  <div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Booking</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editBookingForm" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" id="edit_booking_id" name="edit_booking_id">
            <div class='modal-body'>
              <h5>Room Details</h5>
              <table class="table table-borderless">
                <tr>
                  <td><strong>Category: </strong><input id="edit_room_category" class="form-control" readonly></td>
                  <td><strong>Number: </strong><input id="edit_room_number" class="form-control" readonly></td>
                  <td><strong>Price: </strong><input id="edit_room_price" class="form-control" readonly></td>
                </tr>
              </table>
              <div class="table-responsive">
                <h5>Customer Details</h5>
                <table class="table table-borderless">
                  <tr>
                    <td>
                      <strong>Serial Number:</strong><br>
                      <input type="hidden" id="edit_room_number" name="edit_room_number" value="${room.room_number}">
                      <input type="text" class="form-control" id="edit_serial_number" name="edit_serial_number" placeholder="Serial Number">
                    </td>
                    <td>
                      <strong>Status:</strong><br>
                      <select class="form-select" id="edit_status" name="edit_status">
                        <option value="">Select Status</option>
                        <option value="checked_in">Checked In</option>
                        <option value="checked_out">Checked Out</option>
                      </select>
                    </td>
                    <td>
                      <strong>Checkin:</strong><br>
                      <input type="datetime-local" class="form-control" id="edit_checkin_date" name="edit_checkin_date" value="<?php echo date('Y-m-d\TH:i'); ?>">
                    </td>
                    <td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Full Name:</strong><br>
                      <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="Enter Full Name">
                    </td>
                    <td>
                      <strong>Mail Address:</strong><br>
                      <input type="email" class="form-control" id="edit_email" name="edit_email" placeholder="Enter Email">
                    </td>
                    <td>
                      <strong>Mobile Number:</strong><br>
                      <input type="text" class="form-control" id="edit_mobile" name="edit_mobile" placeholder="Enter Mobile Number">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Address:</strong><br>
                      <input type="text" class="form-control" id="edit_address" name="edit_address" placeholder="Address">
                    </td>
                    <td>
                      <strong>ID Number:</strong><br>
                      <input type="text" class="form-control" id="edit_id_no" name="edit_id_no" placeholder="ID Number">
                    </td>
                    <td>
                      <strong>Description:</strong><br>
                      <input type="text" class="form-control" id="edit_other" name="edit_other">
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Document-1:</strong><br>
                      <input type="file" class="form-control" id="edit_document_1" name="edit_document_1" placeholder="ID Number">
                    </td>
                    <td>
                      <strong>Document-2:</strong><br>
                      <input type="file" class="form-control" id="edit_document_2" name="edit_document_2" placeholder="ID Number">
                    </td>
                    <td>
                      <strong>Document-3:</strong><br>
                      <input type="file" class="form-control" id="edit_document_3" name="edit_document_3" placeholder="ID Number">
                    </td>
                  </tr>
                  <tr>
                    <td class="row">
                      <label>Payment Mode</label><br>
                      <div class="d-flex gap-3">
                        <div class="form-check">
                          <label for="pay_mode1" class="form-check-label ms-1">
                            <input type="radio" class="form-check-input" id="edit_pay_mode1" name="edit_pay_mode" value="upi">
                            UPI
                            <i class="input-helper"></i></label>
                        </div>
                        <div class="form-check">
                          <label for="pay_mode2" class="form-check-label ms-1">
                            <input type="radio" class="form-check-input" id="edit_pay_mode2" name="edit_pay_mode" value="cash">
                            Cash
                            <i class="input-helper"></i></label>
                        </div>
                        <div class="form-check">
                          <label for="pay_mode3" class="form-check-label ms-1">
                            <input type="radio" class="form-check-input" id="edit_pay_mode3" name="edit_pay_mode" value="upi_cash">
                            UPI / Cash
                            <i class="input-helper"></i></label>
                        </div>
                      </div>
                    </td>
                    <td>
                      <strong>Staying Days:</strong>
                    </td>
                    <td>
                      <input type="number" class="form-control" id="edit_staying" name="edit_staying">
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Sub Total:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_sub_total" name="edit_sub_total" value="${room.price}" data-room-price="${room.price}"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>CGST:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_cgst" name="edit_cgst" value="0"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>SGST:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_sgst" name="edit_sgst" value="0"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Discount:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_discount" name="edit_discount" value="0"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Additional Charges:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_additional_charges" name="edit_additional_charges" value="0"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Total Amount:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_total_amount" name="edit_total_amount"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Paid Amount:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_paid_amount" name="edit_paid_amount"></td>
                  </tr>
                  <tr>
                    <td colspan="2"><strong>Due Amount:</strong></td>
                    <td><input type="number" class="form-control" step="0.01" id="edit_due_amount" name="edit_due_amount"></td>
                  </tr>
                  <!-- <tr>
                    <td colspan="3" class="text-center"><input type="submit" class="btn btn-primary" value="Book"></td>
                  </tr> -->
                </table>
                <h5 class="mt-4">Payment Details</h5>
                <div id="edit_payment_detials"></div>
                <div class="text-center mt-3"><button type="submit" class="btn btn-primary">Submit</button></div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      fetchRooms();

      // Edit Booking details 
      $("#editBookingForm").submit(function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        formData.append("deleted_payment_ids", deletedPaymentIds.join(","));

        $.ajax({
          url: "../../api/bookings/update_booking.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(response) {
            if (response.success) {
              alert("Booking updated successfully!");
              location.reload();
            } else {
              alert("Error: " + response.message);
            }
          }
        });
      });

      // Create Booking Form Submit
      document.addEventListener("submit", function(e) {
        if (e.target.matches("[id^='bookingForm']")) {
          e.preventDefault();

          let formData = new FormData(e.target);

          fetch("../../api/bookings/create_book.php", {
              method: "POST",
              body: formData
            })
            .then(response => response.json())
            .then(data => {
              let notifyType = data.success ? "success" : "danger";
              let notifyIcon = data.success ? "fa fa-check-circle" : "fa fa-exclamation-circle";
              let notifyMessage = data.success ? "Room Booked successfully!" : data.message;

              $.notify({
                title: "<strong>Notification</strong><br>",
                message: notifyMessage,
                icon: notifyIcon
              }, {
                type: notifyType,
                allow_dismiss: true,
                delay: 3000,
                animate: {
                  enter: 'animated fadeInDown',
                  exit: 'animated fadeOutUp'
                },
                placement: {
                  from: "top",
                  align: "right"
                },
                offset: {
                  x: 20,
                  y: 70
                },
                z_index: 2000
              });

              if (data.success) {
                $(`#bookModal${data.room_number}`).modal("hide");
                e.target.reset(); // Reset the form
                setTimeout(fetchRooms, 300);
              }
            })
            .catch(error => console.error("Error:", error));
        }
      });
    });

    function fetchRooms() {
      fetch('../../api/bookings/fetch_bookings.php')
        .then(response => response.json())
        .then(data => {
          let container = document.getElementById('room-container');
          container.innerHTML = "";
          let currentFloor = -1;
          let room = data.rooms;

          room.forEach(room => {
            if (currentFloor !== room.floor) {
              currentFloor = room.floor;
              container.innerHTML += `<h5>Floor: ${room.floor}</h5>`;
            }

            let bgColor = room.status === 'checked_in' ? 'btn-danger' : 'btn-info';
            let modalTarget = room.status === 'checked_in' ? `onclick="viewBookingModal(${room.id})"` : `data-bs-target="#bookModal${room.room_number}"`;
            // let modalTarget = room.status === 'checked_in' ? `#roomModal${room.room_number}` : `#bookModal${room.room_number}`;

            container.innerHTML += `
                <div class="text-light fw-small p-2 btn ${bgColor}">
                    <a href="#" data-bs-toggle="modal" ${modalTarget} class="text-light text-decoration-none">Room ${room.room_number}</a>
                </div>
            `;

            if (room.status === 'checked_in') {

            } else {
              container.innerHTML += `
                <div class='modal fade' id='bookModal${room.room_number}' tabindex='-1'>
                    <div class='modal-dialog modal-xl'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5>Book Room ${room.room_number}</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                            </div>                                        
                    <form id="bookingForm${room.room_number}" enctype="multipart/form-data" autocomplete="off">
                      <div class='modal-body'>
                        <div class="table-responsive">
                          <table class="table table-borderless">
                            <tr>
                              <td>
                                <strong>Serial Number:</strong><br>
                                <input type="hidden" id="room_number" name="room_number" value="${room.room_number}">
                                <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Serial Number">
                              </td>
                              <td>
                                <strong>Status:</strong><br>
                                <select class="form-select" name="status" id="status">
                                  <option value="checked_in" selected>Checked In</option>
                                  <option value="checked_out">Checked Out</option>
                                </select>
                              </td>
                              <td>
                                <strong>Checkin:</strong><br>
                                <input type="datetime-local" class="form-control" id="checkin_date" name="checkin_date" value="<?php echo date('Y-m-d\TH:i'); ?>">
                              </td>
                              <td>
                            </tr>
                            <tr>
                              <td>
                                <strong>Full Name:</strong><br>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name">
                              </td>
                              <td>
                                <strong>Mail Address:</strong><br>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                              </td>
                              <td>
                                <strong>Mobile Number:</strong><br>
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <strong>Address:</strong><br>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                              </td>
                              <td>
                                <strong>ID Number:</strong><br>
                                <input type="text" class="form-control" id="id_no" name="id_no" placeholder="ID Number">
                              </td>
                              <td>
                                <strong>Description:</strong><br>
                                <input type="text" class="form-control" id="description" name="description">
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <strong>Document-1:</strong><br>
                                <input type="file" class="form-control" id="document_1" name="document_1" placeholder="ID Number">
                              </td>
                              <td>
                                <strong>Document-2:</strong><br>
                                <input type="file" class="form-control" id="document_2" name="document_2" placeholder="ID Number">
                              </td>
                              <td>
                                <strong>Document-3:</strong><br>
                                <input type="file" class="form-control" id="document_3" name="document_3" placeholder="ID Number">
                              </td>
                            </tr>
                            <tr>
                              <td class="row">
                                <label>Payment Mode</label><br>
                                <div class="d-flex gap-3">
                                  <div class="form-check">
                                    <label for="pay_mode1" class="form-check-label ms-1">
                                      <input type="radio" class="form-check-input" name="pay_mode" id="pay_mode1" value="upi">
                                      UPI
                                      <i class="input-helper"></i></label>
                                  </div>
                                  <div class="form-check">
                                    <label for="pay_mode2" class="form-check-label ms-1">
                                      <input type="radio" class="form-check-input" name="pay_mode" id="pay_mode2" value="cash">
                                      Cash
                                      <i class="input-helper"></i></label>
                                  </div>
                                  <div class="form-check">
                                    <label for="pay_mode3" class="form-check-label ms-1">
                                      <input type="radio" class="form-check-input" name="pay_mode" id="pay_mode3" value="upi_cash">
                                      UPI / Cash
                                      <i class="input-helper"></i></label>
                                  </div>
                                </div>
                              </td>
                              <td>
                                <strong>Staying Days:</strong>
                              </td>
                              <td>
                                <input type="number" class="form-control" id="staying" name="staying">
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Sub Total:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="sub_total" name="sub_total" value="${room.price}" data-room-price="${room.price}"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>CGST:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="cgst" name="cgst" value="0"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>SGST:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="sgst" name="sgst" value="0"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Discount:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="discount" name="discount" value="0"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Additional Charges:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="additional_charges" name="additional_charges" value="0"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Total Amount:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="total_amount" name="total_amount"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Paid Amount:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="paid_amount" name="paid_amount"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Due Amount:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="due_amount" name="due_amount"></td>
                            </tr>
                            <tr>
                              <td colspan="3" class="text-center"><input type="submit" class="btn btn-primary" value="Book"></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </form>                                            
                        </div>
                    </div>
                </div>
              `;
            }
          });
        });
    }

    $(document).on("input", "input[name='staying'], input[name='sub_total'], input[name='cgst'], input[name='sgst'], input[name='discount'], input[name='additional_charges'], input[name='total_amount'], input[name='paid_amount'], input[name='due_amount']", function() {
      let modal = $(this).closest(".modal"); // Get the closest modal
      calculateTotalAmount(modal);
    });

    function calculateTotalAmount(modal) {
      let staying = parseFloat(modal.find("#staying").val()) || 0;
      let sub_total = parseFloat(modal.find("#sub_total").attr("data-room-price")) || 0;
      let staying_amount = staying * sub_total;
      modal.find("#sub_total").val(staying_amount.toFixed(2));

      let cgst = parseFloat(modal.find("#cgst").val()) || 0;
      let sgst = parseFloat(modal.find("#sgst").val()) || 0;
      let discount = parseFloat(modal.find("#discount").val()) || 0;
      let additional_charges = parseFloat(modal.find("#additional_charges").val()) || 0;

      let total_amount = staying_amount + cgst + sgst - discount + additional_charges;
      modal.find("#total_amount").val(total_amount.toFixed(2));

      let paid_amount = parseFloat(modal.find("#paid_amount").val()) || 0;
      let due_amount = total_amount - paid_amount;
      modal.find("#due_amount").val(due_amount.toFixed(2));
    }

    function viewBookingModal(id) {
      console.log("version conflict");

      console.log($.fn.jquery);
      $.ajax({
        url: "../../api/bookings/fetch_single_booking.php",
        type: "GET",
        data: {
          booking_id: id
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

            console.log(booking.document_1);

            if (booking.document_1 && booking.document_1.trim() !== "") {
              $("#viewDocuments1").html(`<a href="../../uploads/booking_documents/${booking.document_1}" target="_blank">Document 1</a> &nbsp;`)
            }
            if (booking.document_2 && booking.document_2.trim() !== "") {
              $("#viewDocuments2").html(`<a href="../../uploads/booking_documents/${booking.document_2}" target="_blank">Document 2</a> &nbsp;`)
            }
            if (booking.document_3 && booking.document_3.trim() !== "") {
              $("#viewDocuments3").html(`<a href="../../uploads/booking_documents/${booking.document_3}" target="_blank">Document 3</a> &nbsp;`)
            }

            // Populate payment details in a table
            let paymentTable = `
              <table class="table table-borderless table-bordered">
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
            // $("#viewBookingModal").modal("show");
            var modal = new bootstrap.Modal(document.getElementById("viewBookingModal"));
            modal.show();

          } else {
            alert("Failed to fetch booking details.");
          }
        }
      })


    }

    // Function to Open Add Payment Modal
    function addPayment() {
      let paymentId = $(element).closest("tr").find("input[name='payment_id[]']").val();
      if (paymentId) {
        deletedPaymentIds.push(paymentId);
      }
      let booking_id = $("#viewBookingId").text();
      $("#paymentBookingId").val(booking_id);
      $("#addPaymentModal").modal("show");
    }

    // Function to Checkout Booking
    function checkoutExcludePaymentBooking() {
      let booking_id = $("#viewId").text();

      $.ajax({
        url: "../../api/bookings/checkout_booking.php",
        type: "POST",
        data: {
          booking_id: booking_id,
          checkout_without_payment: true
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

    // ================ EIDT SECTION =================
    let deletedPaymentIds = [];

    function editBooking() {
      let bookingId = $("#viewId").text();

      $.ajax({
        url: "../../api/bookings/fetch_single_booking.php",
        type: "GET",
        data: {
          booking_id: bookingId
        },
        dataType: "json",
        success: function(response) {
          if (response.success) {
            let booking = response.booking;
            let payments = response.payments;
            let rooms = response.rooms;
            console.log(payments);

            // Populate edit form
            $("#edit_booking_id").val(booking.id);
            $("#edit_room_number").val(booking.room_number);
            $("#edit_serial_number").val(booking.sl_no);
            $("#edit_status").val(booking.status);
            $("#edit_checkin_date").val(booking.checkin_date);
            $("#edit_name").val(booking.name);
            $("#edit_email").val(booking.mail);
            $("#edit_mobile").val(booking.mobile);
            $("#edit_address").val(booking.address);
            $("#edit_id_no").val(booking.aadhar_no);
            $("#edit_other").val(booking.other);

            $("#edit_room_category").val(rooms.category)
            $("#edit_room_number").val(rooms.room_number)
            $("#edit_room_price").val(rooms.price)

            $("#edit_staying").val(booking.staying);
            $("#edit_sub_total").val(booking.sub_total);
            $("#edit_cgst").val(booking.cgst);
            $("#edit_sgst").val(booking.sgst);
            $("#edit_discount").val(booking.discount);
            $("#edit_additional_charges").val(booking.additional_charges);
            $("#edit_total_amount").val(booking.total_amount);
            $("#edit_paid_amount").val(booking.paid_amount);
            $("#edit_due_amount").val(booking.due_amount);

            // Set Payment Mode Radio Buttons
            $("input[name='edit_pay_mode']").prop("checked", false); // Reset selection
            if (booking.pay_mode === "upi") {
              $("#edit_pay_mode1").prop("checked", true);
            } else if (booking.pay_mode === "cash") {
              $("#edit_pay_mode2").prop("checked", true);
            } else if (booking.pay_mode === "upi_cash") {
              $("#edit_pay_mode3").prop("checked", true);
            }

            // Populate payment details in a table
            let paymentTable = `
              <table class="table table-borderless" id="edit_booking_payments">
                <thead>
                  <tr>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Payment Mode</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
            `;

            if (payments.length > 0) {
              payments.forEach(payment => {
                paymentTable += `
                  <tr>
                    <td><input type="text" class="form-control" name="payment_id[]" value="${payment.id || ""}" readonly></td>
                    <td><input type="datetime-local" class="form-control" name="payment_date[]" value="${payment.date || ""}"></td>
                    <td><input type="text" class="form-control" name="payment_type[]" value="${payment.type || ""}" readonly></td>
                    <td>
                      <select class="form-control" name="payment_pay_mode[]">
                        <option value="upi" ${payment.pay_mode === "upi" ? "selected" : ""}>UPI</option>
                        <option value="cash" ${payment.pay_mode === "cash" ? "selected" : ""}>Cash</option>
                        <option value="upi_cash" ${payment.pay_mode === "upi_cash" ? "selected" : ""}>UPI / Cash</option>
                      </select>
                    </td>
                    <td><input type="number" step="0.01" class="form-control" name="payment_amount[]" value="${payment.amount || ""}"></td>
                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removePaymentRow(this)">Remove</button></td>
                  </tr>
                `;
              });
            } else {
              paymentTable += `<tr><td colspan="5">No payment records found.</td></tr>`;
            }

            paymentTable += `</tbody></table>
              <div class="text-center"><button type="button" class="btn btn-success" onclick="addPaymentRow()"><i class="fas fa-plus"></i></button></div>
            `;
            $("#edit_payment_detials").html(paymentTable);

            // Show the modal
            $("#viewBookingModal").modal("hide");
            $("#editBookingModal").modal("show");
          } else {
            alert("Failed to fetch booking details.");
          }
        },
        error: function() {
          alert("Error fetching booking details.");
        }
      });
    }

    // Function to Add a New Payment Row
    function addPaymentRow() {
      let newRow = `
        <tr>
          <td><input type="text" class="form-control" name="payment_id[]" value="" readonly></td>
          <td><input type="date" class="form-control" name="payment_date[]"></td>
          <td><input type="text" class="form-control" name="payment_type[]"></td>
          <td>
            <select class="form-control" name="payment_type[]" disabled>
              <option value="">Choose Payment Type</option>
              <option value="deposit" selected>Deposit</option>
            </select>
          </td>
          <td>
            <select class="form-select" name="payment_pay_mode[]">
              <option value="">Choose Payment Mode</option>
              <option value="upi">UPI</option>
              <option value="cash">Cash</option>
              <option value="upi_cash">UPI / Cash</option>
            </select>
          </td>
          <td><input type="number" class="form-control" name="payment_amount[]"></td>
          <td><button type="button" class="btn btn-danger btn-sm" onclick="removePaymentRow(this)">Remove</button></td>
        </tr>
      `;

      $("#edit_booking_payments tbody").append(newRow);
    }

    // Function to Remove a Payment Row
    function removePaymentRow(element) {
      let paymentId = $(element).closest("tr").find("input[name='payment_id[]']").val();
      if (paymentId) {
        deletedPaymentIds.push(paymentId);
      }
      $(element).closest("tr").remove();
      calculateDueAmount();
    }

    function calculateSubTotal() {
      let roomPrice = parseFloat($("#edit_room_price").val()) || 0;
      let stayingDays = parseFloat($("#edit_staying").val()) || 0;
      let subTotal = roomPrice * stayingDays;
      $("#edit_sub_total").val(subTotal.toFixed(2));
      calculateTotalAmount();
    }

    function calculateTotalAmount() {
      let subTotal = parseFloat($("#edit_sub_total").val()) || 0;
      let cgst = parseFloat($("#edit_cgst").val()) || 0;
      let sgst = parseFloat($("#edit_sgst").val()) || 0;
      let discount = parseFloat($("#edit_discount").val()) || 0;
      let additionalCharges = parseFloat($("#edit_additional_charges").val()) || 0;

      let taxAmount = (subTotal * (cgst + sgst)) / 100; // Tax applied to subtotal
      let totalAmount = subTotal + taxAmount + additionalCharges - discount;

      $("#edit_total_amount").val(totalAmount.toFixed(2));
      calculateDueAmount();
    }

    function calculateTotalPaid() {
      let totalPaid = 0;
      $("input[name='payment_amount[]']").each(function() {
        totalPaid += parseFloat($(this).val()) || 0;
      });
      $("#edit_paid_amount").val(totalPaid.toFixed(2));
      calculateDueAmount();
    }

    function calculateDueAmount() {
      let totalAmount = parseFloat($("#edit_total_amount").val()) || 0;
      let totalPaid = parseFloat($("#edit_paid_amount").val()) || 0;
      let dueAmount = totalAmount - totalPaid;
      $("#edit_due_amount").val(dueAmount.toFixed(2));
    }

    // Event Listeners
    $("#edit_staying").on("input", calculateSubTotal);
    $("#edit_cgst, #edit_sgst, #edit_discount, #edit_additional_charges").on("input", calculateTotalAmount);
    $(document).on("input", "input[name='payment_amount[]']", calculateTotalPaid);

    // // Initial Calculation when modal opens
    // $("#editBookingModal").on("shown.bs.modal", function() {
    //   calculateSubTotal();
    //   calculateTotalAmount();
    //   calculateTotalPaid();
    // });
  </script>
</body>

</html>