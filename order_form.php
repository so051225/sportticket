<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		
		<!-- js datatable -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
		
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<!--
		<script src="js/jquery/external/jquery/jquery.js"></script>
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/js/foundation.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.1/css/foundation.css">-->
		<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="css/main.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

		<!--<link rel="stylesheet" href="css/font.css">-->
		
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
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
<header>
			<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
				<h5 class="my-0 mr-md-auto font-weight-normal">
					<?php
						include_once('global.php');				
						$globalObj = new GlobalCommon();
						$siteName = $globalObj->get_sitename();
						echo $siteName; 
					?>
				</h5>
				<?php
					$queries = array();
					parse_str($_SERVER['QUERY_STRING'], $queries);
					
					if (array_key_exists('date', $queries)) {
						$dateStr = date($queries['date']);
					} else {
						$dateNow = new DateTime("now", new DateTimeZone('Asia/Hong_Kong') );
						$dateStr = date_format($dateNow, 'Y-m-d');
					} 
				
					echo '<input type="hidden" id="thisDate" name="thisDate" value="' . $dateStr . '">';
				?>
				
				<input type="hidden" id="cancelOid" name="cancelOid" value="">
				<button id="create-ticket" class="btn btn-primary" onclick="window.location.href ='order_form.php'"><i class="fa fa-plus"></i> 新增</button>
			</div>
		</header>
		<div class="container">
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
	</div>
</body>
</html>