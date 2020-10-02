<div class="page-header" style="margin-bottom:0px;" class="col-md-12">
    <div class="page-title">
        <h3><?php echo $this->__aT('Dashboard'); ?></h3>
    </div>
</div>

<!-- Chart Graph -->
<div class="col-xs-12">
    <script type="text/javascript" src="https://www.chartjs.org/dist/2.8.0/Chart.min.js"></script>
    <script type="text/javascript" src="https://www.chartjs.org/samples/latest/utils.js"></script>
</div>

<div class="dashbord_outer">
    <div class="dashbord_sec">
       <canvas id="canvas"></canvas>
        <div class="clearfix"></div>
    </div>

    
</div>

<div class="clearfix"></div>
<script>
    	var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};
var config = {
    		type: 'line',
			data: {
				labels: ['October', 'November', 'December'],
				datasets: [{
					label: 'Total Order $',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						150, 450, 600
					],
					fill: false,
				}
              ]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Sales Graph'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value'
						},
						ticks: {
							min: 0,
							max: 2000,
							// forces step size to be 5 units
							stepSize: 200
						}
					}]
				}
			}
		};

window.onload = function() {
	var ctx = document.getElementById('canvas').getContext('2d');
	window.myLine = new Chart(ctx, config);
};
</script>


