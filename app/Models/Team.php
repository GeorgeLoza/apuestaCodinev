<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'api_id',
    'nombre',
    'codigo',
    'bandera',
])]
class Team extends Model
{
    protected $table = 'equipos';

    public function homeMatches(): HasMany
    {
        return $this->hasMany(
            FootballMatch::class,
            'equipo_local_id'
        );
    }

    public function awayMatches(): HasMany
    {
        return $this->hasMany(
            FootballMatch::class,
            'equipo_visitante_id'
        );
    }

    public function getNombreAttribute(?string $value): string
    {
        $translations = [
            'argentina' => 'Argentina',
            'brazil' => 'Brasil',
            'france' => 'Francia',
            'germany' => 'Alemania',
            'spain' => 'España',
            'italy' => 'Italia',
            'portugal' => 'Portugal',
            'england' => 'Inglaterra',
            'belgium' => 'Bélgica',
            'croatia' => 'Croacia',
            'netherlands' => 'Países Bajos',
            'uruguay' => 'Uruguay',
            'mexico' => 'México',
            'united states' => 'Estados Unidos',
            'usa' => 'Estados Unidos',
            'canada' => 'Canadá',
            'japan' => 'Japón',
            'south korea' => 'Corea del Sur',
            'senegal' => 'Senegal',
            'morocco' => 'Marruecos',
            'cameroon' => 'Camerún',
            'ghana' => 'Ghana',
            'tunisia' => 'Túnez',
            'ecuador' => 'Ecuador',
            'qatar' => 'Catar',
            'saudi arabia' => 'Arabia Saudita',
            'iran' => 'Irán',
            'australia' => 'Australia',
            'costa rica' => 'Costa Rica',
            'wales' => 'Gales',
            'poland' => 'Polonia',
            'denmark' => 'Dinamarca',
            'switzerland' => 'Suiza',
            'serbia' => 'Serbia',
            'colombia' => 'Colombia',
            'peru' => 'Perú',
            'chile' => 'Chile',
            'venezuela' => 'Venezuela',
            'paraguay' => 'Paraguay',
            'bolivia' => 'Bolivia',
            'panama' => 'Panamá',
            'jamaica' => 'Jamaica',
            'honduras' => 'Honduras',
            'el salvador' => 'El Salvador',
            'new zealand' => 'Nueva Zelanda',
            'south africa' => 'Sudáfrica',
            'egypt' => 'Egipto',
            'nigeria' => 'Nigeria',
            'algeria' => 'Argelia',
            'ivory coast' => 'Costa de Marfil',
            'czechia' => 'Chequia',
            'czech republic' => 'Chequia',
            'hungary' => 'Hungría',
            'romania' => 'Rumania',
            'norway' => 'Noruega',
            'slovakia' => 'Eslovaquia',
            'finland' => 'Finlandia',
            'ireland' => 'Irlanda',
            'north korea' => 'Corea del Norte',
            'georgia' => 'Georgia',
            'slovenia' => 'Eslovenia',
            'albania' => 'Albania',
            'trinidad and tobago' => 'Trinidad y Tobago',
            'haiti' => 'Haití',
            'curacao' => 'Curaçao',
        ];

        $key = strtolower(trim($value ?? ''));

        return $translations[$key] ?? $value ?? '';
    }

    public function getFlagUrl(): string
    {
        $name = strtolower(trim($this->attributes['nombre'] ?? ''));
        
        $map = [
            'argentina' => 'ar',
            'brazil' => 'br',
            'france' => 'fr',
            'germany' => 'de',
            'spain' => 'es',
            'italy' => 'it',
            'portugal' => 'pt',
            'england' => 'gb-eng',
            'belgium' => 'be',
            'croatia' => 'hr',
            'netherlands' => 'nl',
            'uruguay' => 'uy',
            'mexico' => 'mx',
            'united states' => 'us',
            'usa' => 'us',
            'canada' => 'ca',
            'japan' => 'jp',
            'south korea' => 'kr',
            'senegal' => 'sn',
            'morocco' => 'ma',
            'cameroon' => 'cm',
            'ghana' => 'gh',
            'tunisia' => 'tn',
            'ecuador' => 'ec',
            'qatar' => 'qa',
            'saudi arabia' => 'sa',
            'iran' => 'ir',
            'australia' => 'au',
            'costa rica' => 'cr',
            'wales' => 'gb-wls',
            'poland' => 'pl',
            'denmark' => 'dk',
            'switzerland' => 'ch',
            'serbia' => 'rs',
            'colombia' => 'co',
            'peru' => 'pe',
            'chile' => 'cl',
            'venezuela' => 've',
            'paraguay' => 'py',
            'bolivia' => 'bo',
            'panama' => 'pa',
            'jamaica' => 'jm',
            'honduras' => 'hn',
            'el salvador' => 'sv',
            'new zealand' => 'nz',
            'south africa' => 'za',
            'egypt' => 'eg',
            'nigeria' => 'ng',
            'algeria' => 'dz',
            'cote d\'ivoire' => 'ci',
            'ivory coast' => 'ci',
            'ukraine' => 'ua',
            'sweden' => 'se',
            'turkey' => 'tr',
            'scotland' => 'gb-sct',
            'austria' => 'at',
            'greece' => 'gr',
            'czechia' => 'cz',
            'czech republic' => 'cz',
            'hungary' => 'hu',
            'romania' => 'ro',
            'norway' => 'no',
            'slovakia' => 'sk',
            'finland' => 'fi',
            'ireland' => 'ie',
            'northern ireland' => 'gb-nir',
            'mali' => 'ml',
            'dr congo' => 'cd',
            'congo dr' => 'cd',
            'cape verde' => 'cv',
            'guinea' => 'gn',
            'burkina faso' => 'bf',
            'angola' => 'ao',
            'mauritania' => 'mr',
            'equatorial guinea' => 'gq',
            'namibia' => 'na',
            'zambia' => 'zm',
            'mozambique' => 'mz',
            'tanzania' => 'tz',
            'guinea-bissau' => 'gw',
            'gambia' => 'gm',
            'iraq' => 'iq',
            'jordan' => 'jo',
            'uzbekistan' => 'uz',
            'united arab emirates' => 'ae',
            'uae' => 'ae',
            'bahrain' => 'bh',
            'china' => 'cn',
            'china pr' => 'cn',
            'palestine' => 'ps',
            'syria' => 'sy',
            'tajikistan' => 'tj',
            'thailand' => 'th',
            'vietnam' => 'vn',
            'lebanon' => 'lb',
            'india' => 'in',
            'kyrgyzstan' => 'kg',
            'hong kong' => 'hk',
            'yemen' => 'ye',
            'oman' => 'om',
            'north korea' => 'kp',
            'korea republic' => 'kr',
            'korea dpr' => 'kp',
            'georgia' => 'ge',
            'slovenia' => 'si',
            'albania' => 'al',
            'trinidad and tobago' => 'tt',
            'haiti' => 'ht',
            'curacao' => 'cw',
        ];

        $code = $map[$name] ?? null;
        if ($code) {
            return "https://flagcdn.com/w40/{$code}.png";
        }
        
        return "https://placehold.co/40x30?text=" . urlencode(substr($this->nombre, 0, 3));
    }
}