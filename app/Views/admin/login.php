<?= $this->extend('templates/starting_page_layout'); ?>

<?= $this->section('navaction') ?>
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<style>
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
   color: #f8fafc;
   font-size: 13px;
   font-weight: 600;
   letter-spacing: 0.3px;
   margin-bottom: 8px;
}

/* INPUT MODERN */
.login-input-group {
   margin-bottom: 18px;
}

.login-input-wrapper {
   position: relative;
   display: flex;
   align-items: center;
   background: #ffffff;
   border: 2px solid rgba(255, 255, 255, 0.25);
   border-radius: 13px;
   box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
   transition: all 0.25s ease;
   overflow: hidden;
}

.login-input-wrapper:hover {
   border-color: rgba(255, 255, 255, 0.65);
}

.login-input-wrapper:focus-within {
   border-color: #ef4444;
   box-shadow:
      0 0 0 4px rgba(239, 68, 68, 0.25),
      0 6px 18px rgba(0, 0, 0, 0.25);
   transform: translateY(-1px);
}

.login-input-icon {
   position: absolute;
   left: 15px;
   color: #64748b;
   font-size: 20px;
   pointer-events: none;
   transition: color 0.25s ease;
   z-index: 2;
}

.login-input-wrapper:focus-within .login-input-icon {
   color: #b32025;
}

.login-input {
   width: 100%;
   height: 50px;
   padding: 0 46px 0 46px;
   border: none !important;
   background: transparent !important;
   color: #0f172a !important;
   font-size: 14.5px;
   font-weight: 500;
   outline: none !important;
   box-sizing: border-box;
}

.login-input::placeholder {
   color: #94a3b8;
   font-weight: 400;
}

/* Mencegah kotak berubah biru pucat saat Chrome Autofill */
.login-input:-webkit-autofill,
.login-input:-webkit-autofill:hover,
.login-input:-webkit-autofill:focus,
.login-input:-webkit-autofill:active {
   -webkit-box-shadow: 0 0 0 30px #ffffff inset !important;
   -webkit-text-fill-color: #0f172a !important;
   transition: background-color 5000s ease-in-out 0s;
}

/* TOMBOL IKON MATA (SHOW/HIDE PASSWORD) */
.btn-toggle-password {
   position: absolute;
   right: 10px;
   background: transparent;
   border: none;
   width: 34px;
   height: 34px;
   border-radius: 9px;
   display: flex;
   align-items: center;
   justify-content: center;
   color: #64748b;
   cursor: pointer;
   transition: all 0.2s ease;
   z-index: 2;
   padding: 0;
}

.btn-toggle-password:hover {
   background: #f1f5f9;
   color: #0f172a;
}

.btn-toggle-password:focus {
   outline: none;
}

.btn-toggle-password i {
   font-size: 20px;
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
   border-radius: 13px;
   font-weight: 700;
   font-size: 14.5px;
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 8px;
   text-decoration: none;
   cursor: pointer;
   transition: all 0.25s ease;
}

/* BUTTON LOGIN */
.login-btn-primary {
   color: #ffffff;
   background: linear-gradient(135deg, #7b1113, #b32025);
   box-shadow: 0 8px 20px rgba(120, 0, 0, .35);
}

.login-btn-primary:hover {
   color: #ffffff;
   background: linear-gradient(135deg, #8f1619, #c62828);
   transform: translateY(-2px);
   box-shadow: 0 10px 24px rgba(140, 0, 0, .45);
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

/* FOOTER */
.login-footer {
   text-align: center;
   color: rgba(255, 255, 255, 0.60);
   font-size: 11px;
   margin-top: 25px;
}

/* ERROR MESSAGE */
.login-error {
   color: #fecaca;
   background: rgba(185, 28, 28, 0.35);
   border: 1px solid rgba(248, 113, 113, 0.4);
   border-radius: 8px;
   padding: 6px 10px;
   font-size: 12px;
   margin-top: 6px;
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

            <img
               src="<?= base_url('assets/img/LOGO_POLDA_JATIM.png') ?>"
               alt="Logo Polda Jawa Timur"
               class="login-logo">

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
            <div class="login-input-group">

               <label for="loginEmail" class="login-label">
                  Email
               </label>

               <div class="login-input-wrapper">

                  <i class="material-icons login-input-icon">
                     email
                  </i>

                  <input
                     type="email"
                     id="loginEmail"
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
            <div class="login-input-group">

               <label for="loginPassword" class="login-label">
                  Password
               </label>

               <div class="login-input-wrapper">

                  <i class="material-icons login-input-icon">
                     lock
                  </i>

                  <input
                     type="password"
                     id="loginPassword"
                     name="password"
                     class="login-input"
                     autocomplete="current-password"
                     placeholder="Masukkan password Anda"
                     required>

                  <button
                     type="button"
                     class="btn-toggle-password"
                     id="togglePasswordBtn"
                     title="Lihat / Sembunyikan Password"
                     aria-label="Lihat atau sembunyikan password">
                     <i class="material-icons" id="togglePasswordIcon">visibility</i>
                  </button>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
   const toggleBtn = document.getElementById('togglePasswordBtn');
   const passwordInput = document.getElementById('loginPassword');
   const toggleIcon = document.getElementById('togglePasswordIcon');

   if (toggleBtn && passwordInput && toggleIcon) {
      toggleBtn.addEventListener('click', function () {
         const isPassword = passwordInput.getAttribute('type') === 'password';
         passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
         toggleIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
      });
   }
});
</script>

<?= $this->endSection(); ?>