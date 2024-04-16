<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\UserType;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class EditUser extends Component
{
    #[Title('Update User')]
    public $user_id;
    public $user;
    public $userType = "User";//for the page to display currently user being edited

    public $userTypes;
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

    public $first_name;
    public $last_name;
    public $gender;
    public $date_of_birth;
    public $email;
    public $password;
    public $phone_number;
    public $blood_group;
    public $address;
    public $city;
    public $zip_code;
    public $country;
    public $info;
    public $languages;
    public $profile_picture;
    public $user_type_id;

    public $passwordEnabled = false;


    public function rules()
    {
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'nullable|date',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'phone_number' => ['required', 'string', 'regex:/^\+?[0-9]+$/'],
            'blood_group' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'country' => 'nullable|string',
            'info' => 'nullable|string',
            'languages' => 'required|array',
            'languages.*' => 'string',
            'profile_picture' => 'nullable|string',

        ];

        if ($this->passwordEnabled) {

            $rules['password'] = 'required|string';
        }
        return $rules;
    }

    public function mount($userId)
    {
        $this->user_id = $userId;
        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('home');
        }


        if ($user) {
            $this->user = $user;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->gender = $user->gender;



            $this->date_of_birth = Carbon::parse($user->date_of_birth)->format('d-m-Y');
            $this->email = $user->email;
          
            $this->phone_number = $user->phone_number;
            $this->blood_group = $user->blood_group;
            $this->address = $user->address;
            $this->city = $user->city;
            $this->zip_code = $user->zip_code;
            $this->country = $user->country;
            $this->info = $user->info;
            $this->languages = json_decode($user->languages, true);
            $this->profile_picture = $user->profile_picture;
            $this->user_type_id = $user->user_type_id;

            // Fetch user types
            $this->userTypes = UserType::pluck('name', 'id');
            $this->userType = $this->userTypes[$this->user_type_id] ?? "User";


        }
    }

    public function updateUser()
    {

        $validatedData = $this->validate(); // Validate input data based on defined rules

        // Hash the password before storing it in the database



        if ($this->passwordEnabled) {

            $validatedData['password'] = Hash::make('password');
        }

        $validatedData['languages'] = json_encode($validatedData['languages']);
        $validatedData['date_of_birth'] = Carbon::parse($validatedData['date_of_birth'])->toDateString();


        // Create a new student record
        $this->user->update($validatedData);
        $this->dispatch('resetSelect2');






        $this->dispatch('showAlert', [
            'title' => "$this->userType Updated Succesfully",
            'text' => '',
            'icon' => 'success'
        ]);




    }
    public function render()
    {
        return view('livewire.edit-user');
    }
}
