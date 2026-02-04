<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Services\BrevoService;

class EndOfTrainingMailForm extends Component
{
    /* =====================================================
     * 1️⃣ INFORMATIONS ÉTUDIANT
     * ===================================================== */
    public string $civilite = 'Madame';
    public string $prenom = '';
    public string $nom = '';
    public string $email = '';

    /* =====================================================
     * 2️⃣ INFORMATIONS FORMATION
     * ===================================================== */
    public string $titreFormation = '';
    public string $langue = 'Anglais';
        public array $langues = [
        'Espagnol', 'Anglais', 'Français',
        'Italien', 'Allemand', 'Arabe', 'Portugais', 'Basque', 'Russe'
    ];
    

    public string $certification = '';

    public ?string $dateDu = null;
    public ?string $dateAu = null;
    public string $duree = '';

    /* =====================================================
     * 3️⃣ SIGNATAIRE
     * ===================================================== */
    public string $signataireNom = 'Maryam IGRAM';
    public string $signataireRole = 'Directrice';

    /* =====================================================
     * 4️⃣ TEXTE DU MAIL
     * ===================================================== */
    public string $text = '';

    public bool $sending = false;

    public string $natureFormation = 'action de formation';

    public string $lienTestNiveau = '';
    public string $lienSatisfaction = 'https://forms.gle/E6yRi4KGwHtH7waN9';
    public string $lienAvisGoogle = 'https://g.page/r/CXbj0gjxzIs2EB0/review';

    public array $testsParLangue = [
    'Espagnol'   => 'https://docs.google.com/forms/d/e/1FAIpQLScRdlAsL7CctM5FOnTsCoktciTDbqd92AcQIQ5Abef0MKDqhQ/viewform?usp=header',
    'Anglais'    => 'https://docs.google.com/forms/d/e/1FAIpQLSed5dRpDfATnyirfnbG34gMzGyzfyrkbhpRod76b1Mj4pvYHA/viewform?usp=header',
    'Français'   => 'https://docs.google.com/forms/d/e/1FAIpQLSeDMXisnkD6NeNvkXL2X5VlC4sYHeo3oSbsqd5_c7DW2J2QZg/viewform?usp=header',
    'Italien'    => 'https://docs.google.com/forms/d/e/1FAIpQLSe6-3hY4GywtYDguONGyUis85GgoL9hO7r9MYEkFqixHQ6lDQ/viewform?usp=header',
    'Allemand'   => 'https://docs.google.com/forms/d/e/1FAIpQLSeEIpkcEyaNc4W24uDUQFKQ2kDr0yJeK8BRWXVOeJWLlR0QYQ/viewform?usp=header',
    'Arabe'      => 'https://docs.google.com/forms/d/e/1FAIpQLSdiHstaEu47umtutOYmgzhaPILdKsAM7sZK6ym10s0-UPMOEg/viewform?usp=header',
    'Portugais'  => 'https://docs.google.com/forms/d/e/1FAIpQLScEuCMBJ-bSWYlW84b650BAPvR_g-zTiaCdq0BWFq3-tZlfxw/viewform?usp=header',
    'Basque'     => 'https://docs.google.com/forms/d/e/1FAIpQLSfTLS_Ik2Z42vmVRdDakIUVSxEoJxvkiYkZCsO81QoSFFOqcw/viewform?usp=header',
    'Russe'     => 'https://docs.google.com/forms/d/e/1FAIpQLSdhxfGgEf1ORPwCNS4uEfrRI9aJ2MSfeZ6uwXg8WtBOVVkp6Q/viewform?usp=header',
];


    public function mount(): void
    {

        // Initialisation automatique du lien de test
        if (isset($this->testsParLangue[$this->langue])) {
            $this->lienTestNiveau = $this->testsParLangue[$this->langue];
    }


    }

    public function updatedLangue($value)
{
    if (isset($this->testsParLangue[$value])) {
        $this->lienTestNiveau = $this->testsParLangue[$value];
    } else {
        $this->lienTestNiveau = '';
    }
}


    /* =====================================================
     * 6️⃣ PROPRIÉTÉS CALCULÉES
     * ===================================================== */
    public function getEleveProperty(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    /* =====================================================
     * 7️⃣ VALIDATION
     * ===================================================== */
    protected function rules(): array
    {
        return [
            'civilite' => 'required|in:Madame,Monsieur',
            'prenom' => 'required|string|min:2',
            'nom' => 'required|string|min:2',
            'email' => 'required|email',

            'titreFormation' => 'required|string|max:70',
            'langue' => 'required|string',

            'dateDu' => 'required|date',
            'dateAu' => 'required|date|after_or_equal:dateDu',
            'duree' => 'required|string',

            'signataireNom' => 'required|string|min:3',
            'signataireRole' => 'required|string|min:3',
            'natureFormation' => 'required|in:action de formation,bilan de compétences,action de VAE,action de formation par apprentissage',

        ];
    }

    /* =====================================================
     * 8️⃣ APERÇU DU MAIL
     * ===================================================== */
    public function getMailPreviewProperty(): string
    {
        return view('mail.end-of-training-student', [
            'civilite' => $this->civilite,
            'nom' => $this->nom,
            'titreFormation' => $this->titreFormation,
            'text' => $this->text,
            'signataireNom' => $this->signataireNom,
            'signataireRole' => $this->signataireRole,
            'lienTestNiveau' => $this->lienTestNiveau,
            'lienSatisfaction' => $this->lienSatisfaction,
            'lienAvisGoogle' => $this->lienAvisGoogle,
            'langue' => $this->langue,
            'certification' => $this->certification,
        ])->render();
    }

    /* =====================================================
     * 9️⃣ PDF – ATTESTATION
     * ===================================================== */
    public function generateAttestationPdf(): string
    {
        return Pdf::loadView('pdf.attestation-fin-formation', [
            'civilite' => $this->civilite,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'eleve' => $this->eleve,
            'titreFormation' => $this->titreFormation,
            'dateDu' => $this->dateDu,
            'dateAu' => $this->dateAu,
            'duree' => $this->duree,
            'signataireNom' => $this->signataireNom,
            'signataireRole' => $this->signataireRole,
            'villeSignature' => 'Biarritz',
            'dateSignature' => now()->format('d/m/Y'),
        ])->output();
    }

    public function previewAttestationPdf()
    {
        $pdf = $this->generateAttestationPdf();

        $filename = 'attestation-fin-formation-' . now()->timestamp . '.pdf';
        $path = 'public/mail_docs/' . $filename;

        \Storage::put($path, $pdf);

        $this->dispatch(
            'openPdfPreview',
            url('/storage/mail_docs/' . $filename)
        );
    }

    /* =====================================================
     * 🔟 PDF – CERTIFICAT DE RÉALISATION
     * ===================================================== */
    public function generateCertificatPdf(): string
    {
        return Pdf::loadView('pdf.certificat-realisation', [
            'civilite' => $this->civilite,
            'prenom' => $this->prenom,
            'nom' => $this->nom,
            'eleve' => $this->eleve,
            'titreFormation' => $this->titreFormation,
            'dateDu' => $this->dateDu,
            'dateAu' => $this->dateAu,
            'duree' => $this->duree,
            'signataireNom' => $this->signataireNom,
            'signataireRole' => $this->signataireRole,
            'villeSignature' => 'Biarritz',
            'dateSignature' => now()->format('d/m/Y'),
            'natureFormation' => $this->natureFormation,
        ])->output();
    }

    public function previewCertificatPdf()
    {
        $pdf = $this->generateCertificatPdf();

        $filename = 'certificat-realisation-' . now()->timestamp . '.pdf';
        $path = 'public/mail_docs/' . $filename;

        \Storage::put($path, $pdf);

        $this->dispatch(
            'openPdfPreview',
            url('/storage/mail_docs/' . $filename)
        );
    }

    /* =====================================================
     * 1️⃣1️⃣ ENVOI DU MAIL
     * ===================================================== */
    public function sendMail()
    {
        $this->sending = true;
        $this->validate();

        $attestationPath = 'public/mail_docs/attestation-fin-formation.pdf';
        $certificatPath = 'public/mail_docs/certificat-realisation.pdf';

        Storage::put($attestationPath, $this->generateAttestationPdf());
        Storage::put($certificatPath, $this->generateCertificatPdf());

        app(BrevoService::class)->sendEmail(
            $this->email,
            'Fin de formation – The Inspire Academy',
            $this->mailPreview,
            [
                $attestationPath,
                $certificatPath,
            ]
        );

        Storage::delete([$attestationPath, $certificatPath]);

        $this->sending = false;
        session()->flash('success', 'Mail de fin de formation envoyé avec succès.');
    }

    /* =====================================================
     * 1️⃣2️⃣ RENDER
     * ===================================================== */
    public function render()
    {
        return view('livewire.admin.end-of-training-mail-form');
    }
}
