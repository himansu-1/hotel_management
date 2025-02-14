<!-- base:js -->
<script src="<?= $baseurl ?>assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- inject:js -->
<script src="<?= $baseurl ?>assets/js/off-canvas.js"></script>
<script src="<?= $baseurl ?>assets/js/hoverable-collapse.js"></script>
<script src="<?= $baseurl ?>assets/js/template.js"></script>
<script src="<?= $baseurl ?>assets/js/settings.js"></script>
<script src="<?= $baseurl ?>assets/js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="<?= $baseurl ?>assets/js/dashboard.js"></script>
<!-- End custom js for this page-->


<script src="<?= $baseurl ?>assets/vendors/js/jquery-3.7.1.min.js"></script>
<script src="<?= $baseurl ?>assets/vendors/bootstrap-notify/bootstrap-notify.min.js"></script>

<script>
  $(document).ready(function() {
    <?php if (isset($_SESSION['message'])): ?>
      var type = "<?= $_SESSION['type'] ?? 'info' ?>";
      var icon = "fa fa-bell";

      switch (type) {
        case "success":
          icon = "fa fa-check-circle";
          break;
        case "danger":
          icon = "fa fa-times-circle";
          break;
        case "warning":
          icon = "fa fa-exclamation-triangle";
          break;
        case "info":
          icon = "fa fa-info-circle";
          break;
      }

      $.notify({
        title: "<strong>Notification</strong><br>",
        message: "<?= $_SESSION['message'] ?>",
        icon: icon
      }, {
        type: type,
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

      // Unset session message after showing notification
      <?php unset($_SESSION['message']);
      unset($_SESSION['type']); ?>
    <?php endif; ?>
  });
</script>