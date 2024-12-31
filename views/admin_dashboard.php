<?php 
require "../src/classes/member_classe.php";
autandificationA();
$admin = new Admin();
$reservation =  new Reservation();
$activite = new Activites();
$admin->setEmail($_SESSION['email']);
$admin->insert();
$hidden="hidden";
$stmt =$admin->listActivite();
$stmtReservation = $admin->listeRservation();
if(isset($_POST['edit'])){
    $activite->set_id_activite($_POST['idA']);
    $activite->insert(); 
    $hidden="";   
}
if (isset($_POST['disponibilite']) && isset($_POST['nom']) && isset($_POST['descriptionA']) && isset($_POST['capacite']) && isset($_POST['date_fin']) && isset($_POST['conservation'])) { 
    $nom = htmlspecialchars($_POST['nom']);
    $descriptionA = htmlspecialchars($_POST['descriptionA']);
    $capacite = intval($_POST['capacite']);
    $date_fin = htmlspecialchars($_POST['date_fin']);
    $disponibilite = htmlspecialchars($_POST['disponibilite']);

    $newactivite = new Activites();
    $newactivite->set_nom_activite($nom);
    $newactivite->set_description($descriptionA);
    $newactivite->set_capacite($capacite);
    $newactivite->set_date_fin($date_fin);
    $newactivite->set_disponibilite($disponibilite);
    $admin->editActivite($activite,$newactivite);
    $hidden="hidden";
}  
if(isset($_POST['delete'])){
    $activite->set_id_activite($_POST['idA']);
    $activite->insert();
    // echo 'id '.$_POST['idA'].'  ig' . $activite->get_id_activite();
    $admin->sepprimeActivite($activite);
}
if(isset($_POST['annuler'])){
     $reservation->setID($_POST['idR']);
     $reservation->insert();
     $admin->anulleReservation($reservation);
}
if(isset($_POST['confirmer'])){
    $reservation->setID($_POST['idR']);
    $reservation->insert();
    $admin->confirfeReservation($reservation);
}
if(isset($_POST['logout'])){
    $admin->logout();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCompany - Alternative Hero Section</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../src/global.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="font-sans">
    <!-- ... (previous header code remains unchanged) ... -->

    <header class="lg:px-16 px-4 bg-white flex flex-wrap items-center py-4 shadow-md">
    <div class="flex-1 flex justify-between items-center">
        <a href="home_admin.php" class="text-xl text-black">home</a>
        
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
                <li><a class="md:p-4 py-3 px-0 block" href="add_activite.php">Add Activité</a></li>
                <li><a class="md:p-4 py-3 px-0 block" href="admin_dashboard.php">Dashboard</a></li>
                <li> <form action=""  method="POST">
                    <input type="submit" name="logout" value="logout"/>
                </form>
            </li>
            </ul>
        </nav>
    </div>
</header>
<body>

<?php 
echo '<div class="max-w-md mt-10 bg-white shadow-lg rounded-lg overflow-hidden ' . $hidden . ' absolute top-[20px] right-[10px] left-[10px]  mx-auto">';
?>
    <div class="text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase">
        Edit Activity
    </div>
    <form class="py-4 px-6" action="" method="POST">
        <div class="mb-4">
            <label for="nom" class="block text-gray-700 font-semibold">Nom de l'activité</label>
            <input type="text" id="nom" name="nom" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="descriptionA" class="block text-gray-700 font-semibold">Description</label>
            <textarea id="descriptionA" name="descriptionA" rows="4" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required></textarea>
        </div>
        <div class="mb-4">
            <label for="capacite" class="block text-gray-700 font-semibold">Capacité</label>
            <input type="number" id="capacite" name="capacite" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div class="mb-4">
            <label for="date_fin" class="block text-gray-700 font-semibold">Date de fin</label>
            <input type="date" id="date_fin" name="date_fin" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
        </div>
        <div class="mb-6">
            <label for="disponibilite" class="block text-gray-700 font-semibold">Disponibilité</label>
            <select id="disponibilite" name="disponibilite" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <option value="disponible">Disponible</option>
                <option value="pasdisponible">Indisponible</option>
            </select>
        </div>
        <div class="flex items-center justify-center mb-4">
            <input class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline" type="submit" name="submit" value="Conservation"/>
        </div>
    </form>
</div>



<div class="container">
    <h2>List of Clients</h2>
    <table class="clients-table">
        <thead>
            <tr>
                <th> Name</th>
                <th>statut</th>
                <th>Telephone</th>
                <th> Activity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            while($row = $stmtReservation->fetch(PDO::FETCH_ASSOC))
            echo '
            <tr>   
                <td>'.$row['nom'].' '.$row['prenom'].'</td>
                <td>'.$row['statut'].'</td>
                <td>'.$row['telephone'].'</td>
                <td>'.$row['activite'].'</td>
                <td>
                <form method="POST">
                    <input value="'.$row['id_reservation'].'" name="idR" class="hidden" />
                    <input type="submit" name="confirmer"   class="btn btn-confirm" value="Confirmer">
                </form>
                <form method="POST">
                    <input value="'.$row['id_reservation'].'" name="idR" class="hidden" />
                    <input name="annuler" type="submit"   class="btn btn-cancel" value="Annuler">
                </form>
                </td>
            </tr>';
            ?>

        </tbody>
    </table>
</div>


<header>
    <h1>Activity List</h1>
    <a href="add_activite.php" class="add-activity-btn">Add Activity</a>
</header>
<div class="container">
    <h2>Current Activities</h2>
    <table class="clients-table">
        <thead>
            <tr>
                <th> Name</th>
                <th>capacite</th>
                <th>disponibilite</th>
                <th>date fine</th>
                <th>Actions</th>
            </tr>
        </thead>
        
        <tbody>
            
<?php 
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  echo ' 
    <tr>
    <td>'.$row['nom'].'</td>
    <td>'.$row['capacite'].'</td>
    <td>'.$row['disponibilite'].'</td>
    <td>'.$row['date_fin'].'</td>
    <td>
        <form method="POST">
            <input value="'.$row['id_activite'].'" name="idA" class="hidden" />
            <input type="submit" name="edit"   class="btn btn-confirm" value="edit">
        </form>
        <form method="POST">
            <input value="'.$row['id_activite'].'" name="idA" class="hidden" />
            <input name="delete" type="submit"   class="btn btn-cancel" value="delete">
        </form>
    </td>
</tr> ';
}
?>
           
        </tbody>
    </table>
</div>

<?php require('footer.php'); ?>
