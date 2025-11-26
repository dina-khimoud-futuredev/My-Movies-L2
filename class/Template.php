<?php
class Template
{

    public static function render(string $content , bool $navbar=true,bool $footer=true): void
    { ?>

        <!doctype html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="<?php echo $GLOBALS['CSS_DIR'] ?>style.css">
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>My movies</title>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            colors: {
                                primary: "black",
                                secondary: "red",
                                "primary-light": "rgb(163 163 163)",

                            }
                        }
                    }
                }
            </script>
        </head>

        <body class="bg-primary">
            
            <?php  
            if($navbar){
                include "header.php";
            }
            ?>

            <div id="content">
                <?php echo $content ?> <!-- INJECTION DU CONTENU -->
            </div>

            <?php
            if($footer){
                include "footer.php";
            }
            ?>

            

        </body>
        <script src="../crousel/crousel.js"></script>
        </html>

<?php
    }
}
