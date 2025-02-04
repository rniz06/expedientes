<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Observers\ExpedienteObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Models\Expediente\Archivo;
use App\Models\Expediente\Comentario;
use App\Models\Expediente\Estado as ExpedienteEstado;
use App\Models\Expediente\Prioridad;
use App\Models\Expediente\TipoFuente;
use App\Models\Expediente\TipoGestion;
use App\Models\Expediente\TipoTitular;
use App\Models\Vistas\Personal as VistaPersonal;
use App\Models\Vistas\VtCompania;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([ExpedienteObserver::class])]
class Expediente extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    // Tabla asociada al modelo
    protected $table = "expedientes";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_expediente';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = [
        'expediente_asunto',
        'mesa_entrada_completa',
        'mesa_entrada_prefix_anho',
        'nro_mesa_entrada',
        'nro_mesa_entrada_anho',
        'mesa_entrada_anho',
        'tipo_fuente_id',
        'tipo_titular_id',
        'expediente_estado_id',
        'expediente_departamento_id',
        'expediente_ciudadano_id',
        'personal_id',
        'tit_compania_id',
        'tit_departamento_id',
        'agrego_usuario_id',
    ];

    // Relación: Un Expediente tiene un solo Estado
    public function estado()
    {
        return $this->belongsTo(ExpedienteEstado::class, 'expediente_estado_id');
    }

    // Relación: Un Expediente tiene un solo Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'expediente_departamento_id');
    }

    // Relación: Un Expediente tiene un solo DepartamentoTitular
    public function departamentoTitular()
    {
        return $this->belongsTo(Departamento::class, 'tit_departamento_id');
    }

    // Relación: Un Expediente tiene un solo Ciudadano
    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class, 'expediente_ciudadano_id');
    }

    // Relación: Un Expediente tiene un solo Usuario agregado
    public function agregadoPor()
    {
        return $this->belongsTo(User::class, 'agrego_usuario_id');
    }

    /**
     * Relación de "Expediente" a "Comentario" (uno a muchos).
     * Un Expediente puede tener muchos Comentarios.
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'comentario_expediente_id', 'id_expediente');
    }

    /**
     * Relación de "Expediente" a "Archivo" (uno a muchos).
     * Un Expediente puede tener agregar muchos archivos.
     */
    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'archivo_expediente_id', 'id_expediente');  // Relación "uno a muchos" con la tabla de barrios
    }

    /**
     * Relación de "TipoFuente" a "Expediente" (uno a muchos inverso).
     * Cada expediente tiene un solo tipo de fuente (INTERNA O EXTENA).
     */
    public function tipoFuente()
    {
        return $this->belongsTo(TipoFuente::class, 'tipo_fuente_id');
    }

    /**
     * Relación de "TipoTitular" a "Expediente" (uno a muchos inverso).
     * Cada expediente tiene un solo tipo de titular.
     */
    public function tipoTitular()
    {
        return $this->belongsTo(TipoTitular::class, 'tipo_titular_id');
    }

    // Relacion Con la Vista de Vt_companias de la otra base de datos
    public function companiaTitular()
    {
        return $this->belongsTo(VtCompania::class, 'tit_compania_id', 'idcompanias');
    }

    public function personalTitular()
    {
        return $this->belongsTo(VistaPersonal::class, 'personal_id', 'idpersonal');
    }

    public function mostrarNombrePersonal()
    {
        $personal_id = 7802;

        $resultado = VistaPersonal::select('nombrecompleto', 'codigo', 'categoria')
            ->where('idpersonal', $personal_id)
            ->first();

        // Verificar si hay resultados
        if ($resultado) {
            // Retornar la cadena con el formato deseado
            return $resultado->nombrecompleto . ' - ' . $resultado->codigo . ' - ' . $resultado->categoria;
        } else {
            return 'No se encontro datos del Personal'; // O cualquier otro mensaje de error si no hay resultados
        }
    }

    public function getPersonalNameAttribute()
    {
        // Asegúrate de que personal_id sea un entero
        //$id = intval($this->personal_id);
        $id = $this->personal_id;

        // Busca directamente el registro con el ID proporcionado
        $personal = VistaPersonal::find($id);

        // Devuelve el nombre completo o un valor predeterminado si no se encuentra
        return $personal ? $personal->nombrecompleto . ' - ' . $personal->codigo . ' - ' . $personal->categoria : 'No encontrado';
    }

    // Relación para departamentos con copia
    public function departamentosConCopia()
    {
        return $this->belongsToMany(
            Departamento::class,
            'expedientes_departamentos_concopia', // nombre de la tabla pivote
            'expediente_id',                      // clave foránea del modelo actual
            'departamento_id'
        )                    // clave foránea del modelo relacionado
            ->withTimestamps();                   // si tienes timestamps en la tabla pivote
    }
}
