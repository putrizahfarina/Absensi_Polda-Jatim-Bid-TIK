<!DOCTYPE html>
<html lang="id">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<?= $this->include("templates/head") ?>

<body>
   <div>
      <?= $this->include("templates/sidebar") ?>
      <div class="main-panel main-panel-watermark">

         <?= $this->include("templates/navbar") ?>

         <?= $this->renderSection("content") ?>

         <?= $this->include("templates/footer") ?>

         <!-- komentar jika tidak dipakai -->
         <?php
         // echo $this->include('templates/fixed_plugin')
         ?>

      </div>
   </div>

   <?= $this->include("templates/js") ?>

   <script>
      var BaseConfig = {
         baseURL: '<?= base_url() ?>',
         csrfTokenName: '<?= csrf_token() ?>',
         textOk: "Ok",
         textCancel: "Batalkan"
      };
   </script>

    <?= $this->renderSection("scripts") ?>
</body>

</html>
