<?php $title_name='Войти в аккаунт'; ?>
<?php require "blocks/header.php"; ?>
<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5 shadow" tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header p-5 pb-4 border-bottom-0 d-flex justify-content-center">
        <h1 class="fw-bold mb-0 fs-2">Войти в аккаунт</h1>
      </div>
      <div class="modal-body p-5 pt-0">
        <form class="">
          <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com">
            <label for="floatingInput">Электронная почта</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password">
            <label for="floatingPassword">Пароль</label>
          </div>
          <p><a class="link-opacity-50-hover" href="">Забыли пароль?</a></p>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary mt-3" type="submit">Войти</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require "blocks/footer.php"; ?>
