function handleSubmit() {
    // Disable selected radio buttons
    var selectedRoom = $('input[name="room"]:checked').val();
    var selectedTime = $('input[name="time"]:checked').val();
  
    if (selectedRoom) {
        localStorage.setItem(selectedRoom + '_disabled', 'disabled');
    }
  
    if (selectedTime) {
        localStorage.setItem(selectedTime + '_disabled', 'disabled');
    }
  }
  
  // Restore disabled state on page load
  $(document).ready(function () {
    $('input[name="room"]').each(function () {
        var room = $(this).val();
        if (localStorage.getItem(room + '_disabled') === 'disabled') {
            $(this).attr('disabled', true);
        }
    });
  
    $('input[name="time"]').each(function () {
        var time = $(this).val();
        if (localStorage.getItem(time + '_disabled') === 'disabled') {
            $(this).attr('disabled', true);
        }
    });
  });