<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<style>
@page { margin: 30px 40px; }

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #1f2d3d;
}

h1 {
    text-align: center;
    color: #1f4e79;
    font-size: 18px;
}

h2 {
    color: #1f4e79;
    font-size: 13px;
    border-bottom: 1px solid #1f4e79;
    padding-bottom: 2px;
}

.header-box {
    text-align: center;
}

.formation-title {
    font-weight: bold;
    text-transform: uppercase;
    font-size: 13px;
    margin-bottom: 4px;
    letter-spacing: 0.5px;
}

.infos-line {
    display: table;
    width: 100%;
    margin-bottom: 10px;
    font-size: 12px;
}

.infos-line span {
    display: table-cell;
    width: 50%;
    text-align: center;
}


.academy-bar {
    background: #1f4e79;
    color: #fff;
    text-align: center;
    padding: 6px;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td {
    vertical-align: top;
    width: 50%;
    padding: 0 8px;
}

ul {
    padding-left: 18px;
}

li {
    margin-bottom: 4px;
}

.image {
    width: 100%;
    margin: 8px 0;
}

.img {
    width: 35%;
    margin-top: 120px;
    margin-left: 220px;
}

.img1 {
    width: 60%;
    margin-left: 220px;
}

.page-break {
    page-break-after: always;
}

.footer {
    margin-top: 20px;
    text-align: center;
    font-size: 9px;
    color: #555;
}
</style>
</head>

<body>

<!-- ================= PAGE 1 ================= -->

<h1>PROGRAMME DE FORMATION</h1>

<div class="header-box">
    <div class="formation-title">
        <span><strong>{{$langue}} – Formation Flexible {{$duree}}h avec Certification {{$certification}}</strong></span>
    </div>

    <div class="infos-line">
        <span><strong>Élève :</strong> {{ $eleve }}</span>
        <span><strong>Date de formation :</strong> du {{ \Carbon\Carbon::parse($dateDu)->format('d/m/Y') }}
 au {{ \Carbon\Carbon::parse($dateAu)->format('d/m/Y') }}
</span>
    </div>
</div>


<div class="academy-bar">THE INSPIRE ACADEMY</div>

<img class="image" src="{{ public_path('storage/student-photos/programme-formation.png') }}">

<table>
<tr>
<td>

<h2>OBJECTIFS DE LA FORMATION</h2>
<p>Cette formation est conçue pour permettre aux apprenants de :</p>
<ul>
    <li>Savoir se présenter et présenter autrui en espagnol.</li>
    <li>Comprendre différents accents et améliorer la compréhension orale.</li>
    <li>Argumenter avec fluidité et assurance en espagnol.</li>
    <li>Acquérir un vocabulaire adapté à son secteur d'activité.</li>
    <li>Participer activement à des réunions, voyager et interagir dans un cadre professionnel et personnel.</li>
    <li>Maîtriser l'expression orale et écrite en contexte formel et informel.</li>
</ul>

<h2>MÉTHODOLOGIE ET ORGANISATION</h2>
<ul>
    <li>Approche pédagogique basée sur l’apprentissage actif et immersif.</li>
    <li>Exercices interactifs favorisant la prise de parole et la compréhension.</li>
    <li>Activités en lien avec l’environnement professionnel et personnel de l’apprenant.</li>
    <li>Simulations, jeux de rôles et mises en situation réalistes.</li>
    <li>Accompagnement personnalisé avec feedback régulier pour renforcer la confiance et la progression.</li>
    <li>Utilisation de supports variés : articles, vidéos, enregistrements audios, applications interactives.</li>
    <li>Adaptation du programme en fonction des besoins spécifiques des participants après une évaluation initiale.</li>
</ul>

<h2>PROGRAMME DE FORMATION</h2>

<h2>MODULE 1 : MAÎTRISER LES BASES LINGUISTIQUES</h2>

<strong>Objectifs :</strong>

<p>Consolider les bases de la grammaire et du lexique fondamental.</p>

</td>

<td>
<img class="image" src="{{ public_path('storage/student-photos/programme-formation1.png') }}">

<strong>Contenu :</strong>
<ul>
    <li>Structures grammaticales essentielles : articles, accord sujet-verbe, conjugaison.</li>
    <li>Adjectifs simples et composés, quantification, conjonctions de coordination.</li>
    <li>Verbes irréguliers, voix passive et emploi du passif.</li>
    <li>Usage des auxiliaires modaux et du conditionnel.</li>
</ul>

<strong>Méthodes :</strong>
<ul>
    <li>Exercices de mise en application (traductions, phrases à compléter, reformulations).</li>
    <li>Activités en binôme pour renforcer l’appropriation des structures grammaticales.</li>
    <li>Jeux éducatifs et quiz interactifs pour faciliter la mémorisation.</li>
    <li>Études de cas et analyse d’exemples concrets.</li>
</ul>

<img class="img" src="{{ public_path('storage/student-photos/programme-formation2.png') }}">

</td>
</tr>

</table>

<div class="page-break"></div>
<!-- ================= PAGE 2 ================= -->

<table>
<tr>
<td>

<h2>MODULE 2 : AMÉLIORER LA COMPRÉHENSION ET L’EXPRESSION ORALE</h2>

<strong>Objectifs :</strong>

<p>S’exprimer avec assurance et comprendre l’espagnol parlé.</p>

<strong>Contenu :</strong>
<ul>
    <li>Exercices de prise de parole sur des thèmes variés.</li>
    <li>Travail sur les différents accents espagnols et américains.</li>
    <li>Pratique de dialogues et conversations spontanées.</li>
    <li>Jeux de rôles : présentation professionnelle, discussions de groupe.</li>
</ul>

<strong>Méthodes :</strong>
<ul>
    <li>Simulations de conversations professionnelles et quotidiennes.</li>
    <li>Entraînement à l’écoute avec supports audio et podcasts.</li>
    <li>Utilisation de flashcards et brainstorming pour enrichir le vocabulaire.</li>
    <li>Enregistrement des échanges et feedback personnalisé.</li>
    <li>Participation à des débats et discussions dirigées.</li>
</ul>

<h2>MODULE 3 : ACQUÉRIR UN VOCABULAIRE SPÉCIFIQUE</h2>

<strong>Objectifs :</strong>

<p>Étendre son vocabulaire dans un contexte professionnel et personnel.</p>

<strong>Contenu :</strong>
<ul>
    <li>Lexique courant professionnel (bureau, téléphone, réunions).</li>
    <li>Vocabulaire lié à son secteur d’activité.</li>
    <li>Expressions idiomatiques et langage formel/informel.</li>
</ul>

<strong>Méthodes :</strong>
<ul>
    <li>Mémorisations progressives avec quiz interactifs.</li>
    <li>Rédaction et présentation de mini-exposés.</li>
    <li>Études de textes spécialisés avec analyses de vocabulaire contextuel.</li>
    <li>Exercices de reformulation.</li>
</ul>

<img class="img1" src="{{ public_path('storage/student-photos/programme-formation3.png') }}">

</td>

<td>

<h2>MODULE 4 : AMÉLIORER L’EXPRESSION ÉCRITE</h2>

<strong>Objectifs :</strong>

<p>Rédiger des textes cohérents et structurés.</p>

<strong>Contenu :</strong>
<ul>
    <li>Rédaction d’e-mails professionnels et comptes rendus.</li>
    <li>Exercices de reformulation et d’analyse de textes.</li>
    <li>Construction d’arguments et d’opinions écrites.</li>
</ul>

<strong>Méthodes :</strong>
<ul>
    <li>Correction collaborative et feedback personnalisé.</li>
    <li>Utilisation d’exemples concrets.</li>
    <li>Exercices de rédaction avec contraintes.</li>
    <li>Approche comparative espagnol / français.</li>
</ul>

<h2>ORGANISATION ET MODALITÉS</h2>
<ul>
    <li>Fréquence : 1 à 5 cours par semaine.</li>
    <li>Durée des séances : Entre 1 et 3 heures.</li>
</ul>

<strong>Supports :</strong>
<ul>
    <li>Documents professionnels.</li>
    <li>Podcasts, audiobooks et articles.</li>
    <li>Jeux de rôle et exercices interactifs.</li>
    <li>Plateforme en ligne pour le suivi.</li>
</ul>

<h2>CERTIFICATION PROPOSÉE</h2>
 <p>{{ $certification }}</p> 

<p>
Les prérequis seront organisés en fonction des besoins des stagiaires.
</p>
<img class="img1" src="{{ public_path('storage/student-photos/programme-formation2.png') }}">

</td>
</tr>
</table>

<div class="footer">
</div>

</body>
</html>
