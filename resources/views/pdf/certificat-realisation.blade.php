<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat de réalisation</title>

    <style>
        @page {
            margin: 40px 50px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            line-height: 1.6;
            color: #000;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
        }

        .header img {
            width: 140px;
        }

        .header-table {
            width: 100%;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin: 30px 0;
            text-transform: uppercase;
        }

        .content {
            margin-top: 20px;
        }

        .bold {
            font-weight: bold;
        }

        .checkbox {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            margin-right: 6px;
        }

        .checked {
            background-color: #000;
        }

        .strike {
            text-decoration: line-through;
            color: #555;
        }

        .stamp {
            border: 1px solid #000;
            padding: 10px;
            font-size: 11px;
            width: 260px;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
            color: #333;
        }

        #sign {
            margin-top: -50px;
        }
    </style>
</head>

<body>

{{-- ================= HEADER ================= --}}
<table class="header-table">
    <tr>
        <td align="left">
            <img src="{{ public_path('storage/student-photos/ministère.png') }}">
        </td>
        <td align="right">
            <img src="{{ public_path('storage/student-photos/attestationF1.png') }}" width ="180px">
        </td>
    </tr>
</table>

<h1>CERTIFICAT DE RÉALISATION</h1>

{{-- ================= CONTENU ================= --}}
<div class="content">
    <p>
        Je soussignée <span class="bold">{{ $signataireNom }}</span><br>
        représentante légale du dispensateur de formation
        <span class="bold">The Inspire Academy</span><br>
        atteste que :
    </p>

    <p class="bold">
        {{ $civilite }} {{ $nom }} {{ $prenom }}
    </p>

    <p>
        a suivi l’action de formation intitulée :
        <span class="bold">“{{ $titreFormation }}”</span>
    </p>

 <p class="bold">Nature de l’action de formation :</p>

<p>
    <span class="checkbox {{ $natureFormation === 'action de formation' ? 'checked' : '' }}"></span>
    <span class="{{ $natureFormation !== 'action de formation' ? 'strike' : '' }}">
        action de formation
    </span>
</p>

<p>
    <span class="checkbox {{ $natureFormation === 'bilan de compétences' ? 'checked' : '' }}"></span>
    <span class="{{ $natureFormation !== 'bilan de compétences' ? 'strike' : '' }}">
        bilan de compétences
    </span>
</p>

<p>
    <span class="checkbox {{ $natureFormation === 'action de VAE' ? 'checked' : '' }}"></span>
    <span class="{{ $natureFormation !== 'action de VAE' ? 'strike' : '' }}">
        action de VAE
    </span>
</p>

<p>
    <span class="checkbox {{ $natureFormation === 'action de formation par apprentissage' ? 'checked' : '' }}"></span>
    <span class="{{ $natureFormation !== 'action de formation par apprentissage' ? 'strike' : '' }}">
        action de formation par apprentissage
    </span>
</p>

    <p>
        qui s’est déroulée du
        <span class="bold">{{ \Carbon\Carbon::parse($dateDu)->format('d/m/Y') }}</span>
        au
        <span class="bold">{{ \Carbon\Carbon::parse($dateAu)->format('d/m/Y') }}</span>,
        pour une durée totale de
        <span class="bold">{{ $duree }}h</span>.
    </p>

    <p>
        Sans préjudice des délais imposés par les règles fiscales, comptables ou commerciales,
        je m’engage à conserver l’ensemble des pièces justificatives qui ont permis d’établir le
        présent certificat pendant une durée de 3 ans à compter de la fin de l’année du dernier
        paiement. En cas de cofinancement des fonds européens, la durée de conservation est
        étendue conformément aux obligations conventionnelles spécifiques.
    </p>

    <p>
        Fait à <span class="bold">Biarritz</span><br>
        Le : <span class="bold"> {{ \Carbon\Carbon::createFromFormat('d/m/Y', $dateSignature)->format('d/m/Y') }} </span>
    </p>
</div>

{{-- ================= SIGNATURE ================= --}}

    <div class="signature">
        <img id ="sign" align="right" src="{{ public_path('storage/student-photos/cachet_sign.png') }}" width="300">
    </div>

</body>
</html>
