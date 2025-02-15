<?php require_once('../../config/config.php'); ?>
<?php require_once('../../config/ifNotLogin.php'); ?>
<?php require_once('../middleware/checkAccess.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bookings</title>
  <?php require_once('../components/header_script.php'); ?>
</head>

<body>
  <?php require_once('../components/header.php'); ?>
  <!-- Main content Start -->

  <div class="row">
    <div class="w-100">
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
  </div>

  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
</body>

</html>