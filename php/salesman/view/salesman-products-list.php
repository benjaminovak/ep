<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= str_replace("index.php/", "../static/css/style.css", BASE_URL) ?>" />
        <title>Prodajalec</title>
    </head>
    <body>
        
        <div class="wrapper col-lg-12 col-md-12 col-sm-12">
            <div class="navbar-inner">
                 <div class="container">
                    <img src="<?= str_replace("index.php/", "../static/images/logo.png", BASE_URL) ?>" class="img-rounded" width="100%"/></center>
                 </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <nav class="navbar navbar-default" id="menu">
                          <div class="container-fluid">
                            <div class="col-lg-9 col-md-9 col-sm-9">
                                <ul class="nav navbar-nav">
                                    <li><a href="<?= BASE_URL."orders" ?>">Naročila</a></li>
                                    <li class="active"><a href="<?= BASE_URL."products" ?>">Izdelki</a></li>
                                    <li><a href="<?= BASE_URL."customers" ?>">Stranke</a></li>
                                </ul>                                
                            </div> 
                            <div class="col-lg-3 col-md-3 col-sm-3">
                              <ul class="nav navbar-nav">
                                <li><a href="<?= BASE_URL."profile" ?>">Profil</a></li>
                                <li><a href="<?= BASE_URL."logout" ?>">Odjava</a></li>
                              </ul>
                            </div> 
                          </div>
                                   
                        </nav>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="glava">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                            <b><span class="pozdrav">Seznam izdelkov</span></b>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <a href="<?= BASE_URL."products/add" ?>"><button type="button" class="btn btn-default">Dodaj izdelek</button></a>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Id</th>
                                                    <th>Naziv</th>
                                                    <th>Cena [€]</th>
                                                    <th>Aktiven</th>
                                                    <th></th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($products as $product): ?>
                                                    <tr>
                                                        <th><?=$product["id"]?></th>
                                                        <th><?=$product["naziv"]?></th>
                                                        <th><?=$product["cena"]?></th>
                                                        <th><?=(($product["aktiven"] == "da") ? "da" : "ne")?></th>
                                                        <th>
                                                            <form action="<?= BASE_URL. "products/edit" ?>" method="POST">
                                                                <input type="hidden" name="id" value="<?= $product["id"] ?>" />
                                                                <input type="submit" value="Uredi" class="btn btn-default"/>
                                                            </form>
                                                        </th>
                                                        <th>
                                                            <form action="<?= BASE_URL. "products/images" ?>" method="POST">
                                                                <input type="hidden" name="id" value="<?= $product["id"] ?>" />
                                                                <input type="submit" value="Upravljanje slik" class="btn btn-default"/>
                                                            </form>
                                                        </th>
                                                    </tr>
                                                <?php endforeach; ?>
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
        </div>
    </body>
</html>
