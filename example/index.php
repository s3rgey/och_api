<?php
spl_autoload_register(function ($class_name)
{
    include 'include/class/'.$class_name.'.php';
});
$vk = new vk();

//==========================//
$apiKey = ''; // Ваш API ключ
//==========================//

$servers = json_decode(file_get_contents('http://gs-dev.ru/och/api/server_info.php?key=' . $apiKey));
$owner = json_decode(file_get_contents('http://gs-dev.ru/och/api/owner_info.php?key=' . $apiKey));
$searchUser = $vk->request("users.get", ["user_ids" => $owner->vk_id, "fields" => "photo_100"]);
$firstName = $searchUser[0]['first_name'];
$lastName = $searchUser[0]['last_name'];
$photo_100 = $searchUser[0]['photo_100'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="gs-dev">
    <title>OCH | API example</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/mdb.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body style="background-color: #15171c;">
<header class="h-100">
  <div class="container mt-4">
    <h4 class="text-white font-weight-bold text-center m-0">Наши сервера</h4>
    <div class="mt-4 col d-flex" style="overflow-x: auto">
        <?
        for($i = 0; $i < count($servers); $i++):
            $procent = $servers[$i]->Players / $servers[$i]->MaxPlayers * 100;
            if($procent < 25) $bg = 'bg-danger';
            else if($procent >= 25 && $procent < 50) $bg = 'bg-warning';
            else if($procent >= 50 && $procent < 75) $bg = 'bg-info';
            else $bg = 'bg-success';
            ?>
          <div class="col-lg-3 p-0 shadow mr-2 ml-2 mb-4 rounded-top" style="box-shadow: none;background-image: url('http://gs-dev.ru/och/img/maps/<?=$servers[$i]->Map?>.jpg');-webkit-background-size: cover; background-size: cover;">
            <div class="h-100 w-100 d-flex align-items-end" style="background-color: rgba(0,0,0, .3)">
              <div class="col">
                <a href="#Players<?=$i?>" data-toggle="modal" class="white-text m-0">Онлайн <?=$servers[$i]->Players?> из <?=$servers[$i]->MaxPlayers?></a>
                <p class="font-weight-bold white-text m-0"><?=$servers[$i]->HostName?></p>
                <p class="font-weight-bold white-text">IP адрес <?=$servers[$i]->IP?></p>
              </div>
            </div>
            <div class="progress rounded-bottom" style="background-color: #1f2227;">
              <div class="progress-bar <?=$bg?> progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="<?=$servers[$i]->Players?>" aria-valuemin="0" aria-valuemax="<?=$servers[$i]->MaxPlayers?>" style="width: <?=$procent?>%"><?=floor($procent)?>%</div>
            </div>
          </div>

          <div class="modal fade" id="Players<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel<?=$i?>"
               aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header" style="background-color: #292c32;border: none">
                  <h5 class="modal-title white-text" id="exampleModalLabel<?=$i?>">Игроки сервера <?=$servers[$i]->HostName?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body p-0" style="background-color: #1f2227">
                  <table class="table table-striped table-dark table-bordered">
                    <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Frags</th>
                      <th scope="col">Time</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?for($j = 0; $j < count($servers[$i]->PlayersList); $j++):?>
                    <tr>
                      <th scope="row"><?=$servers[$i]->PlayersList[$j]->id?></th>
                      <td><?=$servers[$i]->PlayersList[$j]->Name?></td>
                      <td><?=$servers[$i]->PlayersList[$j]->Frags?></td>
                      <td><?=$servers[$i]->PlayersList[$j]->TimeF?></td>
                    </tr>
                    <?endfor;?>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer" style="background-color: #1f2227;border: none">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
              </div>
            </div>
          </div>
        <?endfor;?>
    </div>
  </div>
  <div class="container d-flex">
    <div class="col-lg-3">
      <div class="col shadow d-flex align-items-center justify-content-center rounded mt-4" style="background-color: #1f2227">
        <div class="w-100">
          <div class="row d-flex align-items-center justify-content-center mt-3">
            <h6 class="text-white text-center m-0">Главный администратор</h6>
          </div>
          <hr>
          <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-3 p-0 mr-3">
              <img src="<?=$photo_100?>" alt="" style="width: 100%;border-radius: 50%">
            </div>
            <h6 class="text-white m-0 font-weight-bold"><?=$firstName . ' ' . $lastName?></h6>
          </div>
          <div class="row d-flex align-items-center justify-content-center mt-3">
            <form action="https://vk.com/write<?=$owner->vk_id?>" class="w-100 d-flex justify-content-center">
              <button type="submit" formtarget="_blank" class="btn text-white w-100 m-0 rounded-bottom" style="background-color: #292c32;">Написать в вк</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col shadow d-flex align-items-center justify-content-center rounded mt-4" style="background-color: #1f2227">
        <div class="w-100">
          <div class="row d-flex align-items-center justify-content-center mt-3">
            <h6 class="text-white text-center m-0">Группа во ВКонтакте</h6>
          </div>
          <hr>
          <div class="row d-flex align-items-center justify-content-center">
            <div id="vk_groups" style="border-radius: 12px;width: 100%"></div>
            <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups", {mode: 3, wide: 1, no_cover: 1, width: "auto", height: "400px", color1: '1f2227', color2: 'FFFFFF', color3: '7A63CC'}, <?=$owner->group_bot?>);
            </script>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="col shadow d-flex align-items-center justify-content-center rounded mt-4" style="background-color: #1f2227">
        <div class="w-100">
          <div class="row d-flex align-items-center justify-content-center mt-3">
            <h5 class="text-white font-weight-bold text-center m-0">Новости проекта</h5>
          </div>
          <hr>
          <div class="row d-flex align-items-center justify-content-center">
            <div id="vk_groups2" style="border-radius: 12px;width: 100%"></div>
            <script type="text/javascript" src="https://vk.com/js/api/openapi.js?168"></script>
            <script type="text/javascript">
                VK.Widgets.Group("vk_groups2", {mode: 4, wide: 1, no_cover: 1, width: "auto", height: "900", color1: '1f2227', color2: 'FFFFFF', color3: '7A63CC'}, <?=$owner->group_bot?>);
            </script>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<footer>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>