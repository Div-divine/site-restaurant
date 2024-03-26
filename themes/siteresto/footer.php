</div>
<footer class="main-footer mt-5">
    <div class="footer-container">
        <div class="footer-menu-items-container">
            <?php wp_nav_menu(
                [
                    'menu' => 'footer-menu',
                    'container' => false,
                    'menu_class' => 'footer-menu-items'
                ]
            ) ?>
        </div>
        <div class="copyright">
            &copy; Copyright
            <?php echo date('Y'); ?> Tous les droits reservés.
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>

</html>