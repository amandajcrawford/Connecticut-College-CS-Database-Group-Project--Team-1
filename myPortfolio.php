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

  <!-- Custom styles for this template -->
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
          <li>
            <a href="main.php">Main</a>
          </li>
          <li>
            <a href="compare.php">Compare</a>
          </li>
          <li class="active">
            <a href="">My Portfolio</a>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </div>
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-4 col-md-2 sidebar">

        <div class="container-fluid">
          <div class="row" id="constraints">
            <h3 class="divider">
              <a href="">Limit By</a>
            </h3>
            <div class="btn-group btn-group-vertical" id="limit_btn_group">
			<form action="myPortfolio.php" method="get">
              <button type="submit" name="button2" value="B" class="btn btn-default" id="limit_bought">Bought</button>
              <button type="submit" name="button2" value="S" class="btn btn-default" id="limit_sold">Sold</button>
              <button type="submit" name="button2" value="D" class="btn btn-default" id="limit_dividend">Dividend</button>
              <button type="submit" name="button2" value="ND" class="btn btn-default" id="limit_nodividend">No Dividend</button>
			</form>
            </div>
          </div>
          <div class="row" id="sort">
            <h3 class="divider">
              <a href="">Sort By</a>
            </h3>
            <div class="btn-group btn-group-vertical" id="sort_bttn_group">
			<form action="myPortfolio.php" method="get">
              <button type="submit" name="button" class="btn btn-default" value="tickerSymbol" id="sort_ticker">Ticker Symbol</button>
              <button type="submit" name="button" class="btn btn-default" value="companyName" id="sort_compname">Company Name</button>
              <button type="submit" name="button" class="btn btn-default" value="dateTransaction" id="sort_transdate">Transaction Date</button>
              <button type="submit" name="button" class="btn btn-default" value="pricePerShare" id="sort_pps">Price Per Share</button>
              <button type="submit" name="button" class="btn btn-default" value="numShares" id="sort_numshares">Numbers of Shares</button>
              <button type="submit" name="button" class="btn btn-default" value="dividendRate" id="sort_divendend">Dividend Rate</button>
			</form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8 col-sm-offset 3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header text-center text-primary">Stock List
				<span class="label label-default"></span>
			</h1>
          <div class="container-fluid">
              <div class="row">
                  <div class="panel">
                      <div class="panel-body">
                          <div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead class="header">
									<tr>
										<th>Ticker Symbol</th>
										<th>Company Name</th>
										<th># of Shares</th>
										<th>Date of Transaction</th>
										<th>Type of Transaction</th>
										<th>Share Price</th>
										<th>Dividend Rate</th>
									</tr>
								</thead>
								<tbody id ="port_table_body">
								</tbody>
							</table>
						</div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
<?php
	function writeCompareTable(){
		$db_conn = mysql_connect("localhost", "root", "");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error());
		mysql_select_db("stockTrader", $db_conn);
		$cmd = "SELECT * FROM clientPortfolio";        
		$retval = mysql_query($cmd);
		$table="<script type=\"text/javascript\">". PHP_EOL;
		$table.="var txt=\"\";". PHP_EOL;
		while($row = mysql_fetch_array($retval)){
			$table .= 'txt+="<tr>";'. PHP_EOL;
		//	$table .= 'txt+="<td> <input class=\"rad\" type=\"radio\" name=\"ticker\" value=\"'.$row['tickerSymbol'].'\"></td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['numShares'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dateTransaction'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['typeTransaction'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['pricePerShare'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dividendRate'].'</td>";'. PHP_EOL;
			$table .= 'txt+="</tr>";'. PHP_EOL;
		}
		mysql_close($db_conn);
		$table .="document.getElementById(\"port_table_body\").innerHTML=txt;". PHP_EOL;
		$table .="</script>". PHP_EOL;
		echo $table;
	}
	function sortTable($attribute){
		$db_conn = mysql_connect("localhost", "root", "");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error());
		mysql_select_db("stockTrader", $db_conn);
		$cmd = "SELECT * FROM clientPortfolio ORDER BY ". $attribute . " ASC";        
		$retval = mysql_query($cmd);
		$table="<script type=\"text/javascript\">". PHP_EOL;
		$table.="var txt=\"\";". PHP_EOL;
		while($row = mysql_fetch_array($retval)){
			$table .= 'txt+="<tr>";'. PHP_EOL;
		//	$table .= 'txt+="<td> <input class=\"rad\" type=\"radio\" name=\"ticker\" value=\"'.$row['tickerSymbol'].'\"></td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['numShares'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dateTransaction'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['typeTransaction'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['pricePerShare'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dividendRate'].'</td>";'. PHP_EOL;
			$table .= 'txt+="</tr>";'. PHP_EOL;
		}
		mysql_close($db_conn);
		$table .="document.getElementById(\"port_table_body\").innerHTML=txt;". PHP_EOL;
		$table .="</script>". PHP_EOL;
		echo $table;
	}
	function limitTable($attribute){
		$db_conn = mysql_connect("localhost", "root", "");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error());
		mysql_select_db("stockTrader", $db_conn);
		if($attribute=="S" || $attribute=="B"){
			$cmd = "SELECT * FROM clientPortfolio WHERE typeTransaction='". $attribute ."'";   
		}
		elseif($attribute=="D"){
			$cmd = "SELECT * FROM clientPortfolio WHERE dividendRate>0";
		}
		else{
			$cmd = "SELECT * FROM clientPortfolio WHERE dividendRate=0";
		}
		$retval = mysql_query($cmd);
		$table="<script type=\"text/javascript\">". PHP_EOL;
		$table.="var txt=\"\";". PHP_EOL;
		while($row = mysql_fetch_array($retval)){
			$table .= 'txt+="<tr>";'. PHP_EOL;
		//	$table .= 'txt+="<td> <input class=\"rad\" type=\"radio\" name=\"ticker\" value=\"'.$row['tickerSymbol'].'\"></td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['numShares'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dateTransaction'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['typeTransaction'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['pricePerShare'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dividendRate'].'</td>";'. PHP_EOL;
			$table .= 'txt+="</tr>";'. PHP_EOL;
		}
		mysql_close($db_conn);
		$table .="document.getElementById(\"port_table_body\").innerHTML=txt;". PHP_EOL;
		$table .="</script>". PHP_EOL;
		echo $table;
	}
	
	
	
	writeCompareTable();
	if(isset($_GET["button"])){
		$att = $_GET["button"];
		sortTable($att);
	}
	if(isset($_GET["button2"])){
		$att = $_GET["button2"];
		limitTable($att);
	}
	

?>


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
</body>

</html>