<?php require_once('../../config/config.php'); ?>
<?php require_once('../../config/ifNotLogin.php'); ?>
<?php require_once('../middleware/checkAccess.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bookings</title>
  <?php require_once('../components/header_script.php'); ?>
  <style>
    strong{
      font-weight: 500;
    }
    .form-control{
      margin-top: 5px;
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
                        </table>
                      </div>
                    </div>
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
    </div>











    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Booking Form</h4>
        <hr>
        <!-- Booking Form -->
        <form class="forms-sample">
          <div class="row w-100">
            <div class="col-md-6">
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="room_no">Select Room</label>
                <select class="form-select" id="room_no" name="room_no">
                  <option>Select Room</option>
                  <option value="101">101 / AC</option>
                  <option value="102">102 / AC</option>
                </select>
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="serial_number">Serial Number</label>
                <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Serial Number">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="status">Status</label>
                <select class="form-select" name="status" id="status">
                  <option value="checked_in">Checked In</option>
                  <option value="checked_out">Checked Out</option>
                </select>
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="checkin_date">Check In Date</label>
                <input type="datetime-local" class="form-control" id="checkin_date" name="checkin_date">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="checkout_date">Check Out Date</label>
                <input type="datetime-local" class="form-control" id="checkout_date" name="checkout_date">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="mobile">Mobile Number</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address">
              </div>
              <div class="form-group mb-1">
                <label class="mb-0 mt-1" for="id_no">ID Number</label>
                <input type="text" class="form-control" id="id_no" name="id_no" placeholder="ID Number">
              </div>
              <div class="row w-100">
                <div class="col-md-4">
                  <div class="form-group mb-1">
                    <label class="mb-0 mt-1" for="document_1">Document - 1</label>
                    <input type="file" class="form-control" id="document_1" name="document_1" placeholder="ID Number">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-1">
                    <label class="mb-0 mt-1" for="document_2">Document - 2</label>
                    <input type="file" class="form-control" id="document_2" name="document_2" placeholder="ID Number">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-1">
                    <label class="mb-0 mt-1" for="document_3">Customer Image</label>
                    <input type="file" class="form-control" id="document_3" name="document_3" placeholder="ID Number">
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary mr-2">Submit</button>
              <button type="reset" class="btn btn-light">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>


  </div>

  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
</body>

</html>