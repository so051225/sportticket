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


		<?php
			include_once('global.php');				
			$globalObj = new GlobalCommon();
			$siteName = $globalObj->get_sitename();
			$siteId =  $globalObj->get_siteId();
		?>

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
				// let date = new Date();
				// let dateAddOneHour = new Date().addHours(1);
				// let dateAddTwoHour = new Date().addHours(2);

				// let labelOption1 = date.Format("yyyy-MM-dd hh:00") + ' - ' + dateAddOneHour.Format("hh:00");
				// let labelOption2 = dateAddOneHour.Format("yyyy-MM-dd hh:00") + ' - ' + dateAddTwoHour.Format("hh:00");

				// let option1TimeStart = date.Format("yyyy-MM-dd hh:00");
				// let option1TimeEnd = dateAddOneHour.Format("yyyy-MM-dd hh:00");
				// let option2TimeStart = dateAddOneHour.Format("yyyy-MM-dd hh:00");
				// let option2TimeEnd = dateAddTwoHour.Format("yyyy-MM-dd hh:00");

				// return {
				// 	'option1': {
				// 		'label': labelOption1,
				// 		'start': option1TimeStart,
				// 		'end': option1TimeEnd
				// 	},
				// 	'option2': {
				// 		'label': labelOption2,
				// 		'start': option2TimeStart,
				// 		'end': option2TimeEnd
				// 	}
				// };

				let date = new Date();
				let dateStr = date.Format("yyyy-MM-dd");

				let hours = date.getHours();
				let mins = date.getMinutes();

				let start = hours;
				let end = hours;

				if (mins > 50) {
					start = hours + 1;
					end = hours + 1;
				}

				let options = [];

				for (var i = start; i <= end; i++) {					
					let option_start_hour = i;
					let option_end_hour = i+1;
					let option_label =  dateStr + " " + option_start_hour + ":00 - " + option_end_hour + ":00";
					options.push({'label':option_label, 'start':option_start_hour, 'end':option_end_hour});
				}

				return options;
			}

			function init_time_options() {
				let options = get_available_datetime();
				console.log(options)

				let elem = $('#time_options');

				let html = "";
				options.forEach(function (item, index) {
					let optionId = 'time_option_' + item['start'];
					let checked = (index == 0)? 'checked': '';
					html += '<input type="radio" id="' + optionId + '" name="time_option" value="' + optionId + '" ' + checked + '>';
					html += '<label for="' + optionId + '" id="label_' + optionId + '">' +  item['label'] +  '</label>';
					html += '<input type="hidden" id="' + optionId + '_end" name="' + optionId + '_end">';					
					html += '<br>';

					console.log(html)
				});

				// html += '<input type="hidden" id="pay_time" name="pay_time">';
				elem.html(html);
			}

			function init_court_list() {
				$.getJSON( "api/getCourtBySite.php?siteid=" + "<?php echo $config_siteid ?>" )
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

			function validateForm() {
				// let MS_PER_MINUTE = 60000;
				// let TEN_MINS = 10 * MS_PER_MINUTE;

				// console.log($("time_option").val());
				// // return false;
				// if ($("time_option").val() !== "time_option_2") return false;

				// let start_date = new Date($('#time_option_2_start').val());
				// let accept_date = new Date(start_date - TEN_MINS);

				// if (new Date() > accept_date) {
				// 	return true;
				// }

				// $("#time_err_msg").addClass("alert alert-danger");
				// $("#time_err_msg").html(accept_date.Format("hh:mm") + " 後才可以租用");
				return true;
			}

			function initAmount(siteid) {
				let day = new Date().getDay();
				let isWeekend = (day === 6) || (day === 0);
				let amount = "20.0";
				if (siteid === 1) {
					amount = isWeekend ? "20.0" : "10.0";
				} else {
					amount = "20.0";
				}
				$("#amount_field").html(amount);
				$("#amount").val(amount);
			}

			$( document ).ready(function() {
				init_time_options();
				init_court_list();
				initAmount(<?php echo $siteId; ?>);
				// $("form").submit(function(e) {
				// 	$("#pay_time").val(new Date().Format("yyyy-MM-dd hh:mm:ss"));
				// });
			});
		</script>
</head>
<body>
		<header>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
			<h5 class="my-0 mr-md-auto font-weight-normal">
				<?php						
					echo $siteName . " - 新增票據"; 
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
		</div>
	</header>
	<div class="container">
		<div class="card bg-default">
			<div class="card-body">
				<form id="order_form" class="form-group" action="./api/postOrder.php" method="POST" onsubmit="return validateForm()" autocomplete="off">
					<p>證件類型選擇：</p>
					<div>
						<input type="radio" id="id" name="id_type" value="ID" checked>
						<label for="id">身份證號碼</label><br>
						<input type="radio" id="esport_id" name="id_type" value="ESPORT_ID">
						<label for="esport_id">運動易會員</label><br>
						<input type="radio" id="other_id" name="id_type" value="OTHER_ID">
						<label for="other_id">其他</label>
					</div>

					<div>
						<input type="text" name="id_value" id="id_no" placeholder="請輸入證件號碼" required>
					</div>
					<hr>
					<div>
					<label for="courts">場地：</label>
						<select name="court_id" id="court_id"></select>
					</div>
					<hr>
					<div>
						<label for="quantity">人數：</label>
						<input type="number" id="quantity" name="quantity" min="1" value="1">
					</div>
					<hr>
					<!--<div>
						<input type="radio" id="time_option_1" name="time_option" value="time_option_1" checked>
						<label for="time_option_1" id="label_time_option_1"></label>
						<input type="hidden" id="time_option_1_start" name="time_option_1_start">
						<input type="hidden" id="time_option_1_end" name="time_option_1_end">
						<br>
						<input type="radio" id="time_option_2" name="time_option" value="time_option_2">
						<label for="time_option_2" id="label_time_option_2"></label>
						<input type="hidden" id="time_option_2_start" name="time_option_2_start">
						<input type="hidden" id="time_option_2_end" name="time_option_2_end">
						<div class=".d-none" role="alert" id="time_err_msg"></div>
						<br>
						<input type="hidden" id="pay_time" name="pay_time">
					</div>-->
					<div id='time_options'>
					</div>
					<hr>

					<div>
						金額： <span id="amount_field"></span>
						<input type="hidden" id="amount" name="amount" value="">
					</div>

					<label for="pay_method">支付方式</label>
						<select name="pay_method" id="pay_method">
							<option value="現金" selected="selected">現金</option>
							<option value="MPay">MPay</option>
							<option value="澳門通卡">澳門通卡</option>
							<option value="雲閃付">雲閃付</option>
							<option value="銀聯閃付卡">銀聯閃付卡</option>
							<option value="代金券">代金券</option>
						</select>
					</div>
				</form>		
			</div>
			<button class="btn btn-primary m-2" type="submit" form="order_form"><i class="fa fa-print"></i> 確認</button>
			<button class="btn btn-danger m-2" onclick="window.location.href ='index.php'"><i class="fa fa-home"></i> 返回</button>
		</div>
	</div>
</body>
</html>