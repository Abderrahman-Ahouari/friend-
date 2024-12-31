<?php

require "../src/classes/member_classe.php";
autandificationC();

$reservation = new Reservation();
$client = new Members();
$client->setEmail($_SESSION['email']);
$client->insert();
$stmtActivite = $client->listActivite();
if (isset($_POST['conservation']) && isset($_POST['activite'])) { 
    $activite =  new Activites();
    $activite->set_id_activite($_POST['activite']);
$client->reservez($activite);
}
if(isset($_POST['logout'])){
    $client->logout();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<header class="lg:px-16 px-4 bg-white flex flex-wrap items-center py-4 shadow-md">
    <div class="flex-1 flex justify-between items-center">
        <a href="home_user.php" class="text-xl">home</a>
    </div>

    <label for="menu-toggle" class="pointer-cursor md:hidden block">
      <svg class="fill-current text-gray-900"
        xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
        <title>menu</title>
        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
      </svg>
    </label>
    <input class="hidden" type="checkbox" id="menu-toggle" />

    <div class="hidden md:flex md:items-center md:w-auto w-full" id="menu">
        <nav>
            <ul class="md:flex items-center justify-between text-base text-gray-700 pt-4 md:pt-0">
                <li><a class="md:p-4 py-3 px-0 block" href="take_reservation.php">Add reservation</a></li>
                <li><a class="md:p-4 py-3 px-0 block" href="user_dashboard.php">Dashboard</a></li>
                <li> <form action=""  method="POST">
                    <input type="submit" name="logout" value="logout"/>
                </form>
            </li>
            </ul>
        </nav>
    </div>
</header>



    <section class="">
        <div class="flex flex-wrap">
    <div class="w-full sm:w-8/12 mb-10">
      <div class="container mx-auto h-full sm:p-10">
        <nav class="flex px-4 justify-between items-center">
          
          
        </nav>
        <div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase">
        reservation un actinite
    </div>
    <form class="py-4 px-6" action="" method="POST">
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="activite">
                activite
            </label>
            <select   
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="activite" name="activite">
                <option value="">Select a service</option>
                <?php 
                while($row=$stmtActivite->fetch(PDO::FETCH_ASSOC)){
                    echo '<option value="' . $row['id_activite'] . '">' . $row['nom'] . '</option>';
                }
                ?>
                

            </select>
        </div>
        <div class="flex items-center justify-center mb-4">
            <button
                class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline"
                type="submit" name="conservation">
                conservation
            </button>
        </div>

    </form>
</div>
      </div>
    </div>
    <img src="./../assets/img/image2.jpg" alt="Leafs" class="w-full h-48 object-cover sm:h-screen sm:w-4/12">
  </div>
    </section>


</body>
</html>
