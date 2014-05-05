<html lang = "en">
<body>
	<div>
		<form action="compare.php" onSubmit="return checkBoxes();" method="get">
			<table>
				<thead>
				  <tr>
					<th> Compare </th>
					<th>Ticker Symbol</th>
					<th>Company Name</th>
					<th>Sector</th>
					<th>Stock Price</th>
				  </tr>
				</thead>
				<tbody id="stock_table_body">
				</tbody>
			</table>
			<input type="submit" name="compare" value="Compare" class="btn btn-default"/>
		</form>
    </div>
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
			$table .= 'txt+="<td> <input class=\"cheBox\" type=\"checkbox\" name=\"symbol[]\" id=\"symbol\" value='.$row['tickerSymbol'].",".$row['currentPrice'].' onclick=\"populateChecks()\"></td>";'. PHP_EOL;
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
			$table .= 'txt+="<td> <input class=\"cheBox\" type=\"checkbox\" name=\"symbol[]\" id=\"symbol\" value='.$row['tickerSymbol'].",".$row['currentPrice'].' onclick=\"populateChecks()\"></td>";'. PHP_EOL;
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

	function createClientPortfolio(){
	}
	createDB();
	//getPrice();
	populateTable();
	if(isset($_GET["button"])){
		$att = $_GET["button"];
		sorting($att);
	}
	$symbols =array("BAC", "FB", "NOK", "BSBR", "SIRI");
	createCompareTable($symbols);
	
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