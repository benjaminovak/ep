<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= str_replace("index.php/", "/static/css/style.css", BASE_URL) ?>" />
        <title>Admin</title>
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
                            <div class="col-lg-11 col-md-11 col-sm-11">
                              <ul class="nav navbar-nav">
                                <li class="active"><a href="<?= BASE_URL."admin/users" ?>">Uporabniki</a></li>
                                <li><a href="<?= BASE_URL."admin/profil" ?>">Profil</a></li>
                              </ul>
                            </div> 
                            <div class="col-lg-1 col-md-1 col-sm-1">
                              <ul class="nav navbar-nav">
                                <li><a href="<?= BASE_URL."admin/logout" ?>">Odjava</a></li>
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
                                            <b><span class="pozdrav">Seznam uporabnikov</span></b>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <a href="<?= BASE_URL."admin/users/add" ?>"><button type="button" class="btn btn-default">Dodaj uporabnika</button></a>
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
                                                    <th>Ime</th>
                                                    <th>Priimek</th>
                                                    <th>Email</th>
                                                    <th>Uporabniško ime</th>
                                                    <th>Aktiven</th>
                                                    <th></th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <th><?=$user["ime"]?></th>
                                                        <th><?=$user["priimek"]?></th>
                                                        <th><?=$user["mail"]?></th>
                                                        <th><?=$user["uporabnisko_ime"]?></th>
                                                        <th><?=$user["aktiven"]?></th>
                                                        <th><a href="<?= BASE_URL. "admin/users/edit?id=" .$user["id"] ?>"><button type="button" class="btn btn-default">Spremeni</button></a></th>
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
