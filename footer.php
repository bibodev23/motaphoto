</main>
<footer>
    <?php 
    get_template_part('templates_part/modal');
    get_template_part('templates_part/lightbox');
    ?>
    <div class="footer-links">
        <ul>
            <li><a href="<?php echo esc_url( home_url( '/mentions-legales' ) ); ?>">mentions légales</a></li>
            <li><a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">vie privée</a></li>
            <li><a href="">tous droits réservés</a></li>
        </ul>
    </div>
</footer>
</body>
</html>