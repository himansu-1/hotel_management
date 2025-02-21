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
  </style>
</head>

<body>
  <?php require_once('../components/header.php'); ?>
  <!-- Main content Start -->

  <div class="row w-100">
    <!-- <div class="card">
      <div class="card-body">
        <h4 class="card-title">Booking System</h4>
        <hr>
        <?php

        $sql = "
        SELECT 
            r.room_number, 
            r.category, 
            r.floor, 
            book.id,
            book.status,
            book.name
        FROM 
            rooms r
        LEFT JOIN 
            bookings book ON r.room_number = book.room_number AND book.status = 'checked_in'
        ORDER BY 
            r.floor ASC, r.room_number ASC;
        ";

        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $rooms = $stmt->fetchAll();

        // Display rooms floor-wise with red background for occupied rooms
        $current_building = -1;
        $current_floor = -1;

        if (count($rooms) > 0) {
          foreach ($rooms as $row) {

            if ($current_floor != $row['floor']) {
              $current_floor = $row['floor'];
              echo "<h5 class=''>Floor: " . $current_floor . "</h5>";
            }

            // Set background color based on room status
            $background_color = ($row['status'] == 'checked_in') ? '#ff4d4d' : '#30d930';

            // Display room number with modal trigger
            echo "<div style='display: inline-block; margin: 10px; padding: 20px; background-color: $background_color; transition: all 0.2s ease-in-out;' class='text-light fw-small p-2 card' onmouseover='this.style.boxShadow=\"rgb(0 0 0) 1px 2px 10px -2px inset, rgb(121 121 121) 2px -2px 7px -3px inset\"' onmouseout='this.style.boxShadow=\"none\"'>";
            if ($row['status'] == 'checked_in') {
              // Modal trigger for occupied rooms
              echo "<a href='#' data-bs-toggle='modal' data-bs-target='#roomModal" . $row['room_number'] . "' class='text-light text-decoration-none'>Room " . $row['room_number'] . "</a>";
            } else {
              // Modal trigger for vacant rooms
              echo "<a href='#' data-bs-toggle='modal' data-bs-target='#bookModal" . $row['room_number'] . "' class='text-light text-decoration-none'>Room " . $row['room_number'] . "</a>";
            }
            echo "</div>";

            // Modal for occupied rooms
            if ($row['status'] == 'checked_in') {
        ?>
              <div class='modal fade' id='roomModal<?= $row['room_number'] ?>' tabindex='-1' aria-labelledby='roomModalLabel<?= $row['room_number'] ?>' aria-hidden='true'>
                <div class='modal-dialog modal-xl'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title w-100' id='roomModalLabel<?= $row['room_number'] ?>'>
                        Customer Details for Room <?= $row['room_number'] ?>

                      </h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <tr>
                            <th>Name</th>
                            <td><?= $row['name'] ?></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php
            } else {
              // Modal for vacant rooms (Booking)
            ?>
              <div class='modal fade' id='bookModal<?= $row['room_number'] ?>' tabindex='-1' aria-labelledby='bookModalLabel<?= $row['room_number'] ?>' aria-hidden='true'>
                <div class='modal-dialog modal-xl'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='bookModalLabel<?= $row['room_number'] ?>'>BOOK ROOM <?= $row['room_number'] ?></h5>
                      <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <form id="bookingForm" enctype="multipart/form-data" autocomplete="off">
                      <div class='modal-body'>
                        <div class="table-responsive">
                          <table class="table">
                            <tr>
                              <td>
                                <strong>Serial Number:</strong><br><input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Serial Number">
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
                                <input type="datetime-local" class="form-control" id="checkin_date" name="checkin_date">
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
                                    <label for="membershipRadios1" class="form-check-label ms-1">
                                      <input type="radio" class="form-check-input" name="pay_mode" id="membershipRadios1" value="upi">
                                      UPI
                                      <i class="input-helper"></i></label>
                                  </div>
                                  <div class="form-check">
                                    <label for="membershipRadios2" class="form-check-label ms-1">
                                      <input type="radio" class="form-check-input" name="pay_mode" id="membershipRadios2" value="cash">
                                      Cash
                                      <i class="input-helper"></i></label>
                                  </div>
                                  <div class="form-check">
                                    <label for="membershipRadios3" class="form-check-label ms-1">
                                      <input type="radio" class="form-check-input" name="pay_mode" id="membershipRadios3" value="upi_cash">
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
                              <td><input type="number" class="form-control" step="0.01" id="sub_total" name="sub_total"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>CGST:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="cgst" name="cgst"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>SGST:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="sgst" name="sgst"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Discount:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="discount" name="discount"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Additional Charges:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="additional_charges" name="additional_charges"></td>
                            </tr>
                            <tr>
                              <td colspan="2"><strong>Total Amount:</strong></td>
                              <td><input type="number" class="form-control" step="0.01" id="total_amount" name="total_amount"></td>
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
        <?php
            }
          }
        } else {
          echo "No rooms found.";
        }
        ?>

      </div>
    </div> -->

    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Booking System</h4>
        <hr>
        <div id="room-container"></div>
      </div>
    </div>

  </div>

  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      fetchRooms();

    });

    function fetchRooms() {
      fetch('../../api/bookings/fetch_bookings.php')
        .then(response => response.json())
        .then(data => {
          let container = document.getElementById('room-container');
          container.innerHTML = "";
          let currentFloor = -1;
          let room = data.rooms;
          console.log(room);


          room.forEach(room => {
            if (currentFloor !== room.floor) {
              currentFloor = room.floor;
              container.innerHTML += `<h5>Floor: ${room.floor}</h5>`;
            }

            let bgColor = room.status === 'checked_in' ? '#ff4d4d' : '#30d930';
            let modalTarget = room.status === 'checked_in' ? `#roomModal${room.room_number}` : `#bookModal${room.room_number}`;

            container.innerHTML += `
                <div style="display: inline-block; margin: 10px; padding: 20px; background-color: ${bgColor};" class="text-light fw-small p-2 card">
                    <a href="#" data-bs-toggle="modal" data-bs-target="${modalTarget}" class="text-light text-decoration-none">Room ${room.room_number}</a>
                </div>
            `;

            if (room.status === 'checked_in') {
              container.innerHTML += `
                            <div class='modal fade' id='roomModal${room.room_number}' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5>Customer Details for Room ${room.room_number}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <table class="table">
                                                <tr><th>Name</th><td>${room.name}</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
            } else {
              container.innerHTML += `
                            <div class='modal fade' id='bookModal${room.room_number}' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5>Book Room ${room.room_number}</h5>
                                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                        </div>
                                        <div class='modal-body'>
                                            <form id="bookingForm${room.room_number}">
                                                <input type="hidden" name="room_number" value="${room.room_number}">
                                                <label>Full Name:</label>
                                                <input type="text" class="form-control" name="name" required>
                                                <label>Email:</label>
                                                <input type="email" class="form-control" name="email">
                                                <label>Mobile:</label>
                                                <input type="text" class="form-control" name="mobile">
                                                <label>Address:</label>
                                                <input type="text" class="form-control" name="address">
                                                <label>Check-in Date:</label>
                                                <input type="datetime-local" class="form-control" name="checkin_date" required>
                                                <label>Payment Mode:</label>
                                                <select class="form-select" name="pay_mode">
                                                    <option value="upi">UPI</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="upi_cash">UPI / Cash</option>
                                                </select>
                                                <br>
                                                <button type="submit" class="btn btn-primary">Book</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

              document.getElementById(`bookingForm${room.room_number}`).addEventListener("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                fetch('../../api/bookings/create_book.php', {
                    method: "POST",
                    body: formData
                  })
                  .then(response => response.json())
                  .then(data => {
                    alert(data.message);
                    if (data.success) {
                      fetchRooms(); // Refresh room status
                    }
                  })
                  .catch(error => console.error("Error:", error));
              });
            }
          });
        });
    }
  </script>
</body>

</html>