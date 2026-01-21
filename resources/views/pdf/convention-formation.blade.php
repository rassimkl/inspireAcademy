<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Convention de formation</title>

<style>
@page {
    margin: 40px 50px;
}

body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: #000;
}

#contenu {

    margin: 45px;
}

/* ===== HEADER LOGOS ===== */
.header-table {
    width: 100%;
    margin-bottom: -30px;
}

.header-table td {
    width: 50%;
    vertical-align: middle;
}

.logo {
    width: 150px;
}

/* ===== TITRE ===== */
h1 {
    text-align: center;
    font-size: 16px;
    text-transform: uppercase;
    margin: 10px 0 25px;
}

/* ===== TEXTE ===== */
.section {
    margin-bottom: 15px;
}

.bold {
    font-weight: bold;
}

.article {
    margin-top: 20px;
    font-weight: bold;
}

/* ===== SIGNATURE ===== */
.signature-table {
    width: 100%;
    margin-top: 50px;
}

.signature-table td {
    width: 50%;
    vertical-align: top;
}

.right {
    text-align: right;
}

.right .sign {
    margin-right: 50px;
}

/* ===== SAUT DE PAGE ===== */
.page-break {
    page-break-before: always;
}
</style>
</head>

<body>

<!-- ================= PAGE 1 HEADER ================= -->
<table class="header-table">
    <tr>
        <td align="left">
            <img class="logo" src="{{ public_path('storage/student-photos/convention1.png') }}">
        </td>
        <td align="right">
            <img class="logo" src="{{ public_path('storage/student-photos/convention1.png') }}">
        </td>
    </tr>
</table>

<div id = "contenu">

<h1>CONVENTION DE FORMATION</h1>

<div class="section">Entre les soussignés :</div>

<div class="section">
    <span class="bold">1. Organisme de formation :</span><br>
    Inspire Nation<br>
    Branche formation : Inspire Academy<br>
    25 Allée du Moura<br>
    64200 Biarritz<br>
    SIRET : 848 044 889 00014<br>
    N° de déclaration : 75640463864<br>
    SASU INSPIRE NATION
</div>

<div class="section">
    <span class="bold">2. L’élève :</span><br>
    Élève : {{ $eleve }}<br>
    Email : {{ $email }}<br>
    Téléphone : {{ $telephone }}<br>
    Dossier CPF : {{ $dossierCpf }}
</div>

<div class="section">Est conclue la convention suivante :</div>

<div class="article">Article 1</div>

<div class="section">
    L’organisme de formation organise l’action de formation suivante :
</div>

<div class="section">
    1. Intitulé : <span>{{$langue}} – Formation Flexible {{$duree}}h avec Certification {{$certification}}</span><br>
    2. La catégorie de l’action de formation : Formation en langue étrangère.<br>
    3. Nature de l’action : formation professionnelle en langue étrangère.<br>
    4. Dates : du {{ \Carbon\Carbon::parse($dateDu)->format('d/m/Y') }}
au {{ \Carbon\Carbon::parse($dateAu)->format('d/m/Y') }}
.<br>
    5. Durée : {{ $duree }}<p>heures</p>.<br>
    6. Lieu : {{ $lieu }}.<br>
    7. Modalités : {{ $modalite }}.<br>
    8. Justificatifs : attestation de présence et de formation.<br>
</div>

<!-- ================= PAGE 2 ================= -->
<div class="page-break"></div>

<table class="header-table">
    <tr>
        <td align="left">
            <img class="logo" src="{{ public_path('storage/student-photos/convention1.png') }}">
        </td>
        <td align="right">
            <img class="logo" src="{{ public_path('storage/student-photos/convention1.png') }}">
        </td>
    </tr>
</table>

<div class="section">
       9. Effectif : {{ $effectif }}.
<div class="article">Article 2</div>
 
<div class="section">
    En contrepartie de cette action de formation, le cocontractant s’engage à acquitter :
</div>

<div class="section">
    Frais de formation : {{ $fraisFormation }} € TTC.<br>
    TVA : 0 euro.<br>
    Total général : {{ $totalGeneral }} € TTC.<br>
    Frais de déplacement : 0 euro.<br>
    Contribution publique : 0 euro.
</div>

<div class="article">Article 3</div>

<div class="section">
    <span class="bold">Clause de dédit :</span><br>
    Les parties peuvent prévoir des obligations financières en cas d’inexécution.
</div>

<div class="section">
    <span class="bold">Clause de paiement et d’annulation :</span><br>
    Tarif complet : {{ $tarifComplet }} € TTC.<br>
    Paiement CPF par subrogation.<br>
    Annulation à prévenir 24h à l’avance.
</div>

<div class="article">Article 4</div>

<div class="section">
    La présente convention prend effet à compter de sa signature.
</div>

<div class="section">
    Fait à {{ $villeSignature }}<br>
    Le {{ $dateSignature }}
</div>

<table class="signature-table">
<tr>
    <td>Pour le stagiaire</td>
    <td class="right">
        Pour l’organisme de formation :<br>
       <span class = "sign"> The Inspire Academy</span> <br> 
        <span class = "sign"> {{ $signataireNom }} </span> <br>
        <span class = "sign"> {{ $signataireRole }} </span> 
        <img align="right" src="{{ public_path('storage/student-photos/convention.png') }}">
    </td>
</tr>
</table>

</div>

</body>
</html>
