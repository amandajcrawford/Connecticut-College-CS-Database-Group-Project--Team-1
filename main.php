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
          <li><a href="compare.html"> Compare </a>
          </li>
          <li><a href="myPortfolio.html"> My Portfolio </a>
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
				  <button type="submit" name="button" class="btn btn-default" value="currentPrice" id="sort_pps">Price Per Share</button>
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
                      <th>#</th>
                      <th>Ticker Symbol</th>
                      <th>Company Name</th>
                      <th>Sector</th>
                      <th>Stock Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1,001</td>
                      <td>Lorem</td>
                      <td>ipsum</td>
                      <td>dolor</td>
                      <td>sit</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
            <div class="row">
                <button type="submit" id="compareSubmit" class="btn btn-default">Compare</button>
            </div>
        </div>
      </div>
      <div class="col-sm-8 col-sm-offset-4 col-md-9 col-md-offset-3 main">
        <h1 class="page-header">Stock List</h1>
        <div class="table-responsive">
			<form name="compare" action="compare.php" method="get">
			  <table class="table table-striped">
				<thead>
				  <tr>
					<th>Select</th>
					<th>Ticker Symbol</th>
					<th>Company Name</th>
					<th>Sector</th>
					<th>Stock Price</th>
				  </tr>
				</thead>
				<tbody id="stock_table_body">
				</tbody>
			  </table>
			  <input type="submit" value="Compare" id="compareSubmit" class="btn btn-default">
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
					companySummary VARCHAR(200),
					tickerSymbol VARCHAR(5) not null primary key,
					currentPrice DOUBLE PRECISION not null,
					openingPrice DOUBLE PRECISION not null, 
					closingPrice DOUBLE PRECISION,
					totalMarketShare DOUBLE PRECISION,
					earningsPerShare DOUBLE PRECISION,
					dayLow DOUBLE PRECISION,
					dayHigh DOUBLE PRECISION,
					52weekLow DOUBLE PRECISION,
					52weekHigh DOUBLE PRECISION
					)";
			mysql_query($cmd);
			
			$cmd = "CREATE TABLE clientPortfolio(
					tickerSymbol VARCHAR(5) not null,
					companyName VARCHAR(50) not null,
					numShares INT default 0,
					dateTransaction TIMESTAMP not null,
					typeTransaction CHAR(1) not null,
					pricePerShare DOUBLE PRECISION,
					divendRate DOUBLE PRECISION default 0,
					primary key (tickerSymbol, dateTransaction)
					)";
					
			mysql_query($cmd);
			
			mysql_close($db_conn);
		}
		
		function createCompareTable($select){
			$db_conn = mysql_connect("localhost", "root", "");
			if (!$db_conn)
				die("Unable to connect: " . mysql_error()); 
			mysql_select_db("stockTrader", $db_conn);
			
			$url = "http://download.finance.yahoo.com/d/table2.csv?s="
			. $select[0] . "," . $select[1] . "," . $select[2] . "," . $select[3] . "," . $select[4]."&f=nn4sl1opj3e7ghjk&e=.csv";
			$data = file_get_contents($url);
			file_put_contents('table2.csv',$data);
			$cmd = "LOAD DATA LOCAL INFILE 'table2.csv' INTO TABLE companyProfile
					FIELDS TERMINATED BY ','";
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
				$table .= 'txt+="<td> <input type=\"checkbox\" value='.$row['tickerSymbol'].'></td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['sector'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['currentPrice'].'</td>";'. PHP_EOL;
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
				$table .= 'txt+="<td> <input type=\"checkbox\" value='.$row['tickerSymbol'].'></td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['sector'].'</td>";'. PHP_EOL;
				$table .= 'txt+="<td>'.$row['currentPrice'].'</td>";'. PHP_EOL;
				$table .= 'txt+="</tr>";'. PHP_EOL;
			}
			mysql_close($db_conn);
			
			$table .="document.getElementById(\"stock_table_body\").innerHTML=txt;". PHP_EOL;
			$table .="</script>". PHP_EOL;
			echo $table;
		}
		
		function createClientPortfolio(){
		}
		createDB();
		populateTable();
		if(isset($_GET["button"])){
			$att = $_GET["button"];
			sorting($att);
		}
	?>
</body>
</html>


