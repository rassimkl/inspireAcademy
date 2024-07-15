<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;

use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Hash;

class AddUser extends Component
{
    #[Title('Add User')]


    public $AllLanguages = [
        "Afar",
        "Abkhazian",
        "Avestan",
        "Afrikaans",
        "Akan",
        "Amharic",
        "Aragonese",
        "Arabic",
        "Assamese",
        "Avaric",
        "Aymara",
        "Azerbaijani",
        "Bashkir",
        "Belarusian",
        "Bulgarian",
        "Bihari languages",
        "Bislama",
        "Bambara",
        "Bengali, Bangla",
        "Tibetan",
        "Breton",
        "Bosnian",
        "Catalan, Valencian",
        "Chechen",
        "Chamorro",
        "Corsican",
        "Cree",
        "Czech",
        "Old Church Slavonic, Church Slavonic, Old Bulgarian",
        "Chuvash",
        "Welsh",
        "Danish",
        "German",
        "Divehi, Dhivehi, Maldivian",
        "Dzongkha",
        "Ewe",
        "Greek (modern)",
        "English",
        "Esperanto",
        "Spanish",
        "Estonian",
        "Basque",
        "Persian (Farsi)",
        "Fulah",
        "Finnish",
        "Fijian",
        "Faroese",
        "French",
        "Western Frisian",
        "Irish",
        "Scottish Gaelic; Gaelic",
        "Galician",
        "Guarani",
        "Gujarati",
        "Manx",
        "Hausa",
        "Hebrew (modern)",
        "Hindi",
        "Hiri Motu",
        "Croatian",
        "Haitian, Haitian Creole",
        "Hungarian",
        "Armenian",
        "Herero",
        "Interlingua",
        "Indonesian",
        "Interlingue, Occidental",
        "Igbo",
        "Sichuan Yi, Nuosu",
        "Inupiaq",
        "Ido",
        "Icelandic",
        "Italian",
        "Inuktitut",
        "Japanese",
        "Javanese",
        "Georgian",
        "Kongo",
        "Kikuyu, Gikuyu",
        "Kuanyama, Kwanyama",
        "Kazakh",
        "Greenlandic, Kalaallisut",
        "Central Khmer",
        "Kannada",
        "Korean",
        "Kanuri",
        "Kashmiri",
        "Kurdish",
        "Komi",
        "Cornish",
        "Kirghiz, Kyrgyz",
        "Latin",
        "Luxembourgish, Letzeburgesch",
        "Ganda",
        "Limburgan, Limburger, Limburgish",
        "Lingala",
        "Lao",
        "Lithuanian",
        "Luba-Katanga",
        "Latvian",
        "Malagasy",
        "Marshallese",
        "Maori",
        "Macedonian",
        "Malayalam",
        "Mongolian",
        "Marathi",
        "Malay",
        "Maltese",
        "Burmese",
        "Nauru",
        "Bokmål, Norwegian; Norwegian Bokmål",
        "Ndebele, North; North Ndebele",
        "Nepali",
        "Ndonga",
        "Dutch, Flemish",
        "Norwegian",
        "Ndebele, South; South Ndebele",
        "Navajo, Navaho",
        "Chichewa; Chewa; Nyanja",
        "Occitan (post 1500)",
        "Ojibwa",
        "Oromo",
        "Oriya",
        "Ossetian, Ossetic",
        "Panjabi, Punjabi",
        "Pali",
        "Polish",
        "Pushto; Pashto",
        "Portuguese",
        "Quechua",
        "Romansh",
        "Rundi",
        "Romanian; Moldavian; Moldovan",
        "Russian",
        "Kinyarwanda",
        "Sanskrit",
        "Sardinian",
        "Sindhi",
        "Sango",
        "Sinhala, Sinhalese",
        "Slovak",
        "Slovenian",
        "Samoan",
        "Shona",
        "Somali",
        "Albanian",
        "Serbian",
        "Swati",
        "Sotho, Southern",
        "Sundanese",
        "Swedish",
        "Swahili",
        "Tamil",
        "Telugu",
        "Tajik",
        "Thai",
        "Tigrinya",
        "Turkmen",
        "Tagalog",
        "Tswana",
        "Tonga (Tonga Islands)",
        "Turkish",
        "Tsonga",
        "Tatar",
        "Twi",
        "Tahitian",
        "Uighur, Uyghur",
        "Ukrainian",
        "Urdu",
        "Uzbek",
        "Venda",
        "Vietnamese",
        "Volapük",
        "Walloon",
        "Wolof",
        "Xhosa",
        "Yiddish",
        "Yoruba",
        "Zhuang, Chuang",
        "Chinese",
        "Zulu"
    ];
    public $userTypes;

    public $first_name;
    public $last_name;
    public $gender;
    public $date_of_birth;
    public $email;
    public $password = 'password';
    public $phone_number;
    public $blood_group;
    public $address;
    public $city;
    public $zip_code;
    public $country;
    public $info;
    public $languages;
    public $profile_picture;

    public $iban;
    public $bic;
    public $name_on_bank;
    public $siret;


    #[Url]
    public $user_type_id;


    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'gender' => 'required|in:Male,Female',
        'date_of_birth' => 'nullable|date',
        'email' => 'required|email|unique:users,email',
        'phone_number' => ['required', 'string', 'regex:/^\+?[0-9\s]+$/'],
        'blood_group' => 'nullable|string',
        'address' => 'nullable|string',
        'city' => 'nullable|string',
        'zip_code' => 'nullable|string',
        'country' => 'nullable|string',
        'info' => 'nullable|string',
        'languages' => 'required|array',
        'languages.*' => 'string',
        'profile_picture' => 'nullable|string',
        'user_type_id' => 'required|exists:user_types,id',
        'password' => 'required|string',
        'iban' => 'nullable|string',
        'bic' => 'nullable|string',
        'name_on_bank' => 'nullable|string',
        'siret' => 'nullable|string',

    ];

    public function createUser()
    {

        $validatedData = $this->validate(); // Validate input data based on defined rules

        // Hash the password before storing it in the database
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['languages'] = json_encode($validatedData['languages']);
        $validatedData['date_of_birth'] = Carbon::parse($validatedData['date_of_birth'])->toDateString();


        // Create a new student record
        User::create($validatedData);
        $this->dispatch('resetSelect2');




        $userType = $this->userTypes[$this->user_type_id] ?? "User";


        $this->dispatch('showAlert', [
            'title' => "$userType Created Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);

        // Optionally, you can reset the input fields after creating the student
        $this->reset([
            'first_name',
            'last_name',
            'gender',
            'date_of_birth',
            'email',
            'password',
            'phone_number',
            'blood_group',
            'address',
            'city',
            'zip_code',
            'country',
            'info',
            'languages',
            'profile_picture',
            'user_type_id',
            'iban',
            'bic',
            'name_on_bank',
            'siret',
        ]);


    }

    public function mount()
    {
        $this->userTypes = UserType::pluck('name', 'id');
    }
    public function render()
    {
        return view('livewire.add-user');
    }
}
