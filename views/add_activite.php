<?php
require("headerAd.php");

       if (isset($_POST['disponibilite']) && isset($_POST['nom']) && isset($_POST['descriptionA']) && isset($_POST['capacite']) && isset($_POST['date_fin']) && isset($_POST['conservation'])) { 
        $nom=$_POST['nom'];
         $descriptionA=$_POST['descriptionA'];
         $capacite =$_POST['capacite'];
         $date_fin =$_POST['date_fin'];
         $disponibilite =$_POST['disponibilite'];
         $user = new Admin();
        $activite = new Activites();
        $email =$_SESSION['email'];
        $user->setEmail($email);
        $user->insert();
        $activite->set_id_admin($user->getId());
        $activite->set_nom_activite($nom);
        $activite->set_description($descriptionA);
        $activite->set_capacite($capacite);
        $activite->set_date_fin($date_fin);
        $activite->set_disponibilite($disponibilite);
        $user->crrerActivite($activite);
       }
    //    $user = new Admin();
    //    $email =$_SESSION['email'];
    //    $user->setEmail($email);
    //    $user->insert();
    //   echo  $user->getEmail()  .' ' . $user->getNom() .' ' . $user->getId();
    //   $user->crrerActivite(new Activites(1,$user->getId(),'nom','deer',12,'2002/12/12','20/32/32','idd'));
?>
<section>
    <div class="flex flex-wrap">
        <div class="w-full sm:w-8/12 mb-10">
            <div class="container mx-auto h-full sm:p-10">
                <div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase">
                        Add Activity
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
                            <input type="text" id="capacite" name="capacite" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-4">
                            <label for="date_fin" class="block text-gray-700 font-semibold">Date de fin</label>
                            <input type="date" id="date_fin" name="date_fin" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        <div class="mb-6">
                            <label for="disponibilite" class="block text-gray-700 font-semibold">Disponibilité</label>
                            <select id="disponibilite" name="disponibilite" class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                <option value="disponible">Disponible</option>
                                <option value="pas disponible">Indisponible</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-center mb-4">
                            <input class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline" type="submit" name="conservation" value="Conservation"/>
                                
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1536147116438-62679a5e01f2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80" alt="Leafs" class="w-full h-48 object-cover sm:h-screen sm:w-4/12">
    </div>
</section>



<?php require("footer.php"); ?>
