<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<!-- js datatable -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<link rel="stylesheet" href="css/main.css">
		
		<title>Order Form</title>

		<?php include_once('global.php'); ?>

		<script>
			Date.prototype.Format = function (fmt) { //author: meizz
				var o = {
					"M+": this.getMonth() + 1,
					"d+": this.getDate(),
					"h+": this.getHours(),
					"m+": this.getMinutes(),
					"s+": this.getSeconds(),
					"q+": Math.floor((this.getMonth() + 3) / 3), //season
					"S": this.getMilliseconds()
				};
				if (/(y+)/.test(fmt)) fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
				for (var k in o)
				if (new RegExp("(" + k + ")").test(fmt)) fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
				return fmt;
			}
			Date.prototype.addHours = function(h) {
				this.setTime(this.getTime() + (h*60*60*1000));
				return this;
			}

			function formatDate(date) {
				var d = new Date(date),
					month = '' + (d.getMonth() + 1),
					day = '' + d.getDate(),
					year = d.getFullYear();

				if (month.length < 2) 
					month = '0' + month;
				if (day.length < 2) 
					day = '0' + day;

				return [year, month, day].join('-');
			}

			function get_available_datetime() {
				// let currentDate = new Date();
				// let timeOption1 = formatDate(currentDate) + ' ' +
				// 	currentDate.getHours() + ':' + '00' + ' - ' + (currentDate.getHours() + 1) + ':00';
				// let timeOption2 = formatDate(currentDate) + ' ' +
				// 	(currentDate.getHours() + 1) + ':' + '00' + ' - ' + (currentDate.getHours() + 2) + ':00';
				// return [timeOption1, timeOption2];
				let date = new Date();
				let dateAddOneHour = new Date().addHours(1);
				let dateAddTwoHour = new Date().addHours(2);

				let labelOption1 = date.Format("yyyy-MM-dd hh:00") + ' - ' + dateAddOneHour.Format("hh:00");
				let labelOption2 = dateAddOneHour.Format("yyyy-MM-dd hh:00") + ' - ' + dateAddTwoHour.Format("hh:00");

				let option1TimeStart = date.Format("yyyy-MM-dd hh:00");
				let option1TimeEnd = dateAddOneHour.Format("yyyy-MM-dd hh:00");
				let option2TimeStart = dateAddOneHour.Format("yyyy-MM-dd hh:00");
				let option2TimeEnd = dateAddTwoHour.Format("yyyy-MM-dd hh:00");

				let abc =  {
					'option1': {
						'label': labelOption1,
						'start': option1TimeStart,
						'end': option1TimeEnd
					},
					'option2': {
						'label': labelOption2,
						'start': option2TimeStart,
						'end': option2TimeEnd
					}
				};
				console.log(abc);
				return abc;
			}


			function init_time_options() {
				let options = get_available_datetime();
				$('#label_time_option_1').html(options['option1']['label']);
				$('#time_option_1_start').val(options['option1']['start']);
				$('#time_option_1_end').val(options['option1']['end']);

				$('#label_time_option_2').html(options['option2']['label']);
				$('#time_option_2_start').val(options['option1']['start']);
				$('#time_option_2_end').val(options['option1']['end']);
			}

			function init_court_list() {
				$.getJSON( "http://localhost/sportticket/api/getCourtBySite.php?siteid=" + "<?php echo $config_siteid ?>" )
					.done(function( data ) {
						let list;
						console.log(data);
						$.each(data, function( i, item) {
							list += '<option value="' + item['cid']  + '">' + item['court_no'] + '</option>'						
						});
						$('#court_id').html( list );
					})
					.fail(function( jqxhr, textStatus, error ) {
						var err = textStatus + ", " + error;
						console.log( "Request Failed: " + err );
				});
			}

			$( document ).ready(function() {
				init_time_options();
				init_court_list();

				$("form").submit(function(e) {
					$("#pay_time").val(new Date().Format("yyyy-MM-dd hh:mm:ss"));
				});
			});
		</script>
</head>
<body>
	<?php
		// $datetime = new DateTime();
		// $datetime->setTimezone(new DateTimeZone('Asia/Shanghai'));
		// echo $datetime->format('Y-m-d H:i:s');
		$var = 1;
		echo sprintf("%04d", $var);
	?>
	<form action="./api/postOrder.php" method="POST">
		<p>證件類型選擇:</p>
		<div>
			<input type="radio" id="id" name="id_type" value="ID" checked>
			<label for="id">身份證號碼</label><br>
			<input type="radio" id="esport_id" name="id_type" value="ESPORT_ID">
			<label for="esport_id">運動易會員</label><br>
			<input type="radio" id="other_id" name="id_type" value="OTHER_ID">
			<label for="other_id">其他</label>
		</div>

		<div>
			<input type="text" name="id_value" id="id_no" placeholder="請輸入證件號碼">
		</div>
		<hr>
		<div>
		<label for="courts">場地</label>
			<select name="court_id" id="court_id"></select>
		</div>
		<hr>
		<div>
			<label for="quantity">人數:</label>
			<input type="number" id="quantity" name="quantity" min="1">
		</div>
		<hr>
		<div>
			<input type="radio" id="time_option_1" name="time_option" value="time_option_1" checked>
			<label for="time_option_1" id="label_time_option_1"></label>
			<input type="hidden" id="time_option_1_start" name="time_option_1_start">
			<input type="hidden" id="time_option_1_end" name="time_option_1_end">
			<br>
			<input type="radio" id="time_option_2" name="time_option" value="time_option_2">
			<label for="time_option_2" id="label_time_option_2"></label>
			<input type="hidden" id="time_option_2_start" name="time_option_2_start">
			<input type="hidden" id="time_option_2_end" name="time_option_2_end">
			<br>
			<input type="hidden" id="pay_time" name="pay_time">
		</div>
		<hr>
		<label for="pay_method">支付方式</label>
			<select name="pay_method" id="pay_method">
				<option value="CASH" selected="selected">現金</option>
				<option value="MPAY">Mpay</option>
				<option value="MACAUPASS">澳門通卡</option>
				<option value="UNIONPAY">雲閃付</option>
				<option value="QUICKPASS">銀聯閃付卡</option>
			</select>
		</div>
		<hr>
		<input type="submit" value="打印單據">
	</form>
</body>
</html>