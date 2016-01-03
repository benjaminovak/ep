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
                                    <li><a href="<?= BASE_URL."users" ?>">Stranke</a></li>
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
                                            <b><span class="pozdrav">Urejanje slik</span></b>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1">
                                        <a href="<?= BASE_URL."products"?>" type="button" class="btn btn-info btn-sm" id="back">Nazaj</a>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="container-fluid">
                                    <div class="row-fluid">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="slika">Slika (manjša od 100 kB):</label>
                                                    <input type="hidden" name="id" value="<?= $izdelek_id ?>" />
                                                    <input type="file" name="image" class="form-control" style="min-height: 50px;"/>
                                                </div>
                                                <input type="submit" name="sumbit" value="Potrdi" class="btn btn-primary btn-sm btn-block"/>
                                            </form>
                                            <hr>
                                            <?php
                                            if(isset($_POST['sumbit'])) {
                                                if(getimagesize($_FILES['image']['tmp_name']) == FALSE){
                                                    echo "Prosim izberi sliko.";
                                                }
                                                else {
                                                    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
                                                    $image1 = addslashes($_FILES['image']['tmp_name']);
                                                    $name = addslashes($_FILES['image']['name']);
                                                    $image2 = file_get_contents($image1);
                                                    $image = base64_encode($image2);
                                                    SalesmanController::imageAdd(["ime" => $name, "slika" => $image, "izdelek_id" => $id]);
                                                }
                                            }?>
                                            <?php 
                                                $i = 1;
                                                foreach ($images as $image):?>
                                                    <?php if($i % 3 == 1):?>
                                                        <div class="row">
                                                    <?php endif; ?>
                                                        <div class="col-md-4">
                                                            <?php echo '<img class="img-responsive" src="data:image;base64,'.$image["slika"].'" >'?>
                                                            <p>Ime: <?= $image["ime"] ?></p> 
                                                            <a href="<?= BASE_URL."products/images/del?id=".$image["id"]."&izdelek_id=".$izdelek_id ?>"  class="btn btn-success btn-sm btn-block">Odstrani sliko</a>
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
