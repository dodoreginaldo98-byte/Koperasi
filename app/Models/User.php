<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
 use HasFactory, Notifiable;
 protected $fillable = [
 'name',
 'email',
 'password',
    'role',
    'is_active',
 ];
 protected $hidden = [
 'password',
 'remember_token',
 ];
 protected function casts(): array
 {
 return [
 'email_verified_at' => 'datetime',
 'password' => 'hashed',
 'is_active' => 'boolean',
 ];
 }
 public function simpananDibuat(): HasMany
 {
 return $this->hasMany(Simpanan::class, 'dibuat_oleh');
 }
 public function simpananDiverifikasi(): HasMany
 {
 return $this->hasMany(Simpanan::class, 'diverifikasi_oleh');
 }
 public function isAdmin(): bool
 {
 return $this->role === 'admin';
 }
}