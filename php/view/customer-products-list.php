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
                                            <b><span class="pozdrav">Izdelki</span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                <?php 
                                                    $i = 1;
                                                    foreach ($products as $product): 
                                                    $url = BASE_URL. "customer/product/detail?id=".$product["id"];?>
                                                        <?php if($i % 3 == 1):?>
                                                            <div class="row">
                                                        <?php endif; ?>
                                                            <div class="col-md-4 portfolio-item">
                                                                <a href="<?= $url ?>">
                                                                    <?php if($images[$product["id"]] != null):
                                                                        echo '<img class="img-responsive2" src="data:image;base64,'.$images[$product["id"]]["slika"].'" >'?>
                                                                    <?php else: ?>
                                                                        <img class="img-responsive2" src="http://placehold.it/700x400" alt="">
                                                                    <?php endif; ?>
                                                                </a>
                                                                <h4>
                                                                    <a href="<?= $url ?>"><?= $product["naziv"] ?> </a>
                                                                </h4>
                                                                <p><?= $product["opis"] ?></p>
                                                                <hr>
                                                                <div class="col-md-12">
                                                                    <div class="col-md-6">
                                                                        <p style="font-size: 18px;">Cena: <?= $product["cena"] ?> €</p> 
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <form action="<?= BASE_URL."customer" ?>" method="POST">
                                                                            <input type="hidden" name="do" value="add_into_cart" />
                                                                            <input type="hidden" name="id" value="<?= $product["id"] ?>" />
                                                                            <input type="submit" class="btn btn-danger btn-sm btn-block" value="Dodaj v košarico" />
                                                                        </form>
                                                                    </div>
                                                                </div>
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
