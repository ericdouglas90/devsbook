<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Cadastro - DevsBook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css" />
</head>
<body>
    <header>
        <div class="container">
            <a href=""><img src="<?=$base;?>/assets/images/devsbook_logo.png" /></a>
        </div>
       
    </header>
    <section class="container main">

        <form method="POST" action="<?=$base;?>/cadastro">
            <?php if(!empty($flash)):?>
                <div class="flash"><?=$flash; ?></div>
            <?php endif;?>

            <input placeholder="Digite seu nome" class="input" type="text" name="nome" />

            <input placeholder="Digite seu E-mail" class="input" type="email" name="email" />

            <input placeholder="Digite sua Senha" class="input" type="password" name="password" />

            <input id="birthdate" placeholder="Digite sua Data de Nascimento" class="input" type="text" name="birthdate" />

            <input class="button" type="submit" value="Fazer cadastro" />

            <a href="<?=$base;?>/login">Já tem cadastro? Faça o login</a>
        </form>
    </section>

    <script src="https://unpkg.com/imask"></script>
    <script>
      IMask(
        document.querySelector("#birthdate"),
        {
          mask: '00/00/0000'
        }
      )
    </script>
</body>
</html>