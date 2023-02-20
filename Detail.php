<?php
$spot_id = filter_input(INPUT_GET,"spot_id");

$dsn = "mysql:host=localhost;dbname=se_c_root;charset=utf8mb4";

if($_SERVER["REQUEST_METHOD"] !== "GET") {
    header("Location: index.php");
    exit;
}
$result = [
    "status"  => true,
    "message" => "",
    "result"  => null,
];
try {
    $db = new PDO($dsn, "se_c_root", "29_Man");
    $db -> setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $sql = "SELECT * FROM SPOT";
    $where = "";

    if(isset($spot_id)) {
        $where = " WHERE SPOT_ID = :spot_id";
    }

    $stmt = $db -> prepare($sql.$where);

    if($spot_id){
        $stmt -> bindParam(":spot_id",$spot_id,PDO::PARAM_STR);
    }

    // echo "SQL文：{$sql}{$where}";

    $stmt -> execute();

    // $result["result"][] = [];

    while($rows = $stmt -> fetch(PDO::FETCH_ASSOC)){
        $result["result"][] = $rows;
    }
}catch(PDOException $poe) {
    exit("DBエラー".$poe -> getMessage());
}finally {
    $stmt = null;
    $db = null;
}
?>

<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewpoint" content="width=device-width,initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" contnt="IE=edge" />
        <link rel="stylesheet" href="./navbar.css">
        <link rel="stylesheet" href="./Detail.css">
        <title>GoGo osaka</title>
    </head>

    <body>
        <!--Navbar starts -->
        <header>
            <a href="#" class="logo">GOGO OSAKA</a>

            <ul>
                <li><a href="./index.php">HOME</a></li>
                <li><a href="./index.php#place">PLACES</a></li>
                <li><a href="./index.php#LetsGo">LET'S GO!</a></li>
            </ul>

        </header>
        <!--Navbar ends -->

        <section class="detail">
                    <?php if(isset($result["result"])) : ?>
                        <?php foreach($result["result"] as $info): ?>
                            
                            <!-- 写真 -->
                            <div class="pic">
                            <img src ="../OSAKA/photo/<?=$info["IMAGE"];?>.jpeg">
                            </div>

                            <!-- INTRO -->
                            <div class="intro">
                            <h3><?= $info["INTRO"] ?></h3>
                            </div>

                            <div class="detail-container">
                            <!-- INFORMATION Starts-->
                            <div class="form-detail">
                            
                                <div class="from-group">
                                    <label class="label">名称</label>
                                    <p class="info"><?= $info["SPNAME"] ?></p><br>
                                </div>

                                <div class="from-group">
                                    <label class="label">住所</label>
                                    <p class="info"><?= $info["ADDRESS"] ?></p><br>
                                </div>

                                <div class="from-group">
                                    <label class="label">営業時間</label>
                                    <p class="info"><?= $info["OPEN_TIME"] ?></p><br>
                                </div>

                                <div class="from-group">
                                    <label class="label">アクセス</label>
                                    <p class="info"><?= $info["ACCESS"] ?></p><br>
                                </div>

                                <div class="from-group">
                                    <label class="label">料金</label>
                                    <p class="info"><?= $info["PRICE"] ?></p><br>
                                </div>

                                <div class="from-group">
                                    <label class="label">連絡先</label>
                                    <p><a href="tel:<?= $info["TEL"] ?>"><?= $info["TEL"] ?></p><br>
                                </div>

                                <div class="from-group">
                                    <label class="label">ホームページ</label>
                                    <p  class="info"><a href="<?= $info["PAGE"] ?>" target="_blank"><?= $info["PAGE"] ?></a></p>
                                </div>
                                </ul>
                            </div>
                            <!-- INFORMATION Ends-->

                            <!-- Map Starts -->
                            <div class="map">
                            <?= $info["MAP"] ?>

                            </div>

                            <!-- Map Ends -->

                        <?php endforeach; ?>
                    <?php endif ?>

            </,div>
        </section>
    </body>
    <script src="./index.js"></script>
</html>
