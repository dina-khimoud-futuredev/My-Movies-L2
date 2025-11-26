<?php

require_once "../config.php";
session_start();
require $GLOBALS['PHP_DIR'] . "class/Autoloader.php";
Autoloader::register();

use mdb\Logger;

$logger = new Logger();
$username = null;
$password = null;
$signed = false;
$error = null;
if (isset($_POST['username']) and isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $response = $logger->signup(trim($username), trim($password));
    if ($response['signed']) {
        $signed = true;
    }
    $error = $response['error'];
}
ob_start();
?>
<div class="bg-secondary h-screen w-screen">

    <div class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0">
        <a href="index.php" class="px-4 py-2 bg-white animate-bounce hover:bg-primary hover:text-white rounded-md  self-start mb-3"><i class="fas fa-arrow-left mr-2"></i> Return to Home</a>

        <div class="flex rounded-lg shadow-lg w-full sm:w-3/4  bg-primary text-white sm:mx-0 h-[800px]">
            <div class="hidden md:block md:w-1/2 rounded-r-lg" style="background: url('<?php echo $GLOBALS['IMG_DIR'] ?>SignUp.jpeg'); background-size: cover; background-position: center center;"></div>
            <div class="flex flex-col w-full md:w-1/2 p-4">
                <div class="flex flex-col flex-1 justify-center mb-8">
                    <?php if ($signed) { ?>
                        <div class=" bg-white w-10/12 mx-auto text-xl  text-center text-black p-4 rounded">
                            <img src="../images/checked.gif" class="mx-auto" alt="">
                            <p class="uppercase text-4xl py-3">Welcome</p>
                            <p>You are successfully signed up with us <span class="text-green-500 text-3xl"><?php echo $username; ?></span> !</p>

                            <p class="border border-green-500 shadow-inner rounded-lg p-2 mt-4"> <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor" />
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill" />
                                </svg> will be redirected to the login page in 3 seconds ...</p>
                        </div>
                        <script>
                            setTimeout(function() {
                                window.location.href = "login.php";
                            }, 3000);
                        </script>
                    <?php } else { ?>
                        <h1 class="text-5xl text-center font-thin">Sign Up </h1>
                        <div class="w-full mt-4">
                            <?php if ($error) : ?>
                                <div class="bg-red-500 text-white w-8/12 mx-auto p-2 text-center rounded-md mb-4">
                                    <?php echo $error ?>
                                </div>
                            <?php endif ?>

                            <form class="form-horizontal w-3/4 mx-auto text-primary" method="POST" action="">
                                <div class="flex flex-col mt-4">
                                    <input id="username" type="text" class="flex-grow h-10 px-2  border rounded border-grey-400 outline-none" name="username" value="" placeholder="Username">
                                </div>
                                <div class="flex flex-col mt-4">
                                    <input id="password" type="password" class="flex-grow h-10 px-2 rounded border border-grey-400 outline-none" name="password" placeholder="Password">
                                </div>
                                <!-- <div class="flex items-center mt-4">
                                <input type="checkbox" name="remember" id="remember" class="mr-2"> <label for="remember" class="text-sm text-grey-dark">Remember Me</label>
                            </div> -->
                                <div class="flex flex-col mt-8">
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm font-semibold py-2 px-4 rounded">
                                        Sign up
                                    </button>
                                </div>
                            </form>
                            <div class="text-center mt-4">
                                You have an account? <a href="login.php" class="no-underline hover:underline text-blue-dark text-sm text-secondary">Login</a>.

                            </div>
                        <?php } ?>
                        </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $content = ob_get_clean() ?>
<?php Template::render($content, false, false) ?>