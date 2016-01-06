<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= str_replace("index.php/", "static/css/style.css", BASE_URL) ?>" />
        <title>Stranka</title>
    </head>
    <body>
        
        <div class="wrapper col-lg-12 col-md-12 col-sm-12">
            <div class="navbar-inner">
                 <div class="container">
                    <img src="<?= str_replace("index.php/", "static/images/logo.png", BASE_URL) ?>" class="img-rounded" width="100%"/></center>
                 </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <nav class="navbar navbar-default" id="menu">
                          <div class="container-fluid">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                              <ul class="nav navbar-nav">
                                <li><a>Naročila:</a></li>
                                <li><a href="<?= BASE_URL."orders" ?>">Oddana</a></li>
                                <li class="active"><a href="<?= BASE_URL."orders/proven?sort=id" ?>">Potrjena</a></li>
                                <li><a href="<?= BASE_URL."orders/canceled" ?>">Stornirana</a></li>
                                <li><a href="<?= BASE_URL. "customer"?>">Izdelki</a></li>
                              </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4"> 
                              <ul class="nav navbar-nav">
                                <?php if(isset($_SESSION["CART"])):?>
                                    <li class="cart"><a href="<?= BASE_URL."customer/cart"  ?>">Košarica</a></li>
                                <?php else: ?>
                                    <li><a href="<?= BASE_URL."customer/cart"  ?>">Košarica</a></li>
                                <?php endif; ?>
                                <li><a href="<?= BASE_URL."customer/profil" ?>">Moj račun</a></li>
                                <li><a href="<?= BASE_URL."customer/logout" ?>">Odjava</a></li>
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
                                            <b><span class="pozdrav">Seznam potrjenih naročil</span></b>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <?php if(!empty($orders)):?>
                                            <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th><a href="<?= BASE_URL. "orders/proven?sort=id" ?>" class="btn btn-link">Id</a></th>
                                                    <th><a href="<?= BASE_URL. "orders/proven?sort=datum" ?>" class="btn btn-link">Datum</a></th>
                                                    <th></th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($orders as $order): ?>
                                                        <tr>
                                                            <th><?=$order["id"]?></th>
                                                            <th><?=$order["datum"]?></th>
                                                            <th>
                                                                <form action="<?= BASE_URL. "orders/proven/detail" ?>" method="POST">
                                                                    <input type="hidden" name="id" value="<?= $order["id"] ?>" />
                                                                    <input type="submit" value="Podrobnosti" class="btn btn-default"/>
                                                                </form>
                                                            </th>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <?php else:
                                                echo "Ni potrjenih naročil.";
                                            endif;?>    
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
