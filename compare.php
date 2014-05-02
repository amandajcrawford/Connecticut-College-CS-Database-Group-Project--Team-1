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
  <script src="bootstrap-3.1.1-dist/js/respond.min.js"></script>

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
            <a href="main.html">Main</a>
          </li>
          <li class="active">
            <a href="">Compare</a>
          </li>
          <li>
            <a href="myPortfolio.html">My Portfolio</a>
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
                <th>Compare</th>
                <th>Ticker Symbol</th>
                <th>Company Name</th>
                <th>Opening Price</th>
                <th>Stock Price</th>
                <th>Total Market Share</th>
                <th>ESP</th>
                <th>Day's Low</th>
                <th>Day's High</th>
                <th>52-wk low</th>
                <th>52-wk high</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <input type="checkbox">
                </td>
                <td>1,001</td>
                <td>Lorem</td>
                <td>ipsum</td>
                <td>dolor</td>
                <td>sit</td>
              </tr>
              <tr>
                <td>1,002</td>
                <td>amet</td>
                <td>consectetur</td>
                <td>adipiscing</td>
                <td>elit</td>
              </tr>
              <tr>
                <td>1,003</td>
                <td>Integer</td>
                <td>nec</td>
                <td>odio</td>
                <td>Praesent</td>
              </tr>
              <tr>
                <td>1,003</td>
                <td>libero</td>
                <td>Sed</td>
                <td>cursus</td>
                <td>ante</td>
              </tr>
              <tr>
                <td>1,004</td>
                <td>dapibus</td>
                <td>diam</td>
                <td>Sed</td>
                <td>nisi</td>
              </tr>
              <tr>
                <td>1,005</td>
                <td>Nulla</td>
                <td>quis</td>
                <td>sem</td>
                <td>at</td>
              </tr>
              <tr>
                <td>1,006</td>
                <td>nibh</td>
                <td>elementum</td>
                <td>imperdiet</td>
                <td>Duis</td>
              </tr>
              <tr>
                <td>1,007</td>
                <td>sagittis</td>
                <td>ipsum</td>
                <td>Praesent</td>
                <td>mauris</td>
              </tr>
              <tr>
                <td>1,008</td>
                <td>Fusce</td>
                <td>nec</td>
                <td>tellus</td>
                <td>sed</td>
              </tr>
              <tr>
                <td>1,009</td>
                <td>augue</td>
                <td>semper</td>
                <td>porta</td>
                <td>Mauris</td>
              </tr>
              <tr>
                <td>1,010</td>
                <td>massa</td>
                <td>Vestibulum</td>
                <td>lacinia</td>
                <td>arcu</td>
              </tr>
              <tr>
                <td>1,011</td>
                <td>eget</td>
                <td>nulla</td>
                <td>Class</td>
                <td>aptent</td>
              </tr>
              <tr>
                <td>1,012</td>
                <td>taciti</td>
                <td>sociosqu</td>
                <td>ad</td>
                <td>litora</td>
              </tr>
              <tr>
                <td>1,013</td>
                <td>torquent</td>
                <td>per</td>
                <td>conubia</td>
                <td>nostra</td>
              </tr>
              <tr>
                <td>1,014</td>
                <td>per</td>
                <td>inceptos</td>
                <td>himenaeos</td>
                <td>Curabitur</td>
              </tr>
              <tr>
                <td>1,015</td>
                <td>sodales</td>
                <td>ligula</td>
                <td>in</td>
                <td>libero</td>
              </tr>
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
          <div class="col-md-3 col-sm-3 col-xs-3">
            <div class="btn-group" id="add_delete">
              <button type="button" class="btn btn-default" id="remove">Remove Selected</button>
              <button type="button" class="btn btn-default" id="add">Add New Stock</button>
            </div>
          </div>
          <div class="col-md-8 col-md-8 col-sm-8">
            <div class="btn" id="add_delete">
              <input type="text" class="btn btn-default" id="ticker_symbol">
              <input type="text" class="btn btn-default" id="num_shares">
              <input type="checkbox" class="btn" id="purchase">Purchase
              <input type="checkbox" class="btn" id="sell">Sell
              <button type="submit" class="btn disabled" id="submit_transaction">Execute Transaction</button>
            </div>
          </div>

        </div>
        <div class=" row">
          <div class="col-md-4 col-sm-4 col-xs-4">
            <h3 class="divider">
              <a href="">Recently Compared</a>
            </h3>
            <div class="panel panel-default">
              <div class="table-responsive">
                <table class="table-striped" id="rec_comp_table">
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
          <div class=" col-md-4  col-sm-4 col-xs-4">
            <h3 class="divider">
              <a href="">Recently Purchased</a>
            </h3>
            <div class="panel panel-default">
              <div class="table-responsive">
                <table class="table-striped" id="rec_purch_table">
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
          <div class="col-sm-4 col-md-4 col-xs-4 ">
            <h3 class="divider">
              <a href="">Recently Sold</a>
            </h3>
            <div class="panel panel-default">
              <div class="table-responsive">
                <table class="table-striped" id="rec_sold_table">
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

</html>