<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logue-se no sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


    <script>

         document.addEventListener( "DOMContentLoaded", function () { 

          let year = new Date().getFullYear()

            document.getElementById('copy').innerHTML = `&copy; ${year} - Rodrigo Guimarães`;
            
         });
         
    </script>
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .checkbox {

            font-weight: 400;

        }

        .form-signin .form-control {

            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;

        }

        .form-signin .form-control:focus {

            z-index: 2;
        }
 
        .form-signin input[type="email"] {

            margin-bottom: 10px;
            border-radius: 5px;

        }

        .form-signin input[type="password"] {

            margin-bottom: 10px;
            border-radius: 5px;

        }


        .form-cad a {
            color: #2765cf;
            text-decoration: none;
            transition: all 0.5s;
        }

        .form-cad a:hover {
            color: #2828ff;
            text-decoration: underline;
        }
    </style>
</head>

<body class="text-center">

    <main class="form-signin">
        <form class="form-cad" action="<?php echo base_url('login/signIn') ?>" method="post">
            <img class="mb-4" src="<?php echo base_url('public/images/logoEdited3.png') ?>" alt="" width="72" height="72">
            <h1 class="h3 mb-3 fw-normal">Por favor, logue-se</h1>
            <label for="inputEmail" class="visually-hidden">Email address</label>
<!--            <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>-->
               <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="E-mail..." required autofocus>
            <label for="inputPassword" class="visually-hidden">Password</label>
            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Senha..." required>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar!</button>
            <a href="<?php  echo base_url('account/signup') ?>">Não tem uma conta ainda? cadastre-se!</a>
            <p class="mt-5 mb-3 text-muted" id="copy">&copy; 2021 - Rodrigo Guimarães </p>
        </form>
        
        <?php $msg = session()->getFlashData('msg') ?>
        
        <?php if (!empty($msg)): ?>
            <div class="alert alert-danger">
                <?php echo $msg ?>
            </div>
        <?php endif; ?>
        
    </main>
    
</body>

</html>
