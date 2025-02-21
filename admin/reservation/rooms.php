<?php require_once('../../config/config.php'); ?>
<?php require_once('../../config/ifNotLogin.php'); ?>
<?php require_once('../middleware/checkAccess.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Rooms</title>
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
              Rooms
              <span class="position-absolute top-0 end-0">
                <a class="badge rounded-pill bg-primary text-decoration-none shadow p-2 px-3" type="button" data-bs-toggle="modal" data-bs-target="#createRoomModal">
                  CREATE ROOM
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
                    <th>#</th>
                    <th>Room No.</th>
                    <th>Floor</th>
                    <th>Room Type</th>
                    <th>Price</th>
                    <th>Reserve</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="roomsList">
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Rooms Modal -->
  <div class="modal fade" id="createRoomModal" tabindex="-1" aria-labelledby="createRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="createRoomModalLabel">Create Room</h1>
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
  </div>

  <!-- Edit Room Modal -->
  <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editRoomForm">
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
  </div>



  <!-- Main content End -->
  <?php require_once('../components/footer.php'); ?>
  <?php require_once('../components/footer_script.php'); ?>
  <script>
    $(document).ready(function() {
      // fetch the rooms list
      fetchRooms();
    });

    $("#editRoomModal").on("shown.bs.modal", function() {
      $(this).trigger("focus");
    });

    // Fetch rooms
    function fetchRooms() {
      $.ajax({
        url: "../../api/rooms/read.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
          if (data.success) {
            let html = "";
            data.rooms.forEach((room) => {
              html += `
                <tr>
                  <td data-order="${room.created_at}">${room.id}</td>
                  <td>${room.room_number}</td>
                  <td>${room.floor}</td>
                  <td>${room.category}</td>
                  <td>${room.price}</td>  
                  <td style="text-transform: capitalize;">${room.reserve}</td>  
                  <td class="d-flex gap-1">
                    <button type="button" class="btn btn-info btn-sm text-light px-2 py-1 rounded-circle" onclick="editRoom('${room.id}', '${room.room_number}', '${room.floor}', '${room.category}', '${room.price}', '${room.description}', '${room.reserve}')">
                      <i class="fa-solid fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm text-light px-2 py-1 rounded-circle" onclick="deleteRoom('${room.id}')">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </td>
                </tr>`;
            });

            // Destroy old DataTable instance before updating
            if ($.fn.DataTable.isDataTable("#roomsTable")) {
              $("#roomsTable").DataTable().destroy();
            }

            $("#roomsList").html(html); // Update table body

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
            $("#roomsList").html('<tr><td class="text-center" colspan="5">No Rooms found.</td></tr>');
          }
        },
        error: function(err) {
          console.error("Error fetching rooms:", err);
        },
      });
    }

    // Handle Create Room Form Submission
    $("#createRoomForm").submit(function(event) {
      event.preventDefault();
      let formData = new FormData(this);

      $.ajax({
        url: "../../api/rooms/create.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(result) {
          console.log(result);

          let notifyType = result.success ? "success" : "danger"; // Success or Error type
          let notifyIcon = result.success ? "fa fa-check-circle" : "fa fa-exclamation-circle";
          let notifyMessage = result.success ? "Room Created Successfully!" : (result.message || "Some error occurred!");

          // Show notification
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
            z_index: 1051
          });

          if (result.success) {
            fetchRooms();
            $("#createRoomForm")[0].reset(); // Reset the form
            $("#createRoomModal").modal("hide"); // Close the modal
          } else {
            setTimeout(fetchRooms, 500); // ✅ Delay to ensure fresh data is fetched
          }
        },
        error: function() {
          $.notify({
            title: "<strong>Notification</strong><br>",
            message: "Some error occurred!",
            icon: "fa fa-exclamation-circle"
          }, {
            type: "danger",
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
            z_index: 1051
          });

          fetchRooms();
          $("#createRoomForm")[0].reset(); // Reset the form
          $("#createRoomModal").modal("hide"); // Close the modal
        }
      });
    });

    // Edit room Value appended
    function editRoom(id, room_number, floor, category, price, description, reserve) {
      $("#roomId").val(id);
      $("#roomNumber").val(room_number);
      $("#roomFloor").val(floor);
      $("#roomCategory").val(category);
      $("#roomPrice").val(price);
      $("#roomDescription").val(description);
      $("#roomReserve").val(reserve);

      // $("#editRoomModal").modal("show");
      setTimeout(() => {
        $("#editRoomModal").modal("show"); // Show after a short delay
      }, 300);
    }

    // Delete doctor Function
    function deleteRoom(roomId) {
      swal({
        text: "You want to delete this Room?",
        icon: "warning",
        buttons: {
          cancel: {
            text: "Cancel",
            value: false,
            visible: true,
            className: "btn btn-danger",
            closeModal: true,
          },
          delete: {
            text: "Delete",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true,
          },
        },
      }).then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: "../../api/rooms/delete.php",
            type: "POST",
            data: {
              id: roomId
            },
            success: function(response) {
              // response = JSON.parse(response);

              // console.log("res-1",response);
              // console.log("res-2",response.success);

              if (response.success) {
                swal("Deleted!", "Room deleted successfully!", "success").then(() => {
                  fetchRooms(); // Refresh the document list
                });
              } else {
                swal("Error!", "Unable to delete the room.", "error");
                fetchRooms(); // Refresh the document list
              }
            }
          });
        }
      });
    }

    // Update Room POST request
    // Update Room POST request
    function updateRoom() {
      const formData = new FormData();
      formData.append("id", $("#roomId").val());
      formData.append("room_number", $("#roomNumber").val());
      formData.append("floor", $("#roomFloor").val());
      formData.append("category", $("#roomCategory").val());
      formData.append("price", $("#roomPrice").val());
      formData.append("description", $("#roomDescription").val());
      formData.append("reserve", $("#roomReserve").val());

      $.ajax({
        url: "../../api/rooms/update.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          let notifyType = response.success ? "success" : "danger";
          let notifyIcon = response.success ? "fa fa-check-circle" : "fa fa-exclamation-circle";
          let notifyMessage = response.success ? "Room details updated successfully!" : response.message;

          // Show notification
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

          if (response.success) {
            $("#editRoomModal").modal("hide");
            setTimeout(() => {
              fetchRooms();
            }, 300);
          }
        },
        error: function() {
          $.notify({
            title: "<strong>Notification</strong><br>",
            message: "Failed to update Room details.",
            icon: "fa fa-exclamation-circle"
          }, {
            type: "danger",
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
        },
      });
    }
  </script>
</body>

</html>