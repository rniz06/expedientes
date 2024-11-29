<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //Listado de ciudades para la creacion de registros en la tabla "Ciudades"

        $ciudades = [
            'ASUNCION',
            'CONCEPCION',
            'BELEN',
            'HORQUETA',
            'LORETO',
            'SAN CARLOS DEL APA',
            'SAN LAZARO',
            'YBY YAU',
            "AZOTE'Y",
            'SARGENTO JOSE FELIX LOPEZ',
            'SAN ALFREDO',
            'PASO BARRETO',
            'SAN PEDRO DEL YCUAMANDYYU',
            'ANTEQUERA',
            'CHORE',
            'GENERAL ELIZARDO AQUINO',
            'ITACURUBI DEL ROSARIO',
            'LIMA',
            'NUEVA GERMANIA',
            'SAN ESTANISLAO',
            'SAN PABLO',
            'TACUATI',
            'UNION',
            '25 DE DICIEMBRE',
            'VILLA DEL ROSARIO',
            'GENERAL FRANCISCO ISIDORO RESQUIN',
            'YATAITY DEL NORTE',
            'GUAJAYVI',
            'CAPIIBARY',
            'SANTA ROSA DEL AGUARAY',
            'YRYBUCUA',
            'LIBERACION',
            'CAACUPE',
            'ALTOS',
            'ARROYOS Y ESTEROS',
            'ATYRA',
            'CARAGUATAY',
            'EMBOSCADA',
            'EUSEBIO AYALA',
            'ISLA PUCU',
            'ITACURUBI DE LA CORDILLERA',
            'JUAN DE MENA',
            'LOMA GRANDE',
            'MBOCAYATY DEL YHAGUY',
            'NUEVA COLOMBIA',
            'PIRIBEBUY',
            'PRIMERO DE MARZO',
            'SAN BERNARDINO',
            'SANTA ELENA',
            'TOBATI',
            'VALENZUELA',
            'SAN JOSE OBRERO',
            'VILLARRICA',
            'BORJA',
            'CAPITAN MAURICIO JOSE TROCHE',
            'CORONEL MARTINEZ',
            'FELIX PEREZ CARDOZO',
            'GRAL. EUGENIO A. GARAY',
            'INDEPENDENCIA',
            'ITAPE',
            'ITURBE',
            'JOSE FASSARDI',
            'MBOCAYATY',
            'NATALICIO TALAVERA',
            'NUMI',
            'SAN SALVADOR',
            'YATAITY',
            'DOCTOR BOTTRELL',
            'PASO YOBAI',
            'TEBICUARY',
            'CORONEL OVIEDO',
            'CAAGUAZU',
            'CARAYAO',
            'DR. CECILIO BAEZ',
            'SANTA ROSA DEL MBUTUY',
            'DR. JUAN MANUEL FRUTOS',
            'REPATRIACION',
            'NUEVA LONDRES',
            'SAN JOAQUIN',
            'SAN JOSE DE LOS ARROYOS',
            'YHU',
            'DR. J. EULOGIO ESTIGARRIBIA',
            'R.I. 3 CORRALES',
            'RAUL ARSENIO OVIEDO',
            'JOSE DOMINGO OCAMPOS',
            'MARISCAL FRANCISCO SOLANO LOPEZ',
            'LA PASTORA',
            '3 DE FEBRERO',
            'SIMON BOLIVAR',
            'VAQUERIA',
            'TEMBIAPORA',
            'NUEVA TOLEDO',
            'CAAZAPA',
            'ABAI',
            'BUENA VISTA',
            'DR. MOISES S. BERTONI',
            'GRAL. HIGINIO MORINIGO',
            'MACIEL',
            'SAN JUAN NEPOMUCENO',
            'TAVAI',
            'YEGROS',
            'YUTY',
            '3 DE MAYO',
            'ENCARNACION',
            'BELLA VISTA',
            'CAMBYRETA',
            'CAPITAN MEZA',
            'CAPITAN MIRANDA',
            'NUEVA ALBORADA',
            'CARMEN DEL PARANA',
            'CORONEL BOGADO',
            'CARLOS ANTONIO LOPEZ',
            'NATALIO',
            'FRAM',
            'GENERAL ARTIGAS',
            'GENERAL DELGADO',
            'HOHENAU',
            'JESUS',
            'JOSE LEANDRO OVIEDO',
            'OBLIGADO',
            'MAYOR JULIO DIONISIO OTANO',
            'SAN COSME Y DAMIAN',
            'SAN PEDRO DEL PARANA',
            'SAN RAFAEL DEL PARANA',
            'TRINIDAD',
            'EDELIRA',
            'TOMAS ROMERO PEREIRA',
            'ALTO VERA',
            'LA PAZ',
            'YATYTAY',
            'SAN JUAN DEL PARANA',
            'PIRAPO',
            'ITAPUA POTY',
            'SAN JUAN BAUTISTA DE LAS MISIONES',
            'AYOLAS',
            'SAN IGNACIO',
            'SAN MIGUEL',
            'SAN PATRICIO',
            'SANTA MARIA',
            'SANTA ROSA',
            'SANTIAGO',
            'VILLA FLORIDA',
            'YABEBYRY',
            'PARAGUARI',
            'ACAHAY',
            'CAAPUCU',
            'CABALLERO',
            'CARAPEGUA',
            'ESCOBAR',
            'LA COLMENA',
            'MBUYAPEY',
            'PIRAYU',
            'QUIINDY',
            'QUYQUYHO',
            'ROQUE GONZALEZ DE SANTACRUZ',
            'SAPUCAI',
            'TEBICUARY-MI',
            'YAGUARON',
            'YBYCUI',
            'YBYTYMI',
            'CIUDAD DEL ESTE',
            'PRESIDENTE FRANCO',
            'DOMINGO MARTINEZ DE IRALA',
            'DR. JUAN LEON MALLORQUIN',
            'HERNANDARIAS',
            'ITAKYRY',
            'JUAN E. O\'LEARY',
            'NACUNDAY',
            'YGUAZU',
            'LOS CEDRALES',
            'MINGA GUAZU',
            'SAN CRISTOBAL',
            'SANTA RITA',
            'NARANJAL',
            'SANTA ROSA DEL MONDAY',
            'MINGA PORA',
            'MBARACAYU',
            'SAN ALBERTO',
            'IRUNA',
            'SANTA FE DEL PARANA',
            'TAVAPY',
            'DR. RAUL PENA',
            'AREGUA',
            'CAPIATA',
            'FERNANDO DE LA MORA',
            'GUARAMBARE',
            'ITA',
            'ITAUGUA',
            'LAMBARE',
            'LIMPIO',
            'LUQUE',
            'MARIANO ROQUE ALONSO',
            'NUEVA ITALIA',
            'ÑEMBY',
            'SAN ANTONIO',
            'SAN LORENZO',
            'VILLA ELISA',
            'VILLETA',
            'YPACARAI',
            'YPANE',
            'J. AUGUSTO SALDIVAR',
            'PILAR',
            'ALBERDI',
            'CERRITO',
            'DESMOCHADOS',
            'GRAL. JOSE EDUVIGIS DIAZ',
            'GUAZU-CUA',
            'HUMAITA',
            'ISLA UMBU',
            'LAURELES',
            'MAYOR JOSE DEJESUS MARTINEZ',
            'PASO DE PATRIA',
            'SAN JUAN BAUTISTA DE NEEMBUCU',
            'TACUARAS',
            'VILLA FRANCA',
            'VILLA OLIVA',
            'VILLALBIN',
            'PEDRO JUAN CABALLERO',
            'BELLA VISTA',
            'CAPITAN BADO',
            'ZANJA PYTÃ',
            'KARAPAI',
            'SALTO DEL GUAIRA',
            'CORPUS CHRISTI',
            'VILLA CURUGUATY',
            'VILLA YGATIMI',
            'ITANARA',
            'YPEJHU',
            'FRANCISCO CABALLERO ALVAREZ',
            'KATUETE',
            'LA PALOMA DEL ESPIRITU SANTO',
            'NUEVA ESPERANZA',
            'YASY CANY',
            'YBYRAROBANA',
            'YBY PYTA',
            'BENJAMIN ACEVAL',
            'PUERTO PINASCO',
            'VILLA HAYES',
            'NANAWA',
            'JOSE FALCON',
            'TTE. 1° MANUEL IRALA FERNANDEZ',
            'TENIENTE ESTEBAN MARTINEZ',
            'GENERAL JOSE MARIA BRUGUEZ',
            'MARISCAL JOSE FELIX ESTIGARRIBIA',
            'FILADELFIA',
            'LOMA PLATA',
            'FUERTE OLIMPO',
            'PUERTO CASADO',
            'BAHIA NEGRA',
            'CARMELO PERALTA',
        ];

        // Iterar sobre el array de ciudades y insertar cada una en la base de datos
        foreach ($ciudades as $ciudad) {
            DB::table('ciudades')->insert([
                'ciudad_nombre' => $ciudad,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
