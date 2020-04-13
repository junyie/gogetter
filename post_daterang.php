
<!DOCTYPE html>
<html>
<body>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Date_Range:
    <input type="text" name="datefilter" value="" />
    <input type="hidden" name="date1" value="" id="date1Input"/>
    <input type="hidden" name="date2" value="" id="date2Input"/>
    <br>
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['datefilter'];
    if (empty($name)) {
        echo "Date is empty";
    } else {
        echo $name;
    }
}
?>

</body>
</html>

<script type="text/javascript">
$(function() {

  $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' to ' + picker.endDate.format('DD-MM-YYYY'));
      date1 = picker.startDate.format('DD-MM-YYYY');
      date2 = picker.endDate.format('DD-MM-YYYY');
      $("#date1Input").val(date1);
      $("#date2Input").val(date2);
  });

  $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>