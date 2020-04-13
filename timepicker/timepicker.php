<br>
<link rel="stylesheet" type="text/css" href="timepicker/assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="timepicker/dist/bootstrap-clockpicker.min.css">
<div class="form-group">
		<div class="input-group clockpicker" data-placement="top" data-align="left" data-donetext="Done">
			<input type="text" class="form-control" value="<?php 
			$datime = mb_substr($set_time, 0, 5);
			
			echo$datime;?>" id="pid" <?php echo "data-id1=".$goalde_id; ?>>
			<span class="input-group-addon" title="Set Reminding Time">
				<span class="glyphicon glyphicon-time"></span>
			</span>
		</div>
		<!--Debug just for form action = "goalshandler.php" method = "POST">
         id: <input type = "text" name = "id" // echo "value=".$goalde_id; >
		 text: <input type = "text" name = "text"  //echo "value=21:21:11"; >
		 column_name: <input type = "text" name = "column_name" // echo "value=time";>
         <input type = "submit" />
      </form-->
		
<style>
	.input-group {
	width: 110px;
	margin-bottom: 10px;
}
.pull-center {
	margin-left: auto;
	margin-right: auto;
}
	</style>
<script type="text/javascript" src="timepicker/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="timepicker/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="timepicker/dist/bootstrap-clockpicker.min.js"></script>
<script type="text/javascript">
$('.clockpicker').clockpicker()
	.find('input').change(function(){
		console.log(this.value);	
	});
var input = $('#single-input').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
	'default': 'now'
});

$('.clockpicker-with-callbacks').clockpicker({
		donetext: 'Done',
		init: function() { 
			console.log("colorpicker initiated");
		},
		beforeShow: function() {
			console.log("before show");
		},
		afterShow: function() {
			console.log("after show");
		},
		beforeHide: function() {
			console.log("before hide");
		},
		afterHide: function() {
			console.log("after hide");
		},
		beforeHourSelect: function() {
			console.log("before hour selected");
		},
		afterHourSelect: function() {
			console.log("after hour selected");
		},
		beforeDone: function() {
			console.log("before done");
		},
		afterDone: function() {
			console.log("after done");
		}
	})
	.find('input').change(function(){
		console.log(this.value);
	});

// Manually toggle to the minutes view
$('#check-minutes').click(function(e){
	// Have to stop propagation here
	e.stopPropagation();
	input.clockpicker('show')
			.clockpicker('toggleView', 'minutes');
});
if (/mobile/i.test(navigator.userAgent)) {
	$('input').prop('readOnly', true);
}
</script>
<script type="text/javascript" src="timepicker/assets/js/highlight.min.js"></script>
<script type="text/javascript">
hljs.configure({tabReplace: '    '});
hljs.initHighlightingOnLoad();
</script>

<script>  
	$(document).ready(function(){  
		
		function edit_data(id, text, column_name)  
		{  
			$.ajax({  
				url:"goalshandler.php", 
				method:"POST",  
				data:{id:id, text:text, column_name:column_name},  
				dataType:"text",  
				success:function(data){  
					//alert(data);
					console.log('sent');
					$('#result').html("<div class='alert alert-success'>"+data+"</div>");
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) { 
        		alert("Status: " + textStatus); alert("Error: " + errorThrown); 
    			}  
			});  
		}  
		$("#pid").change(function(){
			var id = $(this).data("id1");    
			var first_name = $('#pid').val();
			edit_data(id, first_name, "time");  		
			//alert("value: " + first_name);
		});   
 
	});  
</script>