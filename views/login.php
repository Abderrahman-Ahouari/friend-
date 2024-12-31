<?php 
require "../src/classes/member_classe.php";
autandification();
$user = new Utilisateur();
if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['login'])){
$user->setEmail($_POST['email']);
$user->setPassword($_POST['password']);
// echo 'email : ' .$_POST['email']. ' : email'.$user->getEmail();
if($er =$user->login())
echo 'ee'.$er;
}else echo "isis";
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

<section>
    <div class="flex flex-wrap">
        <div class="w-full sm:w-8/12 mb-10">
            <div class="container mx-auto h-full sm:p-10">
                <div class="max-w-md mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="text-2xl py-4 px-6 bg-gray-900 text-white text-center font-bold uppercase">
                        login 
                    </div>
                    <form class="py-4 px-6" action="" method="POST">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="email" placeholder="Enter your email"/>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="Password">
                                Password
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="phone" type="password" name="password" placeholder="Password"/>
                        </div>
                        <div class="flex items-center justify-center mb-4 justify-around">
                            <button class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline w-24" type="submit" name="login">
                                login
                            </button>
                            <a class="bg-gray-900 text-white py-2 px-4 rounded hover:bg-gray-800 focus:outline-none focus:shadow-outline w-24" type="submit" name="signup"  href="signup.php">
                                signup
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <img src="https://images.unsplash.com/photo-1536147116438-62679a5e01f2?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80" alt="Leafs" class="w-full h-48 object-cover sm:h-screen sm:w-4/12">
    </div>
</section>
</body>
</html>
