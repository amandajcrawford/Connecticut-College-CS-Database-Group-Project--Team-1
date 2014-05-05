	<!DOCTYPE html>
<html>

<head></head>

<body>﻿
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SAS Stock Profiler</title>

  <!-- Bootstrap core CSS -->
  <link href="bootstrap-3.1.1-dist/css/bootstrap.min.css" rel="stylesheet">


  <!-- Custom styles for this template -->
  <link href="navbar-fixed-top.css" rel="stylesheet">
  <link href="dashboard.css" rel="stylesheet">


  <!-- Just for debugging purposes. Don't actually copy this line! -->
  <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->




  <div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SAS Stock Profiler</a>
        </div>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="#"> Main </a>
          </li>
          <li><a href="compare.php"> Compare </a>
          </li>
          <li><a href="myPortfolio.php"> My Portfolio </a>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4 col-md-3 sidebar">
        <div class="container-fluid">

          <div class="row" id="constraints">
            <h3 class="divider">
              <a href="">Limit By</a>
            </h3>
            <div class="btn-group" id="limit_btn_group">
              <button type="button" class="btn btn-default" id="limit_bought">Bought</button>
              <button type="button" class="btn btn-default" id="limit_sold">Sold</button>
              <button type="button" class="btn btn-default" id="limit_dividend">Dividend</button>
              <button type="button" class="btn btn-default" id="limit_nodividend">No Dividend</button>
            </div>
          </div>
          <div class="row" id="sort">
            <h3 class="divider">
              <a href="">Sort By</a>
            </h3>
            <div class="btn-group" id="sort_bttn_group">
				<form action="main.php" method="get">
				  <button type="submit" name="button" class="btn btn-default" value="tickerSymbol" id="sort_ticker">Ticker Symbol</button>
				  <button type="submit" name="button" class="btn btn-default" value="companyName" id="sort_compname">Company Name</button>
				  <button type="submit" name="button" class="btn btn-default" value="sector" id="sort_numshares">Sector</button>
				</form>
            </div>
          </div>

          <div class="row" id="selected">
            <h3 class="divider"><a href="">Selected</a>
            </h3>
            <div class="panel panel-default">
              <div class="table-responsive">
                <table class="table-striped">
                  <thead>
                    <tr>
                      <th>Ticker Symbol</th>
                      <th>Stock Price</th>
                    </tr>
                  </thead>
                  <tbody id="select">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8 col-sm-offset-4 col-md-9 col-md-offset-3 main">
        <h1 class="page-header">Stock List</h1>
        <div class="table-responsive">
			<form name="compare" action="compare.php" onSubmit="return checkBoxes();" method="get">
			  <table class="table table-striped">
				<thead>
				  <tr>
					<th>Select</th>
					<th>Ticker Symbol</th>
					<th>Company Name</th>
					<th>Sector</th>
				  </tr>
				</thead>
				<tbody id="stock_table_body">
				</tbody>
			  </table>
			  <input name="compare" type="submit" value="Compare" class="btn btn-default"/>
			</form>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
	<?php
		function createDB(){
			$db_conn = mysql_connect("localhost", "root", "");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error()); 
			mysql_query("CREATE DATABASE stockTrader", $db_conn);
			mysql_select_db("stockTrader", $db_conn);
			$cmd = "CREATE TABLE stocks (
					tickerSymbol VARCHAR(5) not null,
					companyName VARCHAR(50) not null,
					sector VARCHAR(50),
					currentPrice DOUBLE PRECISION,
					primary key (tickerSymbol, companyName)
					)";
			mysql_query($cmd);
			$cmd = "LOAD DATA LOCAL INFILE 'Table1.csv' INTO TABLE stocks
					FIELDS TERMINATED BY ','";
			mysql_query($cmd);
			
			$cmd = "CREATE TABLE companyProfile (
					companyName VARCHAR(50),
					tickerSymbol VARCHAR(5) not null primary key,
					currentPrice DOUBLE PRECISION not null,
					openingPrice DOUBLE PRECISION not null, 
					closingPrice DOUBLE PRECISION,
					earningsPerShare DOUBLE PRECISION,
					dayLow DOUBLE PRECISION,
					dayHigh DOUBLE PRECISION,
					52weekLow DOUBLE PRECISION,
					52weekHigh DOUBLE PRECISION,
					dividendRate DOUBLE PRECISION
					)";
			mysql_query($cmd);
			
			$cmd = "CREATE TABLE clientPortfolio(
					tickerSymbol VARCHAR(5) not null,
					companyName VARCHAR(50) not null,
					numShares INT default 0,
					dateTransaction TIMESTAMP not null,
					typeTransaction CHAR(1) not null,
					pricePerShare DOUBLE PRECISION,
					dividendRate DOUBLE PRECISION,
					primary key (tickerSymbol, dateTransaction)
					)";
					
			mysql_query($cmd);
			
			mysql_close($db_conn);
		}
				
		function sorting($attribute){
			$db_conn = mysql_connect("localhost", "root", "");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error()); 
			mysql_select_db("stockTrader", $db_conn);
			
			$cmd = "SELECT * FROM stocks ORDER BY ". $attribute . " ASC";
			$retval = mysql_query($cmd);
			$table="<script type=\"text/javascript\">". PHP_EOL;
			$table.="var txt=\"\";". PHP_EOL;
			while($row = mysql_fetch_array($retval)){
				$table .= 'txt+="<tr>";'. PHP_EOL;
				$table .= 'txt+="<td> <input class=\"cheBox\" type=\"checkbox\" name=\"symbol[]\" id=\"symbol\" value='.$row['tickerSymbol'].",".$row['currentPrice'].' onclick=\"populateChecks()\"></td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['sector'].'</td>";'. PHP_EOL;
			//	$table .= 'txt+="<td>'.$row['currentPrice'].'</td>";'. PHP_EOL;
				$table .= 'txt+="</tr>";'. PHP_EOL;
			}
			mysql_close($db_conn);
			
			$table .="document.getElementById(\"stock_table_body\").innerHTML=txt;". PHP_EOL;
			$table .="</script>". PHP_EOL;
			echo $table;
		}
		
		function populateTable(){
			$db_conn = mysql_connect("localhost", "root", "");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error()); 
			mysql_select_db("stockTrader", $db_conn);
			$cmd = "SELECT * FROM stocks";            
			$retval = mysql_query($cmd);
			$table="<script type=\"text/javascript\">". PHP_EOL;
			$table.="var txt=\"\";". PHP_EOL;
			while($row = mysql_fetch_array($retval)){
				$table .= 'txt+="<tr>";'. PHP_EOL;
				$table .= 'txt+="<td> <input class=\"cheBox\" type=\"checkbox\" name=\"symbol[]\" id=\"symbol\" value='.$row['tickerSymbol'].",".$row['currentPrice'].' onclick=\"populateChecks()\"></td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['sector'].'</td>";'. PHP_EOL;
			//	$table .= 'txt+="<td>'.$row['currentPrice'].'</td>";'. PHP_EOL;
				$table .= 'txt+="</tr>";'. PHP_EOL;
			}
			mysql_close($db_conn);
			
			$table .="document.getElementById(\"stock_table_body\").innerHTML=txt;". PHP_EOL;
			$table .="</script>". PHP_EOL;
			echo $table;
		}
		
		function getPrice(){
			$db_conn = mysql_connect("localhost", "root", "");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error()); 
			mysql_select_db("stockTrader", $db_conn);
			$cmd = "SELECT tickerSymbol FROM stocks";
			$retval = mysql_query($cmd);
			while($row = mysql_fetch_array($retval)){
				$url = "http://download.finance.yahoo.com/d/table2.csv?s=".$row[0]."&f=l1&e=.csv";
				$data = file_get_contents($url);
				echo $data;
				$cmd = "UPDATE stocks SET currentPrice=".$data."WHERE tickerSymbol=".$row[0]."";
			}
		}
		createDB();
		//getPrice();
		populateTable();
		if(isset($_GET["button"])){
			$att = $_GET["button"];
			sorting($att);
		}
	//	$symbols =array("BAC", "FB", "NOK", "BSBR", "SIRI");
	//	createCompareTable($symbols);
		
	?>
	<script type="text/javascript">
		function checkBoxes(){
			var count =0;
			var inputElements = document.getElementsByTagName('input');
			for (var i=0;inputElements[i];++i){
				if(inputElements[i].className=== "cheBox" && inputElements[i].checked){
					count++;
				//	console.log(inputElements[i].value);
				}
			}
			if(count===0){
				alert("Please select at least one company!");
				return false
			}
			else if(count>5){
				alert("Please select only up to five companies to compare!");
				return false;
			}
			else{
				return true;
			}
		}
		
		function populateChecks(){
			var ticks = new Array();
			var inputElements = document.getElementsByTagName('input');
			var txt ="";
			for (var i=0;inputElements[i];++i){
				if(inputElements[i].className=== "cheBox" && inputElements[i].checked){
					ticks.push(inputElements[i].value);
				//	console.log(inputElements[i].value);
				}
			}
			var split;
			for(var j=0;j<ticks.length;j++){
			split = ticks[j].split(",");
			txt += "<tr><td>"+split[0]+"</td>";
			txt+= "<td>"+split[1]+"</td></tr></ br>";
			}
			document.getElementById('select').innerHTML = txt;
		}
	</script> 
</body>
</html>


