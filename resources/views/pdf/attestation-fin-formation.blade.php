<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de fin de formation</title>

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

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 140px;
            margin: 0 15px;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin: 30px 0;
            text-transform: uppercase;
        }

        .content {
            margin-top: 30px;
        }

        .bold {
            font-weight: bold;
        }

        .signature {
            margin-top: 60px;
        }

        .footer {
            margin-top: 150px;
            font-size: 11px;
            text-align: center;
            color: #333;
        }

        #sign {
            margin-top: -100px;
        }
    </style>
</head>

<body>

    {{-- ================= HEADER LOGOS ================= --}}
    <div class="header">
        <img src="{{ public_path('storage/student-photos/attestationF1.png') }}">
        <img src="{{ public_path('storage/student-photos/attestationF.png') }}">
        <p class="bold">25 Allée du Moura – 64200 Biarritz</p>
    </div>

    {{-- ================= TITRE ================= --}}
    <h1>ATTESTATION DE FIN DE FORMATION</h1>

    {{-- ================= CONTENU ================= --}}
    <div class="content">
        <p>
            Je soussigné(e), <span class="bold">{{ $signataireNom }}</span>,
            {{ $signataireRole }} du centre de formation
            <span class="bold">The Inspire Academy</span>, certifie que :
        </p>

        <p>
            <span class="bold">L’élève</span><br>
            Nom : <span class="bold">{{ $nom }}</span><br>
            Prénom : <span class="bold">{{ $prenom }}</span>
        </p>

        <p>
            A suivi la formation :
            <span class="bold">{{ $titreFormation }}</span>
        </p>

        <p>
            Du : <span class="bold">{{ \Carbon\Carbon::parse($dateDu)->format('d/m/Y') }}</span><br>
            Au : <span class="bold">{{ \Carbon\Carbon::parse($dateAu)->format('d/m/Y') }}</span>
        </p>

        <p>
            {{$civilite}} <span class="bold">{{ $nom }} {{ $prenom }}</span>
            a suivi <span class="bold">{{ $duree }}</span> heures de cours,
            soit l’intégralité des heures prévues dans son contrat de formation.
        </p>

        <p>
            À faire valoir ce que de droit.
        </p>

        <p>
            Fait à Biarritz, le {{ \Carbon\Carbon::createFromFormat('d/m/Y', $dateSignature)->format('d/m/Y') }}.
        </p>
    </div>

    {{-- ================= SIGNATURE ================= --}}
    <div class="signature">
        <img id ="sign" align="right" src="{{ public_path('storage/student-photos/signature1.png') }}" width="300">
    </div>

    {{-- ================= FOOTER ================= --}}
    <div class="footer">
        www.inspireacademy.fr – www.inspireacademyonline.fr<br>
        33 (0)5 40 07 55 12 – 33 (0)7 78 03 89 86
    </div>

</body>
</html>
