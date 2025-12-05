<?php
require_once "../config.php" ;
session_start() ;
require $GLOBALS['PHP_DIR']."class/Autoloader.php" ;
Autoloader::register();
use mdb\Logger ;

$logger = new Logger() ;

$username = null;
$password = null ;
$error= null ;

if (isset($_POST['username']) and isset($_POST['password'])){
    $username = $_POST['username'] ;
    $password = $_POST['password'] ;
    $response = $logger->log(trim($username), trim($password)) ;
    if ($response['granted']){
        $_SESSION['username'] = $response['user']->username;
        $_SESSION['role']=$response['user']->role;
        $_SESSION['userId']=$response['user']->id;
        header("Location: index.php");
        exit() ;
    }
        $error = $response['error'] ;
}
ob_start();
?>
<div class="bg-secondary h-screen w-screen">
    <div class="flex flex-col items-center flex-1 h-full justify-center px-4 sm:px-0">
        <a href="index.php" class="px-4 py-2 bg-white animate-bounce hover:bg-primary hover:text-white rounded-md  self-start mb-3"><i class="fas fa-arrow-left mr-2"></i> Return to Home</a>
        <div class="flex rounded-lg shadow-lg w-full sm:w-3/4  bg-primary text-white sm:mx-0 h-[800px]" >
            <div class="flex flex-col w-full md:w-1/2 p-4">
                <div class="flex flex-col flex-1 justify-center mb-8">
                    <h1 class="text-5xl text-center font-thin">Login</h1>
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
                                <input id="password" type="password" class="flex-grow h-10 px-2 rounded border border-grey-400 outline-none" name="password"  placeholder="Password">
                            </div>
                            <!-- <div class="flex items-center mt-4">
                                <input type="checkbox" name="remember" id="remember" class="mr-2"> <label for="remember" class="text-sm text-grey-dark">Remember Me</label>
                            </div> -->
                            <div class="flex flex-col mt-8">
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm font-semibold py-2 px-4 rounded">
                                    Login
                                </button>
                            </div>
                        </form>
                        <div class="text-center mt-4">
                        Don't have an account? <a href="signUp.php" class="no-underline hover:underline text-blue-dark text-sm text-secondary">Create an Account</a>.

                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden md:block md:w-1/2 rounded-r-lg" style="background: url('<?php echo $GLOBALS['IMG_DIR'] ?>Login.jpeg'); background-size: cover; background-position: center center;"></div>
        </div>
    </div>
</div>
<?php $content=ob_get_clean() ?>
<?php Template::render($content,false,false) ?>