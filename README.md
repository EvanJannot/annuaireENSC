
<h1>Introduction</h1>
        <p>Ce projet a pour but de modéliser et de créer une base de données puis de programmer des pages web d’un site d’annuaire d’anciens élèves de l’École Nationale Supérieure de Cognitique à l’aide des technologies HTML5/CSS/Bootstrap/PHP/MySQL. Cette plateforme doit constituer une aide aux élèves pour la recherche de stage ou d’emploi et doit permettre de consulter les emplois occupés par les anciens élèves de l’école. Il s’est déroulé du 26 février 2021 au 2 avril 2021. </p>
        
<h2>Planning prévisionnel</h2>  

<p align="center">
  <img src="https://user-images.githubusercontent.com/79797037/156944971-ca6237ac-eb59-4e0a-b5f5-cf1cc3c165c3.PNG">
</p>

<p>Afin de nous fixer des objectifs et pour notre organisation, nous avons élaboré un planning prévisionnel en nous fixant des deadline réalisables. Nous sommes donc arrivés au planning ci-dessus.</p>
        
<h2>Planning final</h2> 

<p align="center">
  <img src="https://user-images.githubusercontent.com/79797037/156944990-478f9256-b815-4b62-9ee4-37f8575b93f3.PNG">
</p>

<p>Voici le planning que nous avons suivi. Nous pouvons constater des différences avec le prévisionnel. En effet, la partie MCD a été sous estimée (voir Conclusion) et l’arborescence a été défini dès le départ. La création de la BDD a été plus rapide que prévu grâce à la génération des requêtes par Looping. La partie HTML a été réalisée légèrement plus rapidement que prévu et la partie PHP a été bien prévue. Pour ce qui est de la rédaction du rapport nous constatons un décalage, car nous avons décidé de réaliser plus tôt cette étape dès lors que la partie PHP était sur sa fin.</p>

<h2>Répartition des tâches</h2>
        <p>Les tâches ont été réparties de la manière suivante au sein du binôme :</p>
	
<p align="center">
  <img src="https://user-images.githubusercontent.com/79797037/156945024-50bb3a37-0485-4c45-b7b4-5ccd17bae6ef.PNG">
</p>

<p>De plus, afin d’avoir une meilleure organisation et une vision globale de l’avancée du projet, nous avons mis en place un trello, un outil de gestion de projet permettant à l’aide d’étiquettes, de définir l’état d’une tâche (à faire, en cours, fait, bloqué) et de définir qui doit la faire.</p>

<h1>Modélisation</h1>

<h2>Hypothèses pour le MCD et MCD</h2> 

<p>À l’aide de l’énoncé, nous avons émis différentes hypothèses qui nous ont permis de définir les tables à créer ainsi que les liens entre ces dernières.</p>

<ul>
<li>Tout d’abord nous avons défini les tables “Elève” et “Gestionnaire” qui correspondent aux deux types d’utilisateurs qui seront présents sur notre annuaire. Ces dernières sont composées des informations personnelles qui définissent les utilisateurs et d’un login et d’un mot de passe. Le lien est de type 1,1 d'élève vers Gestionnaire et 1,n de Gestionnaire vers Elève. En effet, un élève est accepté par un et un seul gestionnaire tandis qu’un gestionnaire accepte 1 à n élèves.</li>

<li>Ensuite nous avons défini la table “Expérience”. Celle-ci contient certaines informations nécessaires afin de définir une expérience. Le lien avec Élève est de 0,n dans le sens Elève/Expérience, car un élève peut ne pas avoir d’expérience ou en avoir n et est de 1,1 dans le sens Expérience/Élève car une expérience est associée à un et un seul élève.</li> 
	
<p>Certaines informations comme l’organisme, le ou les secteurs et la ou les compétences ont été placées dans des tables à part.</p>
	
<li>La table Organisme comporte toutes les informations sur un organisme, son nom, le type d’organisme, l’adresse et le département. Mettre ces informations dans la table Expérience aurait surchargé cette dernière. Le lien est de 0,n dans le sens Organisme/Expérience, car un organisme peut être associé à aucune expérience comme à n expériences et il est de 1,1 dans le sens opposé, car une expérience est liée à un seul et unique organisme.</li>

<li>La table Secteur a été séparée de la table Expérience après que nous ayons émis l’hypothèse qu’une expérience pouvait appartenir à plusieurs secteurs. Ainsi, puisque le nombre de secteurs est indéfini et peut être élevé, nous avons décidé de séparer les deux tables pour que l’organisation soit plus claire. Ainsi le lien entre Expérience et Secteur est de 1,n dans le sens Expérience/Secteur, car une expérience peut appartenir à un secteur comme à n et est de 0,n dans l’autre sens, car un secteur peut n’appartenir à aucune expérience comme à n.</li>

<li>La table Compétences a été séparée pour les mêmes raisons que la table Secteur. Nous retrouvons donc les mêmes liens entre les deux tables.</li>	
	
</ul>

<p>Ainsi nous obtenons le MCD suivant :  </p>

<p align="center">
  <img src="https://user-images.githubusercontent.com/79797037/156945180-fd57fd11-f89d-4191-9bc0-7b8137605df9.PNG">
</p>

<h2>Dictionnaire des données</h2>

<p>Voici le dictionnaire de données issue de notre MCD :</p>

<p align="center">
  <img src="https://user-images.githubusercontent.com/79797037/156945265-b4db3fb8-851d-4db6-a3fd-34079c2a6016.PNG">
  <img src="https://user-images.githubusercontent.com/79797037/156945310-b94b8593-b7b6-4430-8585-2c06ddc75804.PNG">
</p>

<h2>Schéma relationnel</h2>

<p>Voici le schéma relationnel (MLD) obtenu à partir du MCD :</p>

```
Gestionnaire = (id COUNTER, nom VARCHAR(50), prenom VARCHAR(50), login VARCHAR(50), mdp VARCHAR(50));


Compétences = (idCom COUNTER, nom VARCHAR(50));


Organisme = (idOrg COUNTER, type_ VARCHAR(50), adresse VARCHAR(50), nom VARCHAR(50), departement VARCHAR(50));


Secteur = (idSec COUNTER, nom VARCHAR(50));


Elève = (id COUNTER, nom VARCHAR(50), prenom VARCHAR(50), promotion INT, adresseP VARCHAR(50), adresseE VARCHAR(50), telephone INT, sexe VARCHAR(50), validation LOGICAL, age INT, login VARCHAR(50), mdp VARCHAR(50));


Expérience = (idExp COUNTER, ddd DATE, ddf DATE, type VARCHAR(50), description VARCHAR(200), salaire CURRENCY, #idOrg, #id);


Porte_sur = (#idExp, #idCom);


Est_dans = (#idExp, #idSec);
```

<h2>Maquette des écrans</h2>

<p>Les maquettes des différents écrans ont été réalisées à l’aide du logiciel Adobe XD et du pack WireFrame disponible gratuitement. Des changements ont été apportés au cours de la programmation du site web que ce soit dans l’apparence et la disposition des éléments. Cependant, une majeure partie des éléments est restée identique. Les maquettes se trouvent en annexes (voir annexe 1 à 7).</p>

<h1>Site web</h1>

<h2>Arborescence du projet</h2>

<h2>Justification de l’organisation du site</h2>

<p>Le site est pensé pour deux types d’utilisateurs, les utilisateurs lambdas qui sont les élèves et les gestionnaires. En fonction du type de comptes, l’accès aux pages web sera différent. Cependant, la première page est la même pour tous les utilisateurs. C’est celle de connexion.</p>

<h3>Utilisateur lambda </h3>

<p>Lorsqu’un utilisateur arrive sur le site, la première page à laquelle il accède est celle de connexion. En effet, un utilisateur non connecté ne doit pas avoir accès à l’annuaire de l’ENSC. Sur cette page de connexion, il est possible de s’inscrire et d’accéder à une page d’inscription. Une fois l’inscription finalisée, l’utilisateur est redirigé vers la page de connexion.</p>

<p>Une fois que l’utilisateur a un compte, si ce dernier a été validé par le gestionnaire, il peut se connecter et accéder à la page d’accueil. Sur cette dernière, il peut visualiser l’ensemble des personnes de l’annuaire et trier selon différents critères les profils (compétences, secteurs, département) Depuis cette page, il peut cliquer sur le profil d’une personne de l’annuaire afin de le consulter ou depuis la barre de navigation, cliquer sur l’onglet “Mon profil” afin d’accéder à son propre profil.</p>

<ul>
<li>S’il a choisi de consulter le profil d’un autre utilisateur, il aura accès à ses informations publiques ainsi qu’à l’ensemble des expériences ayant été ajoutées par la personne. </li>
	
<li>S’il a choisi de consulter son profil alors il peut consulter ses propres informations et peut choisir de les modifier. En plus de cela il peut s’il le désire ajouter ou supprimer une expérience.</li>
</ul>
	
<h3>Gestionnaire </h3>

<p>Le gestionnaire passe par la même page de connexion qu’un utilisateur lambda. En se connectant, il arrive sur la même page d’accueil cependant, à la place de l’onglet mon profil dans la barre de navigation, il a accès à la liste des inscriptions à accepter.</p>

<ul>
<li>S’il choisit d’accéder à la liste des inscriptions à accepter, il visualise une liste sous la même forme que la page d’accueil avec la possibilité de cocher chaque personne à accepter ou de cocher l’ensemble des personnes à la fois afin de valider leur inscription. </li>
<li>S’il choisit de consulter les informations d’un utilisateur, il verra l’ensemble de ses informations publiques.</li>
<li>S’il choisit de créer un compte pour un élève, il se retrouvera sur la page de création de compte.</li>
</ul>

<h2>Rôle des fichiers PHP </h2>

<p>Nous pouvons distinguer deux catégories de fichiers PHP : les fichiers des pages web et les fichiers à inclure au sein des pages web afin d’éviter la duplication de code.</p>

<h3>Fichiers des pages web</h3>

<ul>
<li>accueil.php : Page comportant la liste des élèves inscrits dans l’annuaire. Elle comporte aussi la barre de recherche textuelle permettant de chercher une personne avec son nom et/ou son prénom. Il y a de plus des filtres permettant une recherche avancée avec les compétences, les secteurs et les départements. Une fois la recherche lancée avec des filtres, cela affiche la liste des élèves ayant des expériences correspondant aux filtres sélectionnés. Il y a aussi la liste des promotions, lorsque l’on clique sur l’une d'elles, on est redirigé vers la page promo.php. Pour qu’une promotion soit affichée, il faut que des élèves appartiennent à cette dernière.</li>
<li>ajoutexperience.php : Cette page contient un formulaire permettant à l’élève d’ajouter une expérience. Une fois ajoutée, l’utilisateur est redirigé vers la page de son profil (profil.php).</li>
<li>contact.php : Cette page contient une photo de notre binôme et nos coordonnées. Elle est accessible depuis la barre de navigation.</li>
<li>gestion.php : Cette page est accessible par le gestionnaire et permet de valider l’inscription d’un ou plusieurs élèves à la fois.</li>
<li>login.php : Page comprenant le formulaire de connexion afin d’accéder au site. Une fois connecté, l’utilisateur est redirigé vers la page d’accueil (accueil.php).</li>
<li>logout.php : Page servant à détruire la session et à déconnecter l’utilisateur. Elle redirige vers la page login.php.</li>
<li>modifprofil.php : Page avec le formulaire permettant à un élève connecté de modifier ses informations personnelles.</li>
<li>profil.php  : Page permettant à un élève de consulter son profil, depuis son profil, il peut modifier ses informations personnelles (modifprofil.php) et ajouter une expérience (ajoutexperience.php). Cette page permet aussi de consulter le profil d’un autre élève de manière passive (impossible de modifier ses informations).</li>
<li>register.php : Page comprenant le formulaire d’inscription pour un élève. Une fois l’inscription terminée, l’utilisateur est redirigé vers la page login.php.</li>
<li>promo.php : Page comprenant l’ensemble des élèves appartenant à une promotion. La promotion est récupérée par l’URL grâce à l’id.</li>
</ul>
	
<h3>Fichiers à inclure</h3>

<ul>
<li>footer.php : Ce fichier contient la barre noire située en bas des pages et est purement esthétique.</li>
<li>functions.php : Ce fichier contient les fonctions PHP utilisées au sein des différentes pages web.</li>
<li>head.php : Ce fichier contient l’ensemble des informations à fournir dans le head à savoir l’encodage, l’emplacement des librairies, du fichier CSS et le titre de la page.</li>
<li>navbar.php : Ce fichier contient la barre de navigation utilisée dans toutes les pages web et qui évolue en fonction de l’état de l’utilisateur (connecté ou non) et en fonction du type de compte (élève ou gestionnaire). Elle permet de se déconnecter, d’accéder à la page contact.php, de retourner à l’accueil. Si l’utilisateur est un élève, il peut aussi accéder à son profil (profil.php) et si c’est un gestionnaire il peut inscrire un élève (register.php) et consulter les demandes de validation (gestion.php).</li>
<li>scripts.php : Ce fichier contient les scripts à placer en fin de fichier PHP afin de rendre la navigation au sein des pages web fluide.</li>
</ul>

<h2>Visualisation des écrans web finaux</h2>

<p>L’ensemble des écrans web sont disponibles en annexe (annexe 8 à 17) et permettent de visualiser à quoi ressemble notre version définitive du site.</p>

<h1>Plan de tests</h1>

<p>Afin de vérifier le bon fonctionnement de notre site, nous avons mis en œuvre une série de tests permettant de valider le bon fonctionnement de l’ensemble des fonctionnalités présentes sur ce dernier.</p>

<ul>
<li>Test 1 : 
  Un élève doit s’inscrire et créer son compte. Il est en attente de validation.</li>

<li>Test 2 :
  Un gestionnaire se connecte.</li>

<li>Test 3 :
  Un gestionnaire valide un compte en attente.</li>

<li>Test 4 :
  Un gestionnaire inscrit un élève.</li>

  <li>Test 5 :
    Un élève dont le compte est validé se connecte.</li>

<li>Test 6 :
  Un élève connecté consulte le profil d’un autre élève.</li>

<li>Test 7 :
  Un élève modifie es informations personnelles.</li>

  <li>Test 8 :
    Un élève ajoute une expérience.</li>

<li>Test 9 :
  Un utilisateur effectue une recherche textuelle.</li>

<li>Test 10 :
  Un utilisateur effectue une recherche par filtres.</li>

<li>Test 11 :
Un utilisateur sélectionne une promotion afin de visualiser les élèves appartenant à cette dernière.</li>

<h1>Conclusion</h1>

<p>La première difficulté que nous avons pu rencontrer est liée au MCD. En effet, ce dernier a été plus compliqué à élaborer que prévu. Cela vient du grand nombre d’éléments à inclure dans notre modélisation ainsi que la gestion de leurs liens. Par exemple, nous avions un souci lié aux secteurs et aux compétences, car si nous voulions en ajouter plusieurs à une expérience, il aurait fallu initialiser de nombreuses variables au sein de la table Expériences qui parfois n’auraient pas été utilisées et nous aurions pu être limités si une expérience contenait un grand nombre de compétences. Ainsi, pour résoudre ce problème, nous sommes passés par des tables externes Compétences et Secteurs en utilisant des tables faisant jonction porte sur et est dans.</p>

<p>La deuxième difficulté découle directement de la première, car en passant par des tables intermédiaires, la manipulation des données de la BDD était plus complexe, mais après avoir compris la manière de procéder et d’implémenter le tout au code, nous avons pu surmonter cette difficulté. </p>

<p>La recherche avec filtres a aussi été une partie qui nous a posé des problèmes. En effet, afin d’obtenir un filtrage gagnant en précision lorsque nous combinons les filtres, il a fallu traiter différents cas de figures ce qui a entraîné une complexification du code. Mais nous avons tout de même réussi à obtenir un filtrage efficace et précis. </p>

<p>Nous ne sommes pas parvenus à implémenter un système de confidentialité des données par manque de temps. Nous avions tout de même pensé à une méthode pour cela. Créer une table Confidentialité liée à la table Élève qui contiendrait un booléen par information de l’élève et l’id de l’élève ce qui permettrait en fonction de la valeur de ces booléens d’afficher ou non les informations de l’élève lorsque sa page est consultée. Pour régler cela, l’élève aurait coché ou non des cases dans le formulaire de modification du profil (modifprofil.php)</p>

<p>Cependant, nous avons intégré une fonctionnalité bonus, la page contact.php accessible depuis la barre de navigation et qui permet d’avoir accès à notre adresse email ainsi qu’à une photo de nous deux. Cela permet entre autres de signer notre projet.</p>


<p>Ainsi nous sommes parvenus à obtenir le site disponible à l’adresse suivante : https://annuaire-ensc-jannot-lucas.000webhostapp.com/ </p>


<p>Cette version en ligne dispose de toutes les fonctionnalités décrites au sein de ce rapport et est parfaitement fonctionnelle. Nous l’avons hébergé sur la plateforme 000webhost, pour se faire nous avons importé notre base de donnée puis notre code après avoir effectué les modifications nécessaires à ce dernier pour que la connexion à la base de donnée se fasse correctement. Pour ce qui est des identifiants et mot de passe pour tester notre site, vous les trouverez au sein du fichier SQL disponible dans l’archive même où se trouve ce rapport dans le dossier projet-2021-jannot-lucas/db.</p>
