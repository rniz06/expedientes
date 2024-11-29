<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // listado de paises en minusculas (Con la Inicial en mayusculas)
        // $paises = [
        //     "Afganistán", "Albania", "Alemania", "Andorra", "Angola", "Antigua y Barbuda",
        //     "Arabia Saudita", "Argelia", "Argentina", "Armenia", "Australia", "Austria",
        //     "Azerbaiyán", "Bahamas", "Bangladés", "Barbados", "Baréin", "Bélgica",
        //     "Belice", "Benín", "Bielorrusia", "Birmania", "Bolivia", "Bosnia y Herzegovina",
        //     "Botsuana", "Brasil", "Brunéi", "Bulgaria", "Burkina Faso", "Burundi", "Bután",
        //     "Cabo Verde", "Camboya", "Camerún", "Canadá", "Catar", "Chad", "Chile", "China",
        //     "Chipre", "Ciudad del Vaticano", "Colombia", "Comoras", "Corea del Norte",
        //     "Corea del Sur", "Costa de Marfil", "Costa Rica", "Croacia", "Cuba", "Dinamarca",
        //     "Dominica", "Ecuador", "Egipto", "El Salvador", "Emiratos Árabes Unidos",
        //     "Eritrea", "Eslovaquia", "Eslovenia", "España", "Estados Unidos", "Estonia",
        //     "Etiopía", "Filipinas", "Finlandia", "Fiyi", "Francia", "Gabón", "Gambia",
        //     "Georgia", "Ghana", "Granada", "Grecia", "Guatemala", "Guinea", "Guinea-Bisáu",
        //     "Guinea Ecuatorial", "Guyana", "Haití", "Honduras", "Hungría", "India",
        //     "Indonesia", "Irak", "Irán", "Irlanda", "Islandia", "Islas Marshall",
        //     "Islas Salomón", "Israel", "Italia", "Jamaica", "Japón", "Jordania", "Kazajistán",
        //     "Kenia", "Kirguistán", "Kiribati", "Kuwait", "Laos", "Lesoto", "Letonia",
        //     "Líbano", "Liberia", "Libia", "Liechtenstein", "Lituania", "Luxemburgo",
        //     "Macedonia del Norte", "Madagascar", "Malasia", "Malaui", "Maldivas", "Malí",
        //     "Malta", "Marruecos", "Mauricio", "Mauritania", "México", "Micronesia",
        //     "Moldavia", "Mónaco", "Mongolia", "Montenegro", "Mozambique", "Namibia", "Nauru",
        //     "Nepal", "Nicaragua", "Níger", "Nigeria", "Noruega", "Nueva Zelanda", "Omán",
        //     "Países Bajos", "Pakistán", "Palaos", "Panamá", "Papúa Nueva Guinea", "Paraguay",
        //     "Perú", "Polonia", "Portugal", "Reino Unido", "República Centroafricana",
        //     "República Checa", "República del Congo", "República Democrática del Congo",
        //     "República Dominicana", "Ruanda", "Rumanía", "Rusia", "Samoa",
        //     "San Cristóbal y Nieves", "San Marino", "San Vicente y las Granadinas",
        //     "Santa Lucía", "Santo Tomé y Príncipe", "Senegal", "Serbia", "Seychelles",
        //     "Sierra Leona", "Singapur", "Siria", "Somalia", "Sri Lanka", "Suazilandia",
        //     "Sudáfrica", "Sudán", "Sudán del Sur", "Suecia", "Suiza", "Surinam", "Tailandia",
        //     "Taiwán", "Tanzania", "Tayikistán", "Timor Oriental", "Togo", "Tonga",
        //     "Trinidad y Tobago", "Túnez", "Turkmenistán", "Turquía", "Tuvalu", "Ucrania",
        //     "Uganda", "Uruguay", "Uzbekistán", "Vanuatu", "Venezuela", "Vietnam", "Yemen",
        //     "Yibuti", "Zambia", "Zimbabue"
        // ];

        // Listado de paises en minuscula
        $paises = [
            "AFGANISTÁN", "ALBANIA", "ALEMANIA", "ANDORRA", "ANGOLA", "ANTIGUA Y BARBUDA",
            "ARABIA SAUDITA", "ARGELIA", "ARGENTINA", "ARMENIA", "AUSTRALIA", "AUSTRIA",
            "AZERBAIYÁN", "BAHAMAS", "BANGLADÉS", "BARBADOS", "BARÉIN", "BÉLGICA",
            "BELICE", "BENÍN", "BIELORRUSIA", "BIRMANIA", "BOLIVIA", "BOSNIA Y HERZEGOVINA",
            "BOTSUANA", "BRASIL", "BRUNÉI", "BULGARIA", "BURKINA FASO", "BURUNDI", "BUTÁN",
            "CABO VERDE", "CAMBOYA", "CAMERÚN", "CANADÁ", "CATAR", "CHAD", "CHILE", "CHINA",
            "CHIPRE", "CIUDAD DEL VATICANO", "COLOMBIA", "COMORAS", "COREA DEL NORTE",
            "COREA DEL SUR", "COSTA DE MARFIL", "COSTA RICA", "CROACIA", "CUBA", "DINAMARCA",
            "DOMINICA", "ECUADOR", "EGIPTO", "EL SALVADOR", "EMIRATOS ÁRABES UNIDOS",
            "ERITREA", "ESLOVAQUIA", "ESLOVENIA", "ESPAÑA", "ESTADOS UNIDOS", "ESTONIA",
            "ETIOPÍA", "FILIPINAS", "FINLANDIA", "FIYI", "FRANCIA", "GABÓN", "GAMBIA",
            "GEORGIA", "GHANA", "GRANADA", "GRECIA", "GUATEMALA", "GUINEA", "GUINEA-BISÁU",
            "GUINEA ECUATORIAL", "GUYANA", "HAITÍ", "HONDURAS", "HUNGRÍA", "INDIA",
            "INDONESIA", "IRAK", "IRÁN", "IRLANDA", "ISLANDIA", "ISLAS MARSHALL",
            "ISLAS SALOMÓN", "ISRAEL", "ITALIA", "JAMAICA", "JAPÓN", "JORDANIA", "KAZAJISTÁN",
            "KENIA", "KIRGUISTÁN", "KIRIBATI", "KUWAIT", "LAOS", "LESOTO", "LETONIA",
            "LÍBANO", "LIBERIA", "LIBIA", "LIECHTENSTEIN", "LITUANIA", "LUXEMBURGO",
            "MACEDONIA DEL NORTE", "MADAGASCAR", "MALASIA", "MALAUI", "MALDIVAS", "MALÍ",
            "MALTA", "MARRUECOS", "MAURICIO", "MAURITANIA", "MÉXICO", "MICRONESIA",
            "MOLDAVIA", "MÓNACO", "MONGOLIA", "MONTENEGRO", "MOZAMBIQUE", "NAMIBIA", "NAURU",
            "NEPAL", "NICARAGUA", "NÍGER", "NIGERIA", "NORUEGA", "NUEVA ZELANDA", "OMÁN",
            "PAÍSES BAJOS", "PAKISTÁN", "PALAOS", "PANAMÁ", "PAPÚA NUEVA GUINEA", "PARAGUAY",
            "PERÚ", "POLONIA", "PORTUGAL", "REINO UNIDO", "REPÚBLICA CENTROAFRICANA",
            "REPÚBLICA CHECA", "REPÚBLICA DEL CONGO", "REPÚBLICA DEMOCRÁTICA DEL CONGO",
            "REPÚBLICA DOMINICANA", "RUANDA", "RUMANÍA", "RUSIA", "SAMOA",
            "SAN CRISTÓBAL Y NIEVES", "SAN MARINO", "SAN VICENTE Y LAS GRANADINAS",
            "SANTA LUCÍA", "SANTO TOMÉ Y PRÍNCIPE", "SENEGAL", "SERBIA", "SEYCHELLES",
            "SIERRA LEONA", "SINGAPUR", "SIRIA", "SOMALIA", "SRI LANKA", "SUAZILANDIA",
            "SUDÁFRICA", "SUDÁN", "SUDÁN DEL SUR", "SUECIA", "SUIZA", "SURINAM", "TAILANDIA",
            "TAIWÁN", "TANZANIA", "TAYIKISTÁN", "TIMOR ORIENTAL", "TOGO", "TONGA",
            "TRINIDAD Y TOBAGO", "TÚNEZ", "TURKMENISTÁN", "TURQUÍA", "TUVALU", "UCRANIA",
            "UGANDA", "URUGUAY", "UZBEKISTÁN", "VANUATU", "VENEZUELA", "VIETNAM", "YEMEN",
            "YIBUTI", "ZAMBIA", "ZIMBABUE"
        ];
        
        // Iterar sobre el array de estados y insertar cada una en la base de datos
        foreach ($paises as $pais) {
            DB::table('paises')->insert([
                'pais_nombre' => $pais,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
