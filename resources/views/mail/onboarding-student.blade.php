@php
    $langueLower = mb_strtolower($langue);

    $voyelles = ['a','e','i','o','u','y','à','â','é','è','ê','ë','î','ï','ô','ù','û'];

    $preposition = in_array(mb_substr($langueLower, 0, 1), $voyelles)
        ? "d’"
        : "de ";
@endphp


<p>
    Bonjour {{ $civilite }} {{ $nom }},
</p>

<p>
    J’ai le plaisir de vous confirmer votre inscription à la formation
    <strong><span><strong>{{$titreFormation}}</strong></span></strong>.
</p>

<p>
    Vous trouverez ci-joint notre programme de formation {{ $preposition }}{{ $langueLower }},
    le règlement intérieur, et votre convention de formation à nous retourner signés.
    Vous pouvez utiliser pour cela le site
    <a href="https://www.ilovepdf.com" target="_blank">ILovePDF</a>.
</p>

<p>
    Afin de mieux comprendre vos besoins et programmer vos cours selon vos disponibilités,
    nous vous remercions de bien vouloir compléter le formulaire d’entrée en formation suivant :
    <br>
    👉 <a href="{{ $lienFormulaireEntree }}" target="_blank">
        Formulaire d’entrée en formation
    </a>
</p>

<p>
    Nous vous invitons également à effectuer le test de positionnement,
    qui permettra à votre professeur d’évaluer votre niveau :
    <br>
    👉 <a href="{{ $lienTestNiveau }}" target="_blank">
        Test de positionnement {{ $langue }}
    </a>
</p>

<p> <strong> {{$text}} </strong></p>
<p> <strong> {{$textp2}} </strong></p>
<p> <strong> {{$textp3}} </strong></p>

<p>
    N’hésitez pas à nous recontacter si vous avez besoin de plus de renseignements.
</p>

<p>
    Nous vous remercions encore pour votre confiance et sommes heureux de pouvoir
    vous accompagner dans ce projet.
</p>

<p>
    Cordialement,
</p>

<p>
    <strong>{{ $signataireNom }}</strong><br>
    {{ $signataireRole }}
</p>
<span> <img src="{{ public_path('storage/student-photos/attestationF1.png') }}" width ="180px"> </span>
<p style="margin-top: 15px;">
    <strong>The Inspire Academy</strong><br>
    25 allée du Moura, 64200 Biarritz<br>
    06 01 26 78 00 / 05 40 07 55 12<br>
    <a href="https://www.inspireacademy.fr" target="_blank">
        www.inspireacademy.fr
    </a>
</p>
