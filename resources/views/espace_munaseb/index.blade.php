<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Plate-forme EAsante</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/" rel="preconnect">
  <link href="https://fonts.gstatic.com/" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('theme/munaseb/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/munaseb/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/munaseb/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/munaseb/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/munaseb/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('theme/munaseb/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('theme/munaseb/css/main.css') }}" rel="stylesheet">


</head>

<body class="index-page">

  <header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelo d-flex align-items-center"><a href="#"></a></i>
          <i class="bi bi- d-flex align-items-center ms-4"><span></span></i>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index-2.html" class="logo d-flex align-items-center me-auto">
          <img src="theme/munaseb/img/logo1.jpg" alt="image">
          <h1 class="sitename">EAsante</h1>
        </a>

        <nav id="navmenu" class="navmenu">
          <ul>

            <li><a href="#hero" class="active">Acceuil<br></a></li>
            <li><a href="#services">Nos prestations</a></li>
            <li><a href="#departments">Faq</a></li>
            <li><a href="#about">A propos de nous</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="{{ url('login') }}">Se connecter / Créer un compte</a>

      </div>

    </div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section light-background">

      <img src="{{ asset('theme/munaseb/img/femme-medecin.jpg') }}" alt="" data-aos="fade-in">

      <div class="container position-relative">

        <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
          <h2>BIENVENUE SUR e-MUNASEB</h2>
          <p>Une plate-forme digitalisée pour la mutuelle estidiantine</p>
        </div><!-- End Welcome -->

        <div class="content row gy-4">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
              <h3>Pourquoi choisir e-MUNASEB?</h3>
              <p>
                e-MUNASEB est une plateforme moderne de gestion de la santé qui simplifie la vie des étudiants et des familles.
                Elle permet un suivi centralisé des prestations médicales, une prise en charge rapide et transparente,
                ainsi qu’un accès facilité aux informations et services de la mutuelle.

              </p>
              <div class="text-center">
                <a href="#about" class="more-btn"><span>savoir plus</span> <i class="bi bi-chevron-right"></i></a>
              </div>
            </div>
          </div><!-- End Why Box -->

          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="d-flex flex-column justify-content-center">
              <div class="row gy-4">

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                    <i class="bi bi-clipboard-data"></i>
                    <h4>suivi médical centralisé </h4>
                    <p>Un espace unique pour consulter vos dossiers de santé, vos prises en charge et vos remboursements.</p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                    <i class="bi bi-gem"></i>
                    <h4>Prise en charge rapide</h4>
                    <p>Des démarches simplifiées et un traitement accéléré de vos demandes pour gagner du temps.</p>
                  </div>
                </div><!-- End Icon Box -->

                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                    <i class="bi bi-inboxes"></i>
                    <h4>Accès partout à tout moment</h4>
                    <p>Votre mutuelle accessible en ligne 24h/24, que vous soyez chez vous, en déplacement ou à l’université.</p>
                  </div>
                </div><!-- End Icon Box -->

              </div>
            </div>
          </div>
        </div><!-- End  Content-->

      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4 gx-5">

          <div class="col-lg-6 position-relative align-self-start" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/first-aid-kit.png" class="img-fluid" alt="okdd">
            <a href="https://youtu.be/blzkhODYsu8" class="glightbox pulsating-play-btn"></a>
          </div>

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <h3>A propos de nous</h3>
            <p>
              e-MUNASEB est plus qu’une simple plateforme numérique : c’est une initiative portée par une vision solidaire et innovante de la santé.
              Notre mission est de garantir aux étudiants et à leurs familles une prise en charge fiable, tout en modernisant l’accès aux services de mutuelle..
            </p>
            <ul>
              <li>
                <i class="fa-solid fa-vial-circle-check"></i>
                <div>
                  <h5>solidarité et proximité</h5>
                  <p>Nous plaçons l’humain au cœur de notre action en accompagnant chaque adhérent avec attention.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-pump-medical"></i>
                <div>
                  <h5>Equité et accessibilité</h5>
                  <p>La santé doit être accessible à tous, sans distinction. Ecenou rend cela possible grâce à une plateforme simple et inclusive.</p>
                </div>
              </li>
              <li>
                <i class="fa-solid fa-heart-circle-xmark"></i>
                <div>
                  <h5>Innovation responsable</h5>
                  <p>Nous utilisons le numérique pour améliorer l’expérience de santé, tout en respectant la confidentialité et la sécurité des données.</p>
                </div>
              </li>
            </ul>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-solid fa-user-doctor"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="7" data-purecounter-duration="1" class="purecounter"></span>
              <p>Depot Pharmaceutique</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fa-regular fa-hospital"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="7000" data-purecounter-duration="1" class="purecounter"></span>
              <p>Mutualistes en moyenne/an </p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-flask"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="13" data-purecounter-duration="1" class="purecounter"></span>
              <p>Régions et sous régions</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
            <i class="fas fa-award"></i>
            <div class="stats-item">
              <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
              <p>Infirmerie</p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Nos prestations</h2>
        <p>La mutuelle de santé des étudiants Burkina Faso dispose plusieurs prestations. Parmi lesquels nous énumererons quelques uns sur la page ci-dessou</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
              <div class="icon">
                <i class="fas fa-heartbeat"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Consultation médical</h3>
              </a>
              <p>Accédez gratuitement aux consultations générales, gynécologiques, dentaires et ophtalmologiques dans les centres partenaires.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-pills"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Hospitalisation</h3>
              </a>
              <p>Bénéficiez d’une prise en charge intégrale des frais d’hospitalisation dans les structures agréées par la MUNASEB.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-hospital-user"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Médicament et analyse </h3>
              </a>
              <p>Profitez d’un remboursement à hauteur de 80% pour vos frais de pharmacie, analyses médicales et examens de laboratoire.</p>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-dna"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Lunetterie et soins dentaire</h3>
              </a>
              <p>Recevez une subvention pour vos frais liés à la lunetterie, aux soins dentaires et aux prothèses.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-wheelchair"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>suivi maternité et accouchement</h3>
              </a>
              <p>Accédez à des consultations prénatales et post-natales, ainsi qu’à une prise en charge partielle ou totale de l’accouchement.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item position-relative">
              <div class="icon">
                <i class="fas fa-notes-medical"></i>
              </div>
              <a href="#" class="stretched-link">
                <h3>Aide sociale funeraire</h3>
              </a>
              <p>Bénéficiez d’un soutien pour les frais funéraires et d’un accompagnement psychologique pour les étudiants en difficulté.</p>
              <a href="#" class="stretched-link"></a>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->

    <!-- Departments Section -->
    <section id="departments" class="departments section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Les modalités de prise en charge de la MUNASEB</h2>
        <p>La mutuelle des étudiants a plusieurs modalités de prise en charge de ses patients</p>
      </div><!-- End Section Title -->
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row">
          <div class="col-lg-3">
            <ul class="nav nav-tabs flex-column">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" href="#departments-tab-1">Tiers payant</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-2">Paiement direct</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-3">Forfait</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#departments-tab-4">Demande de remboursement</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href"#departments-tab-5"></a>
              </li>
            </ul>
          </div>
          <div class="col-lg-9 mt-4 mt-lg-0">
            <div class="tab-content">
              <div class="tab-pane active show" id="departments-tab-1">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Tiers payant</h3>
                    <p class="fst-italic">Avec le tiers payant, l’adhérent n’a pas besoin d’avancer les frais médicaux. </p>
                    <p>La mutuelle règle directement la part prise en charge auprès de l’hôpital, de la clinique ou de la pharmacie partenaire. L’adhérent ne paie que le reste non couvert.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="img/departments-1.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-2">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Prise en charge direct</h3>
                    <p class="fst-italic">En cas d’hospitalisation programmée ou d’acte médical important, la mutuelle délivre une “prise en charge” à l’établissement de santé. </p>
                    <p>Cela permet de réduire ou supprimer l’avance des frais élevés.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="img/departments-2.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-3">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Le forfait</h3>
                    <p class="fst-italic">La MUNASEB dispose des pharmacie partenaires dans toutes les villes où elle se trouve et également des infirmeries dans les cités universitaires leurs permettant d’agir en faveur des mutualistes si toute fois le produit médical est en manque à leurs dépôts pharmaceutique, </p>
                    <p> dans leurs infirmeries. Pour des cas ou certains soins sont inaccessible à leurs niveaux, une autorisation de soin dans les autres centres de santé est signée par un médecin de la MUNASEB à la guise du patient. Par conséquent, ces soins sont aux frais du malade et remboursable après l’authentification de sa demande de remboursement via ces ordonnances de soins.</p>
                  </div>
                  <div class="col-lg-4 text-center order-1 order-lg-2">
                    <img src="img/departments-3.jpg" alt="" class="img-fluid">
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="departments-tab-4">
                <div class="row">
                  <div class="col-lg-8 details order-2 order-lg-1">
                    <h3>Les fraix funeraire</h3>
                    <p class="fst-italic">La mutuelle nationale de santé des étudiant burkinabè ne se limitte pas uniquement à la subvention des soins sanitaire</p>
                    <p>Outre , elle songe à venir en aide aux mutualistes victime de desastre naturel.</p>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="img/assets/unhappy.png" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
                <div class="tab-pane" id="departments-tab-5">
                  <div class="row">
                    <div class="col-lg-8 details order-2 order-lg-1">
                      <h3>condition d'inscription</h3>
                      <p class="fst-italic">Etre étudiant inscrit dans une université public ou privé conventioné</p>
                      <p>Ou etre un conjoint(e) ou enfant d'un mutualiste; avoire les paiers justificatifs</p>
                    </div>
                    <div class="col-lg-4 text-center order-1 order-lg-2">
                      <img src="img/departments-5.jpg" alt="" class="img-fluid">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>

    </section><!-- /Departments Section -->

    <!-- Doctors Section -->
    <section id="doctors" class="doctors section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Aides</h2>
        <p>La plateforme MUNASEB propose un ensemble de services mutualistes accessibles en ligne, conçus pour simplifier les démarches des adhérents, garantir la traçabilité des opérations
          et renforcer la sécurité documentaire à chaque étape du parcours.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="img/doctors/doctors-1.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Adhésion mutualiste </h4>
                <span>l'Etudiant(e)/conjoint(e)/enfant</span>
                <p>L’étudiant souhaitant adhérer à la mutuelle doit :<br<
                    Se munir de ses pièces justificatives :<br> carte d’étudiant ou attestation d’inscription, reçu de paiement
                    Se connecter sur la plateforme via son compte personnel.<br>
                    Accéder au formulaire d’adhésion et renseigner ses informations (nom, université, statut…).<br>
                    Téléverser les fichiers justificatifs demandés.<br> Soumettre la demande, qui sera ensuite vérifiée par la régie, puis validée par le directeur.
                    <br>Objectif : Simplifier l’inscription sans déplacement physique,
                    tout en garantissant la traçabilité et la sécurité des données.</p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                  <a href="#"> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="img/doctors/doctors-2.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Demande de remboursement</h4>
                <span>Mutualiste</span>
                <p>
                  Pour soumettre une demande de remboursement, l’adhérent doit :<br>
                  Se connecter à son espace personnel sur la plateforme.<br>
                  Accéder au formulaire de demande de remboursement.<br>
                  Renseigner les détails de la prestation (date, type de soin, montant total, etc.).<br>
                  Téléverser les justificatifs requis (ordonnance, facture, etc.).<br>
                  Soumettre la demande pour traitement par la régie.<br>
                  Objectif : Permettre un traitement rapide et transparent des remboursements,
                  avec un suivi en temps réel pour l’adhérent.
                </p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                  <a href="#"> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="img/doctors/doctors-3.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Reabonnement</h4>
                <span>Ancien mutualiste</span>
                <p>
                  Pour se réabonner, l’ancien adhérent doit :<br>
                  Se connecter à son compte sur la plateforme.<br>
                  Accéder à la section de réabonnement.<br>
                  Vérifier et mettre à jour ses informations personnelles si nécessaire.<br>
                  Choisir le type de couverture souhaitée pour la nouvelle période.<br>
                  Effectuer le paiement en ligne via les options proposées.<br>
                  Soumettre la demande de réabonnement pour validation.<br>
                  Objectif : Faciliter le renouvellement de l’adhésion sans paperasse,
                  tout en assurant la continuité de la couverture santé.
                </p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                  <a href="#"> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="img/doctors/doctors-4.jpg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Suivi de demande</h4>
                <span>Mutualiste</span>
                <p>
                  Pour suivre l’état de ses demandes, l’adhérent doit :<br>
                  Se connecter à son espace personnel sur la plateforme.<br>
                  Accéder à la section “Mes demandes” ou “Suivi des demandes”.<br>
                  Consulter le statut de chaque demande (en cours, approuvée, rejetée, etc.).<br>
                  Recevoir des notifications automatiques par email ou SMS pour chaque mise à jour.<br>
                  Contacter le support via la plateforme en cas de questions ou de problèmes.<br>
                  Objectif : Offrir une transparence totale sur le traitement des demandes,
                  avec un accès facile aux informations et un support réactif.
                </p>
                <div class="social">
                  <a href="#"><i class="bi bi-twitter-x"></i></a>
                  <a href="#"><i class="bi bi-facebook"></i></a>
                  <a href="#"><i class="bi bi-instagram"></i></a>
                  <a href="#"> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Doctors Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Les question frequentes</h2>
        <span>FAQ</span>
        <p>Trouvez ici les réponses aux questions les plus courantes sur les services mutualistes de MUNASEB</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>Comment adhérer a la munaseb?</h3>
                <span>Adhérez en ligne en quelques étapes simples.</span>
                <div class="faq-content">
                  <p> Adhésion à la mutuelle étudiante :<br>Créez votre compte, <br> se connecter de son compte <br> acceder au menu adhésion remplissez le formulaire
                    <br>et téléversez vos pièces justificatives pour bénéficier des services mutualistes.
                    <br>Pourquoi ce changement :
                    <br>Rend le processus plus explicite
                    <br>Met en avant les étapes clés
                    Valorise la sécurité et l’autonomie
                  </p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Comment soumettre sa demande de remboursement?</h3>
                <span>Soumettez vos factures et ordonnances en ligne. </span>
                <div class="faq-content">
                  <p></p>
                  <p>Connectez-vous à votre espace personnel, accédez au formulaire de demande de remboursement,
                    renseignez les détails, téléversez les justificatifs, puis soumettez pour traitement.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
              <div class="faq-item">
                <h3>Comment faire le réabonnement de la mutuelle?</h3>
                <span>Renouvelez votre adhésion en ligne.</span>
                <div class="faq-content">
                  <p>Connectez-vous à votre compte, accédez à la section de réabonnement, mettez à jour vos informations si nécessaire, choisissez votre couverture,
                    effectuez le paiement de la cotisation et soumettez pour validation.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Comment suivre en temps réel sa demande de remboursement de ?</h3>
                <span>Suivez l’état de vos demandes en ligne.</span>
                <div class="faq-content">
                  <p>Connectez-vous à votre espace personnel, accédez à la section “Mes demandes”,
                    consultez le statut de chaque demande, recevez des notifications pour chaque mise à jour,
                    et contactez le support via la plateforme en cas de questions.</p>

                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Comment suivre son statut de reabonnement?</h3>
                <span>Suivez l’état de vos demandes en ligne.</span>
                <div class="faq-content">
                  <p>Connectez-vous à votre espace personnel, accédez à la section “Mes demandes”,
                    consultez le statut de chaque demande de reabonnement, recevez des notifications pour chaque mise à jour,
                    et contactez le support via la plateforme en cas de questions.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3>Comment faire en cas d'inaccessibiloité de la plate-forme?</h3>
                <span>Contactez le support technique.</span>
                <div class="faq-content">
                  <p>En cas de problème de connexion ou une inaccessibilité total de la plateforme, se rendre dans un centre de la mutuelle la plus proche pour une assistance urgente</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <div class="container">

        <div class="row align-items-center">

          <div class="col-lg-5 info" data-aos="fade-up" data-aos-delay="100">
            <h3>Témoignage</h3>
            <span> Que disent nos adhérents sur les services mutualistes de MUNASEB</span>
            <p>

            </p>
          </div>

          <div class="col-lg-7" data-aos="fade-up" data-aos-delay="200">

            <div class="swiper init-swiper">
              <script type="application/json" class="swiper-config">
                {
                  "loop": true,
                  "speed": 600,
                  "autoplay": {
                    "delay": 5000
                  },
                  "slidesPerView": "auto",
                  "pagination": {
                    "el": ".swiper-pagination",
                    "type": "bullets",
                    "clickable": true
                  }
                }
              </script>
              <div class="swiper-wrapper">

                <div class="swiper-slide">
                  <div class="testimonial-item">
                    <div class="d-flex">
                      <img src="img/testimonials/testimonials-1.jpg" class="testimonial-img flex-shrink-0" alt="">
                      <div>
                        <h3>Mutualiste</h3>
                        <h4>identité&amp;reservé </h4>
                        <div class="stars">
                          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                    </div>
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <span> Lorsque j’ai eu besoin d’une consultation urgente, la MUNASEB a pris en charge les frais sans délai.<br> J’ai été soulagée de pouvoir me concentrer sur ma guérison</span>
                      <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-item">
                    <div class="d-flex">
                      <img src="img/testimonials/testimonials-2.jpg" class="testimonial-img flex-shrink-0" alt="">
                      <div>
                        <h3>Conjoint Mutualiste</h3>
                        <h4>droit d'identité reservé</h4>
                        <div class="stars">
                          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                    </div>
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <span>Grâce à la MUNASEB, j’ai pu effectuer mes examens médicaux dans un centre de qualité. <br>Leur accompagnement m’a permis de poursuivre mes recherches sereinement.</span>
                      <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-item">
                    <div class="d-flex">
                      <img src="img/testimonials/testimonials-3.jpg" class="testimonial-img flex-shrink-0" alt="">
                      <div>
                        <h3>Enfant d'un Mutualiste</h3>
                        <h4>respect au droit d'identité</h4>
                        <div class="stars">
                          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                    </div>
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <span> J’ai pu consulter l’historique de mes remboursements et télécharger mes reçus.<br> Tout est centralisé et bien organisé.</span>
                      <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-item">
                    <div class="d-flex">
                      <img src="img/testimonials/testimonials-4.jpg" class="testimonial-img flex-shrink-0" alt="">
                      <div>
                        <h3>Etudiant LM</h3>
                        <h4>identité reservé</h4>
                        <div class="stars">
                          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                    </div>
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <span>J’ai pu créer mon compte et soumettre ma première demande de remboursement en moins de 10 minutes. <br>La plateforme est vraiment intuitive</span>
                      <i class="bi bi-quote quote-icon-right"></i>
                    </p>
                  </div>
                </div><!-- End testimonial item -->

                <div class="swiper-slide">
                  <div class="testimonial-item">
                    <div class="d-flex">
                      <img src="img/testimonials/testimonials-5.jpg" class="testimonial-img flex-shrink-0" alt="">
                      <div>
                        <h3>Etudiant MPI</h3>
                        <h4>identifiant</h4>
                        <div class="stars">
                          <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                      </div>
                    </div>
                    <p>
                      <i class="bi bi-quote quote-icon-left"></i>
                      <span>Je reçois des notifications à chaque étape :<br> soumission, validation, remboursement. C’est rassurant et transparent. </span>
                    </p>
                  </div>
                </div><!-- End testimonial item -->

              </div>
              <div class="swiper-pagination"></div>
            </div>

          </div>

        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <style>
      .gallery {
        padding: 30px 0;
      }

      .gallery-slider {
        display: flex;
        gap: 10px;
        overflow: hidden;
        /* Masque les images hors de la zone visible */
        scroll-behavior: smooth;
      }

      .gallery-slider img {
        width: 50%;
        /* Deux images visibles à la fois */
        height: 250px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
      }

      .gallery-controls {
        display: flex;
        justify-content: center;
        margin-top: 10px;
        gap: 15px;
      }

      .gallery-controls button {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s;
      }

      .gallery-controls button:hover {
        background: #0056b3;
      }
    </style>

    <section id="gallery" class="gallery section">
      <div class="container section-title">
        <h2>Gallery</h2>
        <p>Quelques images illustratives du personnel soignant dans leurs centres d'opérations</p>
      </div>

      <div class="gallery-slider" id="gallerySlider">
        <img src="theme/munaseb/img/close-up.jpg" alt="">
        <img src="theme/munaseb/img/medecin-femme.jpg" alt="">
        <img src="theme/munaseb/img/laboratoire.jpg" alt="">
        <img src="theme/munaseb/img/stock-photo1.jpg" alt="">
        <img src="theme/munaseb/img/stock-photo0.jpg" alt="">
        <img src="theme/munaseb/img/stock-photo.jpg" alt="">
        <img src="theme/munaseb/img/femme-medecin.jpg" alt="">
      </div>

      <div class="gallery-controls">
        <button id="prevBtn">&#8249;</button>
        <button id="nextBtn">&#8250;</button>
      </div>

      <script>
        const slider = document.getElementById('gallerySlider');
        const images = slider.querySelectorAll('img');
        const imgWidth = slider.clientWidth / 2; // largeur correspondant à deux images visibles
        let autoScroll;

        // Fonction de défilement
        function scrollGallery(offset) {
          slider.scrollBy({
            left: offset,
            behavior: 'smooth'
          });
        }

        document.getElementById('prevBtn').addEventListener('click', () => {
          scrollGallery(-imgWidth);
          resetAutoScroll();
        });

        document.getElementById('nextBtn').addEventListener('click', () => {
          scrollGallery(imgWidth);
          resetAutoScroll();
        });

        // Défilement automatique toutes les 3 secondes
        function startAutoScroll() {
          autoScroll = setInterval(() => {
            scrollGallery(imgWidth);
          }, 3000);
        }

        function resetAutoScroll() {
          clearInterval(autoScroll);
          startAutoScroll();
        }

        startAutoScroll();
      </script>
    </section>


    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <p>Nous sommes à votre disposition, veuillez nous laisser un message</p>
      </div><!-- End Section Title -->

      <div class="mb-5" data-aos="fade-up" data-aos-delay="200">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d243.56651395137578!2d-1.5010443045804962!3d12.378630305953479!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xe2ebf5cac2c8655%3A0xedd04810092e6666!2sMutuelle%20Nationale%20de%20Sant%C3%A9%20des%20%C3%89tudiants%20du%20Burkina%20(MUNASEB)!5e0!3m2!1sfr!2sbf!4v1759339110422!5m2!1sfr!2sbf"
          width="100%"
          height="270"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-4">
            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-geo-alt flex-shrink-0"></i>
              <div>
                <h3>Localisation</h3>
                <p>9FHW+9M9 MUNASEB,Ouagadougou</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-telephone flex-shrink-0"></i>
              <div>
                <h3>Téléphone</h3>
                <p>+22670000000</p>
              </div>
            </div><!-- End Info Item -->

            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-envelope flex-shrink-0"></i>
              <div>
                <h3>Email de service</h3>
                <p>infoecenou@gmail.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="col-lg-8">
            <form action="https://themewagon.github.io/MediLab/forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Nom complet" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Gmail" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Objet" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="soyez brèf et direct dans votre Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Ton message est bien reçu , merci!</div>

                  <button type="submit">envoyer</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index-2.html" class="logo d-flex align-items-center">
            <span class="sitename">Centre de MUNASEB</span>
          </a>
          <div class="footer-contact pt-3">
            <p>9FHW+9M9,OUAGADOUGOU</p>
            <p>Burkina Faso</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+22670000000</span></p>
            <p><strong>Email:</strong> <span>infoecenou@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Liens rapides</h4>
          <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Nos prestation</a></li>
            <li><a href="#">Actualités</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">A propos de nous</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nos prestations</h4>
          <ul>
            <li><a href="#">Tiers payant</a></li>
            <li><a href="#">Payement direct</a></li>
            <li><a href="#">Forfait</a></li>
            <li><a href="#">Demande de remboursement</a></li>
            <li><a href="#">Voir plus...</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Nous Contacter</h4>
          <ul>
            <li><a href="#">+22670000000</a></li>
            <li><a href="#">Email: easante@gmail.com</a></li>
            <li><a href="#">ville :Ouagadougou</a></li>
            <li><a href="#">quartier : Kossodo</a></li>
            <li><a href="#">Voir plus ...</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Pourquoi Nous?</h4>
          <ul>
            <li><a href="#">un suivi medical centralisé</a></li>
            <li><a href="#">Prise en charge rapide</a></li>
            <li><a href="#">Accès partout 24h/7</a></li>
            <li><a href="#"> Cout de soins reduit</a></li>
            <li><a href="#">Voir plus ....</a></li>
          </ul>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">EAsante</strong> <span>Tout droit reservé</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('theme/munaseb/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('theme/munaseb/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('theme/munaseb/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('theme/munaseb/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('theme/munaseb/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('theme/munaseb/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('theme/munaseb/js/main.js') }}"></script>

</body>

</html>