<script>
$(document).ready(function() {
  // Timestudy special buttons confirm
  $("#dialog-weekend").dialog({
      autoOpen: false,
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      closeOnEscape: false,
      open: function(event, ui) {
          $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
      },
      buttons: {
          "Update": function() {
              window.location.href = "./includes/timestudyWeekend.inc.php?id=<?php echo $mhfrpid; ?>";
          },
          Cancel: function() {
              $(this).dialog("close");
          }
      }
  });
  $("#dialog-leave").dialog({
      autoOpen: false,
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      closeOnEscape: false,
      open: function(event, ui) {
          $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
      },
      buttons: {
          "Update": function() {
              window.location.href = "./includes/timestudyLeave.inc.php?id=<?php echo $mhfrpid; ?>";
          },
          Cancel: function() {
              $(this).dialog("close");
          }
      }
  });
  $("#dialog-vacant").dialog({
      autoOpen: false,
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      closeOnEscape: false,
      open: function(event, ui) {
          $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
      },
      buttons: {
          "Update": function() {
              window.location.href = "./includes/timestudyVacant.inc.php?id=<?php echo $mhfrpid; ?>";
          },
          Cancel: function() {
              $(this).dialog("close");
          }
      }
  });
  $("#dialog-hours").dialog({
      autoOpen: false,
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      closeOnEscape: false,
      open: function(event, ui) {
          $(".ui-dialog-titlebar-close", ui.dialog | ui).hide();
      },
      buttons: {
        "Save Hours 1-8": function() {
            $('#timeLogForm').find(':input').prop('disabled', false);
            $('#timeLogForm').submit();
        },
        "Update": function() {
            window.location.href = "./includes/timestudyHours.inc.php?id=<?php echo $mhfrpid; ?>&currentday=<?php echo $currentDay; ?>";
        },
        Cancel: function() {
            $(this).dialog("close");
        }
      }
  });

  $("#tsWeekend").on("click", function() {
    $("#dialog-weekend").dialog("open");
  });
  $("#tsLeave").on("click", function() {
    $("#dialog-leave").dialog("open");
  });
  $("#tsVacant").on("click", function() {
    $("#dialog-vacant").dialog("open");
  });
  $("#tsHours").on("click", function() {
    $("#dialog-hours").dialog("open");
  });
});
</script>