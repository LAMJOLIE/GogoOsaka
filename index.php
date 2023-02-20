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
    // var_dump($result["result"]);
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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./index.css">
    <title>GoGo osaka</title>
</head>

<body>

<?php include('./Navbar/navbar.php'); ?>

<!-- Front Page starts -->
<section class="Front-Page"></section>
<!-- Front Page ends -->

<section class="place" id="place">
    <div class="place-title">
        <h2>おすすめスポット</h2>
        <p>誰もが認める大阪の観光スポットといえば...</p>
    </div>
    
   <div class="place-content">
         <?php foreach($result["result"] as $info) : ?>
            <div class="row">
                <img src="./photo/<?= $info["IMAGE"] ?>.jpeg">
                <div class="layer">
                    <p><a href="./Detail.php?spot_id=<?= $info["SPOT_ID"] ?>"><?= $info["SPNAME"] ?></a></p>
                </div>
            </div>
        <?php endforeach;?>
   </div>

</section>

<section class="LetsGo" id="LetsGo">

    <div class="LetsGo-title">
        <h2>次に行くスポットは...</h2>
    </div>

    <!-- <button id="flashButton" class="flash-button" onclick="togglePopup()">LET's GO!</button> -->
    <button id="flashButton" class="flash-button">LET's GO!</button>

    <div class="full-screen hidden flex-container-center" id='imageArea'>
        <a href="#" class="close-Popup" onclick="togglePopup()">&times;</a>
        <h3 id="resultMsg">次に行くスポットは...!!</h3>
            
            <?php foreach($result["result"] as $info) : ?>
                <img id="<?= $info["SPOT_ID"] ?>" class="animation-image" src="./photo/<?= $info["IMAGE"] ?>.jpeg">
            <?php endforeach;?>
            
        <!-- <h1 class="place-result">「　万博公園　」です！</h1> -->
        <button id="resultBtn" type="submit" value="Send">スポットの詳細 →</button>
    </div>

</section>




</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="./index.js"></script>
</html>