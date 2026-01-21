<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\OnboardingStudentMail;
use Illuminate\Support\Facades\Storage;


class OnboardingMailForm extends Component
{
    /* =====================================================
     * 1️⃣ INFORMATIONS DE L’ÉTUDIANT
     * ===================================================== */
    public string $civilite = 'Madame';
    public string $prenom = '';
    public string $nom = '';
    public string $email = '';
    public string $telephone = '';
    public string $dossierCpf = '';

    /* =====================================================
     * 2️⃣ INFORMATIONS DE LA FORMATION
     * ===================================================== */
    public string $langue = 'Espagnol';
    public string $certification = 'LILATE';

    public ?string $dateDu = null;
    public ?string $dateAu = null;

    public string $duree = '';
    public string $lieu = '';
    public string $modalite = 'Présentiel';
    public string $effectif = '';

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

    /* =====================================================
     * 3️⃣ INFORMATIONS FINANCIÈRES
     * ===================================================== */
    public ?float $fraisFormation = null;

    /* =====================================================
     * 4️⃣ CONTENU DU PDF PROGRAMME
     * ===================================================== */
    public string $contenuParDefaut = '';
    public string $contenuCustom = '';

    /* =====================================================
     * 5️⃣ CONTENU DU MAIL
     * ===================================================== */
    public string $lienTestNiveau = '';
    public string $lienFormulaireEntree = 'https://docs.google.com/forms/d/e/1FAIpQLSdFUdhexOKbhm5GScY4koG8-C8WMUET5RSsTkVGA5FVfTluUg/viewform?usp=header';

    // Signature (simple : saisie directe)
    public string $signataireNom = '';
    public string $signataireRole = '';

    /* =====================================================
     * LISTES POUR L’UI
     * ===================================================== */
    public array $langues = [
        'Espagnol', 'Anglais', 'Français',
        'Italien', 'Allemand', 'Arabe', 'Portugais', 'Basque', 'Russe'
    ];

    public array $modalites = ['Présentiel', 'Distanciel'];

    /* =====================================================
     * INITIALISATION
     * ===================================================== */
    public function mount(): void
    {
        // Contenu standard du programme (PDF)
        $this->contenuParDefaut = <<<TXT
Module 1 : Bases linguistiques
Module 2 : Expression orale
Module 3 : Vocabulaire professionnel
Module 4 : Expression écrite
TXT;

        // Valeurs par défaut utiles
        $this->signataireNom = 'Maryam IGRAM';
        $this->signataireRole = 'Directrice';

        // Initialisation automatique du lien de test
        if (isset($this->testsParLangue[$this->langue])) {
            $this->lienTestNiveau = $this->testsParLangue[$this->langue];
    }
    }

    /* =====================================================
     * PROPRIÉTÉS CALCULÉES
     * ===================================================== */

    // Nom complet de l’élève
    public function getEleveProperty(): string
    {
        return trim($this->prenom . ' ' . $this->nom);
    }

    // Contenu FINAL utilisé dans le PDF programme
    public function getContenuProgrammeFinalProperty(): string
    {
        return trim($this->contenuCustom) !== ''
            ? $this->contenuCustom
            : $this->contenuParDefaut;
    }

    /* =====================================================
     * VALIDATION
     * ===================================================== */
    protected function rules(): array
    {
        return [
            'civilite' => 'required|in:Madame,Monsieur',
            'prenom' => 'required|string|min:2',
            'nom' => 'required|string|min:2',
            'email' => 'required|email',
            'telephone' => 'required|string|min:6',

            'langue' => 'required|string',
            'certification' => 'required|string',

            'dateDu' => 'required|date',
            'dateAu' => 'required|date|after_or_equal:dateDu',

            'duree' => 'required|string',
            'lieu' => 'required|string',
            'modalite' => 'required|in:Présentiel,Distanciel',
            'effectif' => 'required|string',

            'fraisFormation' => 'required|numeric|min:0',

            'lienTestNiveau' => 'required|url',

            'signataireNom' => 'required|string|min:3',
            'signataireRole' => 'required|string|min:3',
        ];
    }


public function updatedLangue($value)
{
    if (isset($this->testsParLangue[$value])) {
        $this->lienTestNiveau = $this->testsParLangue[$value];
    } else {
        $this->lienTestNiveau = '';
    }
}



        public function getMailPreviewProperty(): string
{
    return view('mail.onboarding-student', [
        'civilite' => $this->civilite,
        'nom' => $this->nom,
        'lienFormulaireEntree' => $this->lienFormulaireEntree,
        'lienTestNiveau' => $this->lienTestNiveau,
        'signataireNom' => $this->signataireNom,
        'signataireRole' => $this->signataireRole,
        'langue' => $this->langue,
        'duree' => $this->duree,
        'certification' => $this->certification,
    ])->render();
}

public function generateProgrammePdf(): string
{
    return Pdf::loadView('pdf.programme-formation', [
        'eleve' => $this->eleve,
        'dateDu' => $this->dateDu,
        'dateAu' => $this->dateAu,
        'langue' => $this->langue, 
        'duree' => $this->duree,
        'contenuProgramme' => $this->contenuProgrammeFinal,
        'certification' => $this->certification,
    ])->output();
}

public function previewProgrammePdf()
{
    $pdf = $this->generateProgrammePdf();

    $filename = 'programme-formation-' . now()->timestamp . '.pdf';

    $path = '/public/mail_docs/' .$filename;
    \Storage::put($path, $pdf);

    $this->dispatch('openPdfPreview', url('/storage/mail_docs/' .$filename));
}


public function generateConventionPdf(): string
{
    return Pdf::loadView('pdf.convention-formation', [
        'eleve' => $this->eleve,
        'email' => $this->email,
        'telephone' => $this->telephone,
        'dossierCpf' => $this->dossierCpf,

        'dateDu' => $this->dateDu,
        'dateAu' => $this->dateAu,
        'duree' => $this->duree,
        'lieu' => $this->lieu,
        'modalite' => $this->modalite,
        'effectif' => $this->effectif,

        'fraisFormation' => $this->fraisFormation,
        'totalGeneral' => $this->fraisFormation,
        'tarifComplet' => $this->fraisFormation,

        'villeSignature' => 'Biarritz',
        'dateSignature' => now()->format('d/m/Y'),
        'signataireNom' => $this->signataireNom,
        'signataireRole' => $this->signataireRole,
        'langue' => $this->langue,
        'certification' => $this->certification,
    ])->output();
}


public function previewConventionPdf()
{
    $pdf = $this->generateConventionPdf();

    $filename = 'convention-formation-' . now()->timestamp . '.pdf';

    $path = '/public/mail_docs/' . $filename;
    \Storage::put($path, $pdf);

    $this->dispatch(
        'openPdfPreview',
        url('/storage/mail_docs/' . $filename)
    );
}



public function sendMail()
{

    $this->sending = true;

    $this->validate();

    // Génération PROGRAMME
    $programmePdf = $this->generateProgrammePdf();
    $programmeName = 'programme-' . now()->timestamp . '.pdf';
    $programmePath = '/public/mail_docs/' . $programmeName;
    Storage::put($programmePath, $programmePdf);

    // Génération CONVENTION
    $conventionPdf = $this->generateConventionPdf();
    $conventionName = 'convention-' . now()->timestamp . '.pdf';
    $conventionPath = '/public/mail_docs/' . $conventionName;
    Storage::put($conventionPath, $conventionPdf);

    // ✅ RÈGLEMENT INTÉRIEUR (PDF EXISTANT)
    $reglementPath = '/public/mail_docs/reglement-interieur.pdf';

    // Envoi mail
    Mail::to($this->email)->send(
        new OnboardingStudentMail(
            $this->mailPreview,
            $programmePath,
            $conventionPath,
            $reglementPath
        )
    );

// 🧹 Nettoyage des anciens PDF générés
$files = Storage::files('public/mail_docs');

foreach ($files as $file) {
    if (
        str_contains($file, 'programme') ||
        str_contains($file, 'convention')
    ) {
        Storage::delete($file);
    }
}

    $this->sending = false;

    session()->flash('success', 'Mail envoyé avec les documents joints.');
}

    public function render()
    {
        return view('livewire.admin.onboarding-mail-form');
    }


}
