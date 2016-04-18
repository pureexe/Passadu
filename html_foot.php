<?php
if(!isset($_SESSION)){
  session_start();
}
if(isset($_SESSION['flash'])){
  unset($_SESSION['flash']);
}
?>
</div>
    </div>
  </div>


  <footer class="footer">
      <div class="container">
        <p class="text-muted">Suplies Management System (SMS) ระบบริหารจัดการพัสดุ</p>
      </div>
    </footer>



    
  </body>
</html>
