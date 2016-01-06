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
                                <li><a href="<?= BASE_URL."orders/proven?sort=id" ?>">Potrjena</a></li>
                                <li class="active"><a href="<?= BASE_URL."orders/canceled" ?>">Stornirana</a></li>
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
                                            <b><span class="pozdrav">Podrobnosti naročila <?=$order["id"]?></span></b>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1">
                                        <a href="<?= BASE_URL."orders/canceled"?>" type="button" class="btn btn-info btn-sm" id="back">Nazaj</a>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <h4>Naročilo</h4><br/>
                                                <b>Id: </b><?=$order["id"]?><br/>
                                                <b>Datum: </b><?=$order["datum"]?><br/>
                                                <b>Obdelano: </b><?=$order["obdelano"]?><br/>
                                                <b>Status: </b>
                                                    <?php if($order["potrjeno"] == "ne"){
                                                        echo "Stornirano";                                                       
                                                    }?>
                                                <br/>
                                            </div> 
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <h4>Naročnik</h4><br/>
                                                <b>Id: </b><?=$user["id"]?><br/>
                                                <b>Ime in priimek: </b><?=$user["ime"]?> <?=$user["priimek"]?><br/>
                                                <b>Mail: </b><?=$user["mail"]?><br/>
                                            </div>  
                                            <div class="col-lg-12 col-md-12 col-sm-12" id="products">
                                                <?php 
                                                if(count($products) > 0):
                                                ?>
                                                <table class="table table-hover">
                                                    <thead>
                                                      <tr>
                                                        <th>Id</th>
                                                        <th>Naziv</th>
                                                        <th>Količina</th>
                                                        <th>Cena</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($products as $product): ?>
                                                        <tr>
                                                            <th><?=$product["izdelek_id"]?></th>
                                                            <th><?=$product["naziv"]?></th>
                                                            <th><?=$product["kolicina"]?></th>
                                                            <th><?=$product["cena"]?></th>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                 </tbody>
                                                </table>
                                                <?php endif;?>
                                            </div>
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
