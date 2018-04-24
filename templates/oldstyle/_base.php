<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
    <div id="info-dialog" title="" style="display: none;"></div>
    <div class="wrapper">


        <?php include 'header.php'; ?>

        <?php include 'menu-top.php'; ?>

        <main class="content-w">
            
            <?php include $content['content']; ?>

        </main>

        <footer class="footer-menu">
            <div class="container-w">
                <?php include 'footer-left-info.php'; ?>

                <?php include 'menu-footer.php'; ?>
            </div>
        </footer>

        <?php include 'footer.php'; ?>


    </div>    
</body>
    


</html>


