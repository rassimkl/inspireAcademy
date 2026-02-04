<p>
    Bonjour {{ $civilite }} {{ $nom }},
</p>

<p>
    Nous avons été ravis de vous compter parmi nos élèves et nous espérons que vous avez été
    satisfaite de votre formation.
</p>

<p>
    Vous trouverez ci-joint votre <strong>attestation de fin de formation</strong> ainsi que
    votre <strong>certificat de réalisation</strong>.
</p>

<p>
    N’hésitez pas à effectuer de nouveau le test de positionnement afin d’évaluer vos progrès :
    <br>
    👉 <a href="{{ $lienTestNiveau }}" target="_blank">
        Test de positionnement {{ $langue }}
    </a>
</p>

<p>
    Nous vous remercions de bien vouloir compléter ce formulaire afin de nous indiquer votre
    niveau de satisfaction :
    <br>
    👉 <a href="{{ $lienSatisfaction }}" target="_blank">
        Formulaire de satisfaction
    </a>
</p>

<p>
    Dans le cas où vous seriez très satisfaite de notre formation, n’hésitez pas à nous laisser
    un avis sur notre page Google :
    <br>
    👉 <a href="{{ $lienAvisGoogle }}" target="_blank">
        Laisser un avis Google
    </a>
</p>

<p>
    @if($afficherTexteOptionnel)
        <p>
            {!! nl2br(e($texteOptionnel)) !!}
        </p>
    @endif
</p>

<p>
    Nous vous remercions encore pour votre confiance et vous souhaitons une excellente
    continuation.
</p>

<p>
    Cordialement,
</p>

<p>
    <strong>{{ $signataireNom }}</strong><br>
    {{ $signataireRole }}
</p>
<span> <img src="{{ url('storage/student-photos/attestationF1.png') }}" width="120" alt="The Inspire Academy" /> </span>
<p style="margin-top: 15px;">
    <strong>The Inspire Academy</strong><br>
    25 allée du Moura, 64200 Biarritz<br>
    06 01 26 78 00 / 05 40 07 55 12<br>
    <a href="https://www.inspireacademy.fr" target="_blank">
        www.inspireacademy.fr
    </a>
</p>

