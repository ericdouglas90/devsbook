<?=$render('header', ['loggedUser'=>$loggedUser, 'user'=>$user]);?>

<section class="container main">
  <?=$render('sidebar', ['activeMenu' => 'config']);?>

    <section class="feed mt-10">

    <div class="row">
      <div class="column pr-5">
        <h1>Configurações</h1>
        <?php if(!empty($flash)):?>
          <div class="flash"><?=$flash; ?></div>
        <?php endif;?>
        <br><br>
        <form action="<?=$base;?>/config" method="post" enctype="multipart/form-data">
          <input value="<?=$user->id?>" name="id" type="hidden" />
          <label class="label-name">
            Novo Avatar:
            <br /><br>
            <input type="file" name="avatar" />
          </label>
          <br><br>
          <label class="label-name">
            Nova Capa:
            <br /><br>
            <input type="file" name="cover" />
          </label>
          <br><br>
          <hr>
          <label >
            Nome Completo:
            <br />
            <input class="form-data" type="text" name="nome" value="<?=$user->nome?>"/>
          </label>
          <br><br>
          <label >
            Data de Nascimento:
            <br />
            <input class="form-data" type="text" name="birthdate" value="<?=date('d/m/Y', strtotime($user->birthdate));?>"/>
          </label>
          <br><br>
          <label >
            E-mail:
            <br />
            <input class="form-data" type="email" name="email" value="<?=$user->email?>"/>
          </label>
          <br><br>
          <label >
            Cidade:
            <br />
            <input class="form-data" type="text" name="city" value="<?=$user->city?>"/>
          </label>
          <br><br>
          <label >
            Trabalho:
            <br />
            <input class="form-data" type="text" name="work" value="<?=$user->work?>"/>
          </label>
          <br><br>
          <hr>
          <label >
            Nova Senha:
            <br />
            <input class="password" type="password" name="password" />
          </label>
          <br><br>
          <label >
            Confirme nova senha:
            <br />
            <input class="password" type="password" name="passwordConfirm" />
          </label>
          <br><br>
          <input class="button" type="submit" value="Salvar">
        </form>
      </div>      
    </div>

    </section>

</section>

<?=$render('footer');?>