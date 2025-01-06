<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Expediente\Archivo as ExpedienteArchivo;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'departamento_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación: Un Usuario Puede agregar varios Expedientes
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    // Relación: Un Usuario Puede agregar varios Comentarios de Expedientes
    public function expedientesComentarios()
    {
        return $this->hasMany(ExpedienteComentario::class, 'creador_usuario_id');
    }

    // Relación: Un Usuario Puede actualizar el comentario de un expediente
    public function expedienteComentarioActualizacion()
    {
        return $this->hasMany(ExpedienteComentario::class, 'actualizacion_usuario_id');
    }

    /**
     * Relación de "User" a "ExpedienteArchivos" (uno a muchos).
     * Un User puede tener agregar muchos archivos.
     */
    public function expedientesArchivos()
    {
        return $this->hasMany(ExpedienteArchivo::class);  // Relación "uno a muchos" con la tabla de barrios
    }

    /**
     * Relación de "User" a "Ciudadano" (uno a muchos).
     * Un User puede agregar muchos Ciudadanos.
     */
    public function ciudadanos()
    {
        return $this->hasMany(Ciudadano::class);
    }

    /**
     * Relación de "User" a "Departamento" (uno a muchos inverso).
     * Cada Usuario pertenece a un Departamento.
     */
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }
}
