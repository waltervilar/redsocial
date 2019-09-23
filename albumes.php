<?php
$id = mysqli_real_escape_string($connect, $_GET['id']);
$album = mysqli_real_escape_string($connect, $_GET['album']);
?>

                <center>
                <?php
                $fotosa = mysqli_query($connect, "SELECT * FROM fotos WHERE usuario = '$id' AND album = '$album' ORDER BY id_fot desc");
                while($fot=mysqli_fetch_array($fotosa))
                {
                ?>
                  <a href="#"><img src="publicaciones/<?php echo $fot['ruta'];?>" width="19%"> </a>
                <?php
                }
                ?>
                </center>