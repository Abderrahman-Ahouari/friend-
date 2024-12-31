
<?php
require("header_client.php");
$client =  new Members();
$client->setEmail($_SESSION['email']);
$client->insert();
$stmtR =$client->listeRservation();
if(isset($_POST['logout'])){
    $client->logout();
}
// while($row = $stmtR->fetch(PDO::FETCH_ASSOC)) 
// echo $client->getNom() .'id '.$client->getId();
$reservation = new Reservation();
if(isset($_POST['delete'])){
    $reservation->setID($_POST['RESERVATION']);
    $reservation->insert();
    $client->sepprimeReservation($reservation);
}
?>


<table class="min-w-full divide-y divide-gray-200">
    <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reservation Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
    <?php 
while($row = $stmtR->fetch(PDO::FETCH_ASSOC)) {
    echo '
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">' . $row['nom'] . '</td>
            <td class="px-6 py-4 whitespace-nowrap">' . $row['statut'] . '</td>
            <td class="px-6 py-4 whitespace-nowrap">' . $row['date_reservation'] . '</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"> ' . $row['statut'] . '</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <form method="POST">
                    <input value="' . $row['id_reservation'] . '" name="RESERVATION" class="hidden" />
                    <input class="px-4 py-2 font-medium text-white bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:shadow-outline-blue active:bg-blue-600 transition duration-150 ease-in-out" name="edit" type="submit" value="Edit" />
                </form>
                <form method="POST">
                    <input value="' . $row['id_reservation'] . '" name="RESERVATION" class="hidden" />
                    <input class="ml-2 px-4 py-2 font-medium text-white bg-red-600 rounded-md hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition duration-150 ease-in-out" name="delete" type="submit" value="DELETE" />
                </form>
            </td>
        </tr>';
}
?>


    </tbody>
</table>


<?php 
require("footer.php");
?>