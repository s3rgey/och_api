<?php
$apiKey = 'ZaCL6KNWHnbHiTyIvHKPoC3vi'; // Ваш API ключ
$servers = json_decode(file_get_contents('http://gs-dev.ru/och/api/server_info.php?key=' . $apiKey));
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

    <link href="/och/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/mdb.min.css">

</head>
<body>
<?for($i = 0; $i < count($servers); $i++):?>
<div class="d-flex justify-content-center mt-4">
    <div class="container">
        <div class="row shadow d-flex w-100 rounded">
            <div class="col d-flex justify-content-center">
                <h3>
                    Сервер <?=$servers[$i]->HostName?><br>
                    Карта <?=$servers[$i]->Map?><br>
                    Игроки <?=$servers[$i]->Players . '/' . $servers[$i]->MaxPlayers?>
                </h3>
            </div>
            <div class="col">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Frags</th>
                        <th scope="col">TimeF</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?for($j = 0; $j < count($servers[$i]->PlayersList); $j++):?>
                    <tr>
                        <th scope="row"><?=$j + 1?></th>
                        <td><?=$servers[$i]->PlayersList[$j]->Name?></td>
                        <td><?=$servers[$i]->PlayersList[$j]->Frags?></td>
                        <td><?=$servers[$i]->PlayersList[$j]->TimeF?></td>
                    </tr>
                    <?endfor;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?endfor;?>
</body>
</html>