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
          <li class="active">
            <a href="">Compare</a>
          </li>
          <li>
            <a href="myPortfolio.php">My Portfolio</a>
          </li>
        </ul>
      </div>
      <!--/.nav-collapse -->

    </div>
  </div>
  <h1 class="page-header">Stock List</h1>
  <div class="container-fluid">
    <div class="row" id="top">
      <div class="col-md-12 col-sm-12">
        <div class="table-responsive table-condensed">
          <table id="stock_table" class="table table-striped ">
            <thead>
              <tr>
                <th>Ticker Symbol</th>
                <th>Company Name</th>
                <th>Stock Price</th>
                <th>Opening Price</th>
				<th>Closing Price</th>
                <th>EPS</th>
                <th>Day's Low</th>
                <th>Day's High</th>
                <th>52-wk low</th>
                <th>52-wk high</th>
				<th>Dividend Rate</th>
              </tr>
            </thead>
            <tbody id="compare_table_body">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <footer class="row">
    <nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
      <div class="container-fluid">
        <div class="row" id="stock options">
          <div class="col-md-8 col-md-8 col-sm-8">
            <div class="btn" id="add_delete">
			  <form name="f1" action="compare.php" onSubmit="return checkFields();" method="get">
			  Select Company <select id = "selectItems" name="ticker">
			  </select>
              Enter the number of shares<input type="number" min="0" name="amount" value="0" class="btn btn-default" id="num_shares"/>
              <input type="radio" name="tranType" value="B" class="btn"/>Buy
              <input type="radio" name="tranType" value="S" class="btn"/>Sell
              <input type="submit" name="execute" value="Execute Transaction" id="submit_transaction"/>
			  </form>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </footer>
  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="bootstrap-3.1.1-dist/js/bootstrap.min.js"></script>
</body>
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
	function createCompareTable($select){
		$db_conn = mysql_connect("localhost", "root", "");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error()); 
		mysql_select_db("stockTrader", $db_conn);
		$commaCheck = count($select)-1;
		$url = "http://download.finance.yahoo.com/d/table2.csv?s=";
		for($i=0;$i<count($select);$i++){
			$info = explode(",", $select[$i]);
			if($i==$commaCheck){
				$url .= $info[0];
			}
			else{
				$url .= $info[0] . ",";
			}
		}
		$url.= "&f=nsl1ope7ghjkd&e=.csv";
		$data = file_get_contents($url);
		file_put_contents('table2.csv',$data);
		$cmd= "TRUNCATE TABLE companyProfile";
		mysql_query($cmd);
		$cmd = "LOAD DATA LOCAL INFILE 'table2.csv' INTO TABLE companyProfile
				FIELDS TERMINATED BY ',' ENCLOSED BY '\"' ";
		mysql_query($cmd);
		mysql_close($db_conn);
	}
	
	function writeCompareTable(){
		$db_conn = mysql_connect("localhost", "root", "");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error());
		mysql_select_db("stockTrader", $db_conn);
		$cmd = "SELECT * FROM companyProfile";        
		$retval = mysql_query($cmd);
		$table="<script type=\"text/javascript\">". PHP_EOL;
		$table.="var txt=\"\";". PHP_EOL;
		$drop = "<script type=\"text/javascript\">". PHP_EOL;
		$drop .= "var drop=\"\";". PHP_EOL;
		while($row = mysql_fetch_array($retval)){
			$drop .= 'drop+="<option value='.$row['tickerSymbol'].'>'.$row['tickerSymbol'].'</option>"'. PHP_EOL;
			$table .= 'txt+="<tr>";'. PHP_EOL;
		//	$table .= 'txt+="<td> <input class=\"rad\" type=\"radio\" name=\"ticker\" value=\"'.$row['tickerSymbol'].'\"></td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['tickerSymbol'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['companyName'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['currentPrice'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['openingPrice'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['closingPrice'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['earningsPerShare'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dayLow'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dayHigh'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['52weekLow'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['52weekHigh'].'</td>";'. PHP_EOL;
			$table .= 'txt+="<td>'.$row['dividendRate'].'</td>";'. PHP_EOL;
			$table .= 'txt+="</tr>";'. PHP_EOL;
		}
		mysql_close($db_conn);
		$table .="document.getElementById(\"compare_table_body\").innerHTML=txt;". PHP_EOL;
		$table .="</script>". PHP_EOL;
		$drop .="document.getElementById(\"selectItems\").innerHTML=drop;". PHP_EOL;
		$drop .="</script>". PHP_EOL;
		echo $table;
		echo $drop;
	}
	
	function createClientPortfolio($sym, $num, $tType){
		$db_conn = mysql_connect("localhost", "root", "");
		if (!$db_conn)
			die("Unable to connect: " . mysql_error());
		mysql_select_db("stockTrader", $db_conn);
		$cmd = "SELECT * FROM companyProfile WHERE tickerSymbol='".$sym."'";
		$retval = mysql_query($cmd);
		$row = mysql_fetch_array($retval);
		$name = $row['companyName'];
		$price = $row['currentPrice'];
		$div = $row['dividendRate'];
		if($tType=="S"){
			$cmd = "SELECT * FROM clientPortfolio WHERE tickerSymbol='".$sym."'";
			$retval = mysql_query($cmd);
			$row = mysql_fetch_array($retval);
			if($row==false){
				$warn="<script type=\"text/javascript\">". PHP_EOL;
				$warn.="alert(\"You do not own any shares in $name.\")". PHP_EOL;
				$warn .="</script>". PHP_EOL;
				echo $warn;
			}
			else{
				$bought = $row['numShares'];
				if($bought<$num){
					$warn="<script type=\"text/javascript\">". PHP_EOL;
					$warn.="alert(\"You do not own enough shares in $name to sell.\")". PHP_EOL;
					$warn .="</script>". PHP_EOL;
					echo $warn;
				}
				else{
					$bought = $bought - $num;
					$cmd = "INSERT INTO clientPortfolio(tickerSymbol, companyName, numShares, typeTransaction, pricePerShare, dividendRate) VALUES ('".$sym."', '".$name."', ".$num.", '".$tType."', ".$price.", ".$div.")";
					mysql_query($cmd);
				//	$cmd = "UPDATE clientPortfolio SET numShares=".$bought." WHERE tickerSymbol='".$sym."'";
				//	var_dump($bought);
				//	var_dump(mysql_query($cmd));
					mysql_close($db_conn);
				}
			}
		}
		else{
			$cmd = "INSERT INTO clientPortfolio(tickerSymbol, companyName, numShares, typeTransaction, pricePerShare, dividendRate) VALUES ('".$sym."', '".$name."', ".$num.", '".$tType."', ".$price.", ".$div.")";
			mysql_query($cmd);
			mysql_close($db_conn);
		}
	}
	if(isset($_GET["symbol"])){
		$symbols = $_GET["symbol"];
		createDB();
		createCompareTable($symbols);
		writeCompareTable();
	}
	
	else if(isset($_GET["execute"])){
		writeCompareTable();
		$sym = $_GET['ticker'];
		$num = $_GET['amount'];
		$typ = $_GET['tranType'];
		createClientPortfolio($sym, $num, $typ);
	}
	else{
		$warn="<script type=\"text/javascript\">". PHP_EOL;
		$warn.="alert(\"You have not selected any stocks to compare.\")". PHP_EOL;
		$warn .="</script>". PHP_EOL;
		echo $warn;
	}
	
?>
<script type="text/javascript">
	function checkNumber(){
		var a = document.forms["f1"]["amount"].value;
		if(a==0){
			return false;
		}
		else{
			return true;
		}
	}
	function checkRadio(){
		var chx = document.getElementsByTagName('input');
		for (var i=0; i<chx.length; i++) {
			if (chx[i].type == 'radio' && chx[i].checked) {
				return true;
			} 
		}
		return false;
	}
	function checkFields(){
		var a = checkNumber();
		var b = checkRadio();
		if(a&&b){
			return true;
		}
		else{
			alert("Please make sure all fields are checked!");
			return false;
		}
	}
	
	
</script>
</html>