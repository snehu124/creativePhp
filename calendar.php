<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}
$teacher_id = $_SESSION['teacher_id'];
?>

<!-- No <html>, <head>, or <body> tag here -->

<div class="container">
  <h2 class="text-center mt-4 mb-4">📅 Schedule Your Classes</h2>
  <div id="calendar"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="classModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="classForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Schedule Class</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="teacher_id" value="<?= $teacher_id ?>">
          <div class="mb-3">
            <label>Class Title</label>
            <input type="text" name="title" class="form-control" required />
          </div>
          <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" id="classDate" class="form-control" required />
          </div>
          <div class="mb-3">
            <label>Time</label>
            <input type="time" name="time" class="form-control" required />
          </div>
          <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Save</button>
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function initCalendar() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      dateClick: function(info) {
        $('#classDate').val(info.dateStr);
        const modal = new bootstrap.Modal(document.getElementById('classModal'));
        modal.show();
      },
      events: 'fetch_classes.php'
    });
    calendar.render();

    $('#classForm').on('submit', function(e) {
      e.preventDefault();
      $.post('save_class.php', $(this).serialize(), function(res) {
        alert(res.message);
        if (res.status === 'success') {
          $('#classModal').modal('hide');
          calendar.refetchEvents();
        }
      }, 'json');
    });
  }
</script>
