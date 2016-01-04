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
                        <div class="panel panel-default">
                            <div class="panel-heading" id="glava">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <b><span class="pozdrav">Povzetek naročila</span></b>
                                    </div>
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
                                                        <th><p class="text">Naziv</p></th>
                                                        <th><p class="text">Količina</p></th>
                                                        <th><p class="text-right">Skupaj</p></th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php $skupaj = 0; ?>
                                                    <?php foreach ($products as $product): ?>
                                                        <tr>
                                                            <th><p class="text"><?= $product["naziv"]?></p></th>
                                                            <th><p class="text"><?= $product["vseh"] ?></p></th>
                                                            <td><p class="text-right"><?= number_format($product["cena"] * $product["vseh"], 2, ',', '.') ?> €</p></td>
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
                                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-top: 15px">
                                                    <form action="<?= BASE_URL. "customer/checkout/order" ?>" method="POST">
                                                        <input type="hidden" name="do" value="order" />
                                                        <input type="submit" value="Potrdi naročilo" class="btn btn-success btn-sm btn-block"/>
                                                    </form>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6" style="padding-top: 15px">
                                                    <a href="<?= BASE_URL."customer/cart" ?>"  class="btn btn-primary btn-sm btn-block">Prekliči naročilo</a>
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
