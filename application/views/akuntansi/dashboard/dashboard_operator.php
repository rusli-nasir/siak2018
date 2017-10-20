<?php 
    print_r($data);
    die();
 ?>
<script type="text/javascript" src="<?php echo base_url(); ?>frontpage/js/jquery-3.1.0/jquery-3.1.0.min.js"></script>
<link href="<?php echo base_url();?>/assets/akuntansi/css/bootstrap.min.css" rel="stylesheet">
<script src="<?php echo base_url();?>/assets/akuntansi/js/Chart.bundle.min.js"></script>
<style type="text/css">
    

            /*--------------------------------------*/
            /*     jpolly168 AeVale/OneSixEight     */
            /*     XblackvelvetX                    */
            /*     Main Elements,,,,,,,             */
            /*     #wah comes int waves....wahhhhhh.*/
            /*--------------------------------------*/
            
    @import url(http://fonts.googleapis.com/css?family=Roboto:400,500,900);
body {
      background-color: #f44336;
                transition: background-color 300ms;
                font-family: 'Roboto', sans-serif;   
                background:url('<?php echo base_url();?>/assets/akuntansi/image/bg_dashboard.jpg');
                background-repeat:none;
                background-size:cover;
}
.avatar {
                width: 200px;
                height: 200px;
                margin-left: 2em;
                margin-top:2em;
                border-radius: 200px;
                float:center;
}
.jumbotron{
    background-color:#ffffff;
    border:1px solid #AAA;
    border-bottom:3px solid #BBB;
    padding:0px;
    margin-top:4em;
    overflow:hidden;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);    
}
    .header{
                background: #607D8B;
                
                }
            .blue h1, h2, h3 {
                color: #2196F3;
            }
            .headline {
                color: #FFFFFF;
                margin: 1em;
            }
.card {
    background:#FFF;
    display: block;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    border:1px solid #AAA;
    border-bottom:3px solid #BBB;
    padding:0px;
    margin-top:5em;
    overflow:hidden;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-body{
 margin:1em;   
}

.pull-left {
  float: left;
}

.pull-none {
  float: none !important;
}

.pull-right {
  float: right;
}

.card-header{
    width:100%;
    color:#2196F3;
    border-bottom:3px solid #BBB;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    padding:0px;
    margin-top:0px;
    overflow:hidden;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    
}
.card-header-blue{
    background-color:#2196F3;
    color:#FFFFFF;
    border-bottom:3px solid #BBB;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    padding:0px;
    margin-top:0px;
    overflow:hidden;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.card-header-red{
    background-color:#F44336;
    color:#FFFFFF;
    border-bottom:3px solid #BBB;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    padding:0px;
    margin-top:0px;
    overflow:hidden;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.card-header-grey{
    background-color:#424242;
    color:#FFFFFF;
    border-bottom:3px solid #BBB;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    padding:0px;
    margin-top:0px;
    overflow:hidden;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.card-header-orange{
    background-color:#E65100;
    color:#FFFFFF;
    border-bottom:3px solid #BBB;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    padding:0px;
    margin-top:0px;
    overflow:hidden;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.card-header-pink{
    background-color:#E91E63;
    color:#FFFFFF;
    border-bottom:3px solid #BBB;
    box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    font-family: 'Roboto', sans-serif;
    padding:0px;
    margin-top:0px;
    overflow:hidden;
    -webkit-transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
          transition: box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-heading {
    display: block;
    font-size: 24px;
    line-height: 28px;
    margin-bottom: 24px;
    margin-left:1em;
    border-bottom: 1px #2196F3;
    color:#fff;
   
}
.card-footer{
 border-top:1px solid #000;   
    
}

.btn:hover:not(.btn-link):not(.btn-flat) {
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.23), 0 10px 30px rgba(0, 0, 0, 0.19);
}
.btn:active:not(.btn-link):not(.btn-flat) {
  box-shadow: 0 6px 10px rgba(0, 0, 0, 0.23), 0 10px 30px rgba(0, 0, 0, 0.19);
}
.btn:not(.btn-link):not(.btn-flat),
.btn-default:not(.btn-link):not(.btn-flat) {
  background-color: transparent;
}
.btn-grey-mat{
    background-color:#607D8B;
    color:#ffffff;    
    solid 1px; 
    margin:10px;
}

.card-action-pink{
    color:#E91E63;

}
.card-action-red{
    color:#F44336;

}
.card-action-grey{
    color:#424242;

}
.card-action-pink{
    color:#E91E63;

}
.card-action-orange{
    color:#E65100;

}
        .img-fill  {
                max-height: 100%;
                max-width: 100% display :inline-block;
                margin: 1em;
            }
            
                .card-image {
                overflow: hidden;
                position: relative;
                margin-bottom: 1em;
            }
            .card-image:first-child {
                border-radius: 2px 2px 0 0;
            }
            .card-image:last-child {
                border-radius: 0 0 2px 2px;
            }
            .card-image img {
                display: block;
                height: auto;
                width: 100%;
            }

            .card-image-text {
                background-image: -webkit-linear-gradient(top, transparent, rgba(0, 0, 0, 0.5));
                background-image: linear-gradient(to bottom, transparent, rgba(0, 0, 0, 0.5));
                color: #ffffff;
                font-size: 20px;
                line-height: 28px;
                margin: 0;
                padding: 12px 16px;
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
            }
        /**OVERFLOW MENU**/
        /**MENU SETTINGS POPUP**/

            .menu {
                display: none;
                background:#607D8B;
                width: 100%;
                padding: 30px 10px 50px;
                margin: 0 auto;
                text-align: center;
                background-color: #fff;
            }
            .menu ul {
                margin-bottom: 0;
            }
            .menu a {
                color: #000;
                text-transform: uppercase;
                opacity: 0.8;
            }
            .menu a:hover {
                text-decoration: none;
                opacity: 1;
            }
</style>
</head>
<body>


<div class="container">
    <div class="row">
    <div class="jumbotron">
            <h1 class="blue" style="color:#2196F3;">Dashboard</h1>
            <h3 class="blue">Operator</h3>
          
        </div>
    </div>
          <!--small cards-->
    <div class="row">
        <?php foreach ($data as $jenis => $entry): ?>
            <div class="col-md-4">
                <div class = "panel panel-default">
                   <div class = "panel-heading">
                      <h3 class = "panel-title">
                         TUP
                      </h3>
                   </div>
                   
                   <div class = "panel-body">
                        <div id="canvas-holder">
                            <canvas id="chart-area" />
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach ?>
        
    </div>
</div>




<!-- <div class="panel panel-default col-md-3">
  <div class="panel-heading">Panel Heading</div>
  <div class="panel-body">
      <div class="ct-chart"></div>
  </div>
</div> -->



</body>
<script type="text/javascript">
    randomScalingFactor = function() {
        return Math.round(Math.random() * 100);
    };

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    randomScalingFactor(),
                    randomScalingFactor(),
                ],
                backgroundColor: [
                    window.chartColors.grey,
                    window.chartColors.green,
                ],
                label: 'TUP'
            }],
            labels: [
                "Sudah dijurnal",
                "Belum dijurnal"
            ]
        },
        options: {
            responsive: true
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);
    };




</script>
