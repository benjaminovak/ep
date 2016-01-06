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
                                <li><a href="<?= BASE_URL. "customer"?>">Izdelki</a></li>
                              </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4"> 
                              <ul class="nav navbar-nav">
                                <?php if(isset($_SESSION["CART"])):?>
                                    <li class="cart"><a href="<?= BASE_URL."customer/cart"  ?>">Košarica</a></li>
                                <?php else: ?>
                                    <li class="active"><a href="<?= BASE_URL."customer/cart"  ?>">Košarica</a></li>
                                <?php endif; ?>
                                <li><a href="<?= BASE_URL."customer/profil"?>">Moj račun</a></li>
                                <li><a href="<?= BASE_URL."customer/logout"?>">Odjava</a></li>
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
                                        <b><span class="pozdrav">Nakupovalna košarica</span></b>
                                    </div>
                                    <?php if(isset($_SESSION["CART"])):?>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1">
                                        <form action="<?= BASE_URL. "customer/cart/delete" ?>" method="POST">
                                            <input type="hidden" name="do" value="delete_cart" />
                                            <input type="submit" value="Zbriši" class="btn btn-default"/>
                                        </form>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <?php if(isset($_SESSION["CART"])):?>
                                                <table class="table table-hover">
                                                    <thead>
                                                      <tr>
                                                        <th>Naziv</th>
                                                        <th>Cena[€]</th>
                                                        <th>Količina</th>
                                                        <th>Skupaj</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $skupaj = 0; ?>
                                                    <?php foreach ($products as $product): ?>
                                                        <tr>
                                                            <th><?=$product["naziv"]?></th>
                                                            <th><?=$product["cena"]?></th>
                                                            <th>
                                                                <form action="<?= BASE_URL. "customer/cart/edit" ?>" method="POST">
                                                                    <input type="hidden" name="do" value="update_cart" />
                                                                    <input type="hidden" name="id" value="<?= $product["id"] ?>" />
                                                                    <input type="text" name="kolicina" value="<?= $product["vseh"] ?>" size="1" />
                                                                    <input type="submit" value="Posodobi" class="btn btn-default"/>
                                                                </form>
                                                            </th>
                                                            <td><?= number_format($product["cena"] * $product["vseh"], 2, ',', '.') ?> €</td>
                                                        </tr>
                                                    <?php $skupaj += $product["cena"] * $product["vseh"]; ?>    
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>  
                                                <br/>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p class="text-left">Skupaj brez DDV</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p class="text-right"><?= number_format($skupaj*0.82, 2, ',', '.') ?> €</p>
                                                    </div>
                                                    <br/>
                                                    <hr>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p class="text-left" style="font-size: 12px">DDV</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p class="text-right" style="font-size: 12px"><?= number_format($skupaj*0.18, 2, ',', '.') ?> €</p>
                                                    </div>
                                                    <br/>
                                                    <hr>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p class="text-left">Skupaj</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p class="text-right"><b><?= number_format($skupaj, 2, ',', '.') ?> €</b></p>
                                                    </div>                                               
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-top: 15px"></div>
                                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-top: 15px">
                                                    <form action="<?= BASE_URL. "customer/checkout" ?>" method="POST">
                                                        <input type="hidden" name="do" value="checkout" />
                                                        <input type="submit" value="Na blagajno" class="btn btn-primary btn-sm btn-block"/>
                                                    </form>
                                                </div>
                                            <?php else: 
                                                echo "Vaša košarica je prazna.";
                                                endif; ?>
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
