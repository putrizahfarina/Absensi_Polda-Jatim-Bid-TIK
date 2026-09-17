<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>


/* REGISTER */
.register-link {
   text-align: center;
   margin-top: 20px;
   margin-bottom: 5px;
   font-size: 15px;
   color: rgba(255, 255, 255, 0.85) !important;
}

.register-link span {
   color: rgba(255, 255, 255, 0.85) !important;
}

.register-link a {
   color: #ffffff !important;
   font-size: 16px !important;
   font-weight: 700 !important;
   text-decoration: none !important;
   margin-left: 5px;
   transition: all 0.25s ease;
}

.register-link a:hover {
   color: #f5c542 !important;
   text-decoration: underline !important;
}
<style>
   /* =========================================
      LOGIN MODERN - BID TIK POLDA JATIM
      ========================================= */

   .login-wrapper {
      min-height: 100vh;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      box-sizing: border-box;
   }

   /* GLASS CARD */
   .card-login-custom {
      width: 100%;
      max-width: 440px;

      background: rgba(255, 255, 255, 0.13) !important;
      border: 1px solid rgba(255, 255, 255, 0.30) !important;
      border-radius: 24px !important;

      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);

      box-shadow:
         0 20px 60px rgba(0, 0, 0, 0.40),
         inset 0 1px 0 rgba(255, 255, 255, 0.20);

      overflow: hidden;
      color: #ffffff;
   }

   /* LOGO AREA */
   .login-logo-area {
      text-align: center;
      padding: 30px 25px 10px;
   }

   .login-logos {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 18px;
      margin-bottom: 20px;
   }

   .login-logo {
      width: 82px;
      height: 82px;
      object-fit: contain;

      background: rgba(255, 255, 255, 0.92);
      padding: 8px;

      border-radius: 50%;

      box-shadow:
         0 8px 25px rgba(0, 0, 0, 0.25),
         0 0 0 3px rgba(255, 255, 255, 0.20);
   }

   .login-divider {
      width: 1px;
      height: 55px;
      background: rgba(255, 255, 255, 0.45);
   }

   .login-title {
      color: #ffffff;
      font-size: 24px;
      font-weight: 700;
      line-height: 1.3;
      margin: 0;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.45);
   }

   .login-subtitle {
      color: rgba(255, 255, 255, 0.82);
      font-size: 13px;
      margin-top: 8px;
      margin-bottom: 0;
   }

   /* CARD BODY */
   .login-card-body {
      padding: 20px 32px 30px;
   }

   /* LABEL */
   .login-label {
      display: block;
      color: #ffffff;
      font-size: 13px;
      font-weight: 600;
      margin-bottom: 8px;
   }

   /* INPUT */
   .login-input-wrapper {
      position: relative;
      margin-bottom: 20px;
   }

   .login-input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: rgba(255, 255, 255, 0.75);
      font-size: 20px;
      z-index: 2;
   }

   .login-input {
      width: 100%;
      height: 50px;

      padding: 0 16px 0 48px;

      border: 1px solid rgba(255, 255, 255, 0.30);
      border-radius: 12px;

      background: rgba(255, 255, 255, 0.12);

      color: #ffffff;
      outline: none;

      transition: all 0.25s ease;

      box-sizing: border-box;
   }

   .login-input::placeholder {
      color: rgba(255, 255, 255, 0.60);
   }

   .login-input:focus {
      border-color: rgba(255, 255, 255, 0.75);
      background: rgba(255, 255, 255, 0.18);

      box-shadow:
         0 0 0 3px rgba(255, 255, 255, 0.10);
   }

   /* REMEMBER ME */
   .remember-wrapper {
      display: flex;
      align-items: center;
      color: rgba(255, 255, 255, 0.85);
      font-size: 13px;
      margin-bottom: 20px;
   }

   .remember-wrapper input {
      margin-right: 8px;
   }

   /* BUTTON UMUM */
   .login-btn {
      width: 100%;
      height: 50px;

      border: none;
      border-radius: 12px;

      font-weight: 700;
      font-size: 14px;

      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;

      text-decoration: none;

      transition: all 0.25s ease;
   }

   /* BUTTON LOGIN */
   .login-btn-primary {
      color: #ffffff;

      background: linear-gradient(
         135deg,
         #071a3d,
         #0d3b78
      );

      box-shadow:
         0 8px 20px rgba(0, 20, 60, 0.40);
   }

   .login-btn-primary:hover {
      color: #ffffff;
      transform: translateY(-2px);

      box-shadow:
         0 12px 25px rgba(0, 20, 60, 0.55);
   }

   /* GARIS PEMISAH */
   .login-separator {
      display: flex;
      align-items: center;
      gap: 12px;

      margin: 25px 0 20px;

      color: rgba(255, 255, 255, 0.65);

      font-size: 12px;
   }

   .login-separator::before,
   .login-separator::after {
      content: "";
      flex: 1;
      height: 1px;
      background: rgba(255, 255, 255, 0.25);
   }

   /* BUTTON IZIN */
   .login-btn-izin {
      color: #ffffff;

      background: rgba(7, 45, 90, 0.80);

      border: 1px solid rgba(255, 255, 255, 0.20);

      margin-bottom: 10px;
   }

   .login-btn-izin:hover {
      color: #ffffff;
      background: rgba(10, 60, 115, 0.95);
      transform: translateY(-2px);
   }

   /* BUTTON CEK KEHADIRAN */
   .login-btn-kehadiran {
      color: #ffffff;

      background: linear-gradient(
         135deg,
         #7b1113,
         #b32025
      );

      box-shadow:
         0 7px 18px rgba(120, 0, 0, 0.30);
   }

   .login-btn-kehadiran:hover {
      color: #ffffff;
      transform: translateY(-2px);

      box-shadow:
         0 10px 22px rgba(120, 0, 0, 0.45);
   }

   /* FOOTER */
   .login-footer {
      text-align: center;

      color: rgba(255, 255, 255, 0.60);

      font-size: 11px;

      margin-top: 25px;
   }

   /* ERROR MESSAGE */
   .login-error {
      color: #ffb3b3;
      font-size: 12px;
      margin-top: 5px;
   }

   /* RESPONSIVE HP */
   @media (max-width: 480px) {

      .login-wrapper {
         padding: 20px 12px;
      }

      .card-login-custom {
         max-width: 100%;
         border-radius: 20px !important;
      }

      .login-card-body {
         padding: 20px 22px 25px;
      }

      .login-logo {
         width: 68px;
         height: 68px;
      }

      .login-title {
         font-size: 20px;
      }

      .login-divider {
         height: 45px;
      }
   }
</style>


<div class="login-wrapper">

   <div class="card card-login-custom">

      <!-- =========================================
           LOGO & JUDUL
           ========================================= -->
      <div class="login-logo-area">

         <div class="login-logos">

            <!-- LOGO BID TIK -->
            <img
               src="<?= base_url('assets/img/logo_bid_TIK_POLDA.png') ?>"
               alt="Logo Bid TIK Polda Jatim"
               class="login-logo">

            <div class="login-divider"></div>

            <!-- LOGO POLDA JATIM -->
            <img
               <img src="<?= base_url('assets/img/logo_bid_TIK_POLDA.jpg') ?>" alt="Logo Bid TIK" class="login-logo">

         </div>

         <h1 class="login-title">
            Sistem Informasi Absensi
         </h1>

         <p class="login-subtitle">
            Bidang Teknologi Informasi dan Komunikasi<br>
            Polda Jawa Timur
         </p>

      </div>


      <!-- =========================================
           BODY LOGIN
           ========================================= -->
      <div class="login-card-body">

         <?= view('\App\Views\admin\_message_block') ?>


         <form action="<?= url_to('login') ?>" method="post">

            <?= csrf_field() ?>


            <!-- EMAIL -->
            <div>

               <label class="login-label">
                  Email
               </label>

               <div class="login-input-wrapper">

                  <i class="material-icons login-input-icon">
                     email
                  </i>

                  <input
                     type="email"
                     class="login-input"
                     name="email"
                     inputmode="email"
                     autocomplete="email"
                     placeholder="Masukkan email Anda"
                     value="<?= old('email') ?>"
                     required>

               </div>

               <?php if (session('errors.login')): ?>

                  <div class="login-error">
                     <?= session('errors.login') ?>
                  </div>

               <?php endif; ?>

            </div>


            <!-- PASSWORD -->
            <div>

               <label class="login-label">
                  Password
               </label>

               <div class="login-input-wrapper">

                  <i class="material-icons login-input-icon">
                     lock
                  </i>

                  <input
                     type="password"
                     name="password"
                     class="login-input"
                     autocomplete="current-password"
                     placeholder="Masukkan password Anda"
                     required>

               </div>

               <?php if (session('errors.password')): ?>

                  <div class="login-error">
                     <?= session('errors.password') ?>
                  </div>

               <?php endif; ?>

            </div>


            <!-- REMEMBER ME -->
            <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>

               <div class="remember-wrapper">

                  <input
                     type="checkbox"
                     name="remember"
                     id="remember"
                     <?php if (old('remember')): ?>checked<?php endif; ?>>

                  <label for="remember">
                     <?= lang('Auth.rememberMe') ?>
                  </label>

               </div>

            <?php endif; ?>


            <!-- LOGIN -->
            <button
               type="submit"
               class="login-btn login-btn-primary">

               <i class="material-icons">
                  login
               </i>

               <?= lang('Auth.login') ?>

            </button>
            


            <!-- PEMISAH -->
            <div class="login-separator">
               atau akses layanan
            </div>


            <!-- IZIN / SAKIT -->
            <a
               href="<?= base_url('izin') ?>"
               class="login-btn login-btn-izin">

               <i class="material-icons">
                  mail
               </i>

               Ajukan Izin / Sakit

            </a>


            <!-- CEK KEHADIRAN -->
            <a
               href="<?= base_url('cek-kehadiran') ?>"
               class="login-btn login-btn-kehadiran">

               <i class="material-icons">
                  visibility
               </i>

               Cek Kehadiran

            </a>


            <!-- MAGIC LINK -->
            <?php if (setting('Auth.allowMagicLinkLogins')): ?>

               <div class="text-center mt-3">

                  <a
                     href="<?= url_to('magic-link') ?>"
                     style="
                        color: rgba(255,255,255,0.80);
                        font-size: 12px;
                     ">

                     <?= lang('Auth.forgotPassword') ?>

                  </a>

               </div>

            <?php endif; ?>


            <!-- FOOTER -->
            <div class="login-footer">

               Sistem Absensi Digital<br>

               <strong>Bid TIK Polda Jawa Timur</strong>

            </div>

         </form>

      </div>

   </div>

</div>


<?= $this->endSection(); ?>