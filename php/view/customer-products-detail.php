<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= str_replace("index.php/", "static/css/style.css", BASE_URL) ?>" />
        <title>Spletna trgovina  EP</title>
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
                                <li><a href="<?= BASE_URL."orders" ?>">Naročila</a></li>
                                <li class="active"><a href="<?= BASE_URL. "customer"?>">Izdelki</a></li>
                              </ul>
                            </div> 
                            <div class="col-lg-4 col-md-4 col-sm-4">
                              <ul class="nav navbar-nav">
                                <?php if(isset($_SESSION["CART"])):?>
                                    <li class="cart"><a href="<?= BASE_URL."customer/cart"?>">Košarica</a></li>
                                <?php else: ?>
                                    <li><a href="<?= BASE_URL."customer/cart"?>">Košarica</a></li>
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
                                            <b><span class="pozdrav">Izdelek <?= $product["naziv"] ?></span></b>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1">
                                        <a href="<?= BASE_URL?>" type="button" class="btn btn-info btn-sm" id="back">Nazaj</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p class="text-left"><?= $product["opis"]?></p>
                                            <hr>
                                            <div class="col-md-12">
                                                <div class="col-md-2">
                                                    <form action="<?= BASE_URL."customer/product/detail?id=".$product["id"]?>" method="POST">
                                                        <input type="hidden" name="do" value="add_into_cart" />
                                                        <input type="hidden" name="id" value="<?= $product["id"] ?>" />
                                                        <input type="submit" class="btn btn-danger btn-sm btn-block" value="Dodaj v košarico" />
                                                    </form>
                                                </div>
                                                <div class="col-md-10">
                                                    <p class="text-right" style="font-size: 20px">Cena: <?= number_format($product["cena"],2, ',', '.')?> €</p>
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
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="glava">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                            <b><span class="pozdrav">Slike</span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                <?php 
                                                    $i = 1;
                                                    foreach ($images as $image): 
                                                    $url = BASE_URL. "product/detail?id=".$product["id"];?>
                                                        <?php if($i % 3 == 1):?>
                                                            <div class="row">
                                                        <?php endif; ?>
                                                            <div class="col-md-4 portfolio-gallery">
                                                                <?php echo '<img class="img-responsive" src="data:image;base64,'.$image["slika"].'" >';?>
                                                            </div>
                                                        <?php if($i % 3 == 0):?>
                                                            </div>
                                                        <?php endif; ?>
                                                <?php
                                                    $i += 1;
                                                    endforeach; ?>
                                                        <?php if($i % 3 != 1):?>
                                                            </div>
                                                        <?php endif; ?>
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
