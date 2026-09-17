<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <meta name="description" content="Sistem Absensi Bidang TIK Polda Jawa Timur">
   <meta name="theme-color" content="#0b1f3a">

   <?= csrf_meta(); ?>

   <?= $this->include("templates/css") ?>

   <title>Absensi Bid TIK Polda Jatim</title>

   <style>
      /* ==============================
         RESET
      ============================== */

      * {
         box-sizing: border-box;
      }

      html,
      body {
         width: 100%;
         min-height: 100%;
         margin: 0;
         padding: 0;
      }

      body {
         font-family: "Roboto", Arial, sans-serif;
         overflow-x: hidden;
      }


      /* ==============================
         BACKGROUND
      ============================== */

      .login-background {
         position: fixed;
         inset: 0;
         width: 100%;
         height: 100%;
         z-index: -10;

         background:
            linear-gradient(
               135deg,
               rgba(5, 20, 40, 0.82),
               rgba(10, 40, 75, 0.65)
            ),
            url("<?= base_url('assets/img/beground_polda.jpg?v=' . time()) ?>");

         background-size: cover;
         background-position: center;
         background-repeat: no-repeat;
      }


      /* Efek cahaya */

      .login-background::after {
         content: "";
         position: absolute;
         inset: 0;

         background:
            radial-gradient(
               circle at 20% 20%,
               rgba(255, 255, 255, 0.12),
               transparent 30%
            ),
            radial-gradient(
               circle at 80% 80%,
               rgba(255, 255, 255, 0.08),
               transparent 35%
            );
      }


      /* ==============================
         NAVBAR
      ============================== */

      .navbar,
      nav.navbar {
         background: transparent !important;
         box-shadow: none !important;
         border: none !important;

         position: absolute !important;
         top: 0;
         left: 0;

         width: 100%;
         z-index: 10;
      }

      .navbar-brand {
         color: white !important;
         font-weight: 600;

         text-shadow:
            0 2px 8px rgba(0, 0, 0, 0.45);

         letter-spacing: 0.3px;
      }


      /* ==============================
         LOGIN WRAPPER
      ============================== */

      .login-wrapper {
         min-height: 100vh;
         width: 100%;

         display: flex;
         align-items: center;
         justify-content: center;

         padding: 70px 20px 30px;
      }


      /* ==============================
         LOGIN CARD
      ============================== */

      .card-login-custom {
         width: 100%;
         max-width: 470px;

         margin: 0 auto;

         border: 1px solid rgba(255, 255, 255, 0.25) !important;

         border-radius: 24px !important;

         background: rgba(255, 255, 255, 0.94) !important;

         backdrop-filter: blur(18px);
         -webkit-backdrop-filter: blur(18px);

         box-shadow:
            0 25px 70px rgba(0, 0, 0, 0.35) !important;

         overflow: hidden;
      }


      /* ==============================
         CARD HEADER
      ============================== */

      .card-header-primary {
         background:
            linear-gradient(
               135deg,
               #0b1f3a,
               #174d7a
            ) !important;

         border: none !important;

         padding: 28px 25px !important;

         color: white;
      }


      .card-header-primary .card-title {
         color: white !important;

         font-size: 23px;

         font-weight: 700;

         letter-spacing: 0.3px;
      }


      .card-header-primary .card-category {
         color: rgba(255, 255, 255, 0.82) !important;

         font-size: 14px;
      }


      /* ==============================
         CARD BODY
      ============================== */

      .card-login-custom .card-body {
         padding: 30px !important;
      }


      /* ==============================
         INPUT
      ============================== */

      .card-login-custom .form-control {
         border-radius: 12px;

         border: 1px solid #d9dfe7;

         background: #f8fafc;

         padding: 12px 14px;

         transition: all 0.25s ease;
      }


      .card-login-custom .form-control:focus {
         background: white;

         border-color: #174d7a;

         box-shadow:
            0 0 0 3px rgba(23, 77, 122, 0.12);
      }


      /* ==============================
         LOGIN BUTTON
      ============================== */

      .card-login-custom .btn-primary {
         border: none !important;

         border-radius: 12px !important;

         padding: 12px 20px;

         font-weight: 600;

         background:
            linear-gradient(
               135deg,
               #0b1f3a,
               #176ca8
            ) !important;

         box-shadow:
            0 8px 20px rgba(11, 31, 58, 0.25);

         transition: all 0.25s ease;
      }


      .card-login-custom .btn-primary:hover {
         transform: translateY(-2px);

         box-shadow:
            0 12px 25px rgba(11, 31, 58, 0.32);
      }


      /* ==============================
         OTHER BUTTONS
      ============================== */

      .card-login-custom .btn-info,
      .card-login-custom .btn-secondary {
         border-radius: 11px !important;

         padding: 11px 15px;

         font-weight: 500;

         transition: all 0.25s ease;
      }


      .card-login-custom .btn-info:hover,
      .card-login-custom .btn-secondary:hover {
         transform: translateY(-1px);
      }


      /* ==============================
         RESPONSIVE
      ============================== */

      @media (max-width: 576px) {

         .login-wrapper {
            padding: 70px 14px 25px;
         }

         .card-login-custom {
            border-radius: 18px !important;
         }

         .card-login-custom .card-body {
            padding: 22px !important;
         }

         .card-header-primary {
            padding: 22px 18px !important;
         }

         .card-header-primary .card-title {
            font-size: 20px;
         }
      }
   </style>
</head>


<body>

   <!-- Background -->
   <div class="login-background"></div>


   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-absolute">

      <div class="container-fluid">

         <div class="navbar-wrapper row w-100 mx-0">

            <div class="col-md-6 d-flex justify-content-center justify-content-md-start">

               <p class="navbar-brand my-auto text-center mx-0">

                  <b>
                     <?= $title ?? "Absensi Bid TIK" ?>
                  </b>

               </p>

            </div>


            <div class="col-md-6 d-flex justify-content-center justify-content-md-end">

               <?= $this->renderSection("navaction") ?>

            </div>

         </div>

      </div>

   </nav>


   <!-- Content -->
   <?= $this->renderSection("content") ?>


   <!-- JavaScript -->
   <?= $this->include("templates/js") ?>


   <script>

      var BaseConfig = {

         baseURL: '<?= base_url(); ?>',

         csrfTokenName: '<?= csrf_token() ?>',

         textOk: "Ok",

         textCancel: "Batalkan"

      };

   </script>


   <?= $this->renderSection("scripts") ?>

</body>

</html>