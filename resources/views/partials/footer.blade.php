<footer class="munaseb-footer">
    <div class="footer-container">

        <!-- Logo & description -->
        <div class="footer-section footer-logo">
            <h3>MUNASEB</h3>
            <p>Mutuelle Nationale de Santé des Étudiants du Burkina Faso.  
            Couverture, sécurité et engagement pour votre santé.</p>
        </div>

        <!-- Liens rapides -->
        <div class="footer-section footer-links">
            <h4>Liens rapides</h4>
            <ul>
                <li><a href="{{ route('dashboard.etudiant') }}">Accueil</a></li>
                <li><a href="{{ route('munaseb.adherant.adhesionstep1') }}">Nouvelle adhésion</a></li>
                <li><a href="{{ route('demande.verifier') }}">Vérifier ma demande</a></li>
                <li><a href="#">Téléchargement</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="footer-section footer-contact">
            <h4>Contact</h4>
            <p>Email : contact@munaseb.bf</p>
            <p>Téléphone : +226 25 00 00 00</p>
            <p>Ouagadougou, Burkina Faso</p>
        </div>

        <!-- Réseaux sociaux -->
        <div class="footer-section footer-social">
            <h4>Réseaux sociaux</h4>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

    </div>

    <!-- Bas de page -->
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} MUNASEB. Tous droits réservés. | <a href="#">Mentions légales</a></p>
    </div>
</footer>