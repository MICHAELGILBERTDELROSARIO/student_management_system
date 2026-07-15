<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_STUDENT = 'student';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_USER = 'user';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_STUDENT,
        self::ROLE_EDITOR,
        self::ROLE_USER,
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN || $this->hasRole('Admin');
    }

    public function isStudent(): bool
    {
        return $this->role === self::ROLE_STUDENT || $this->hasRole('Student');
    }

    public function isEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR || $this->hasRole('Editor');
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'admin.dashboard',
            self::ROLE_EDITOR => 'editor.dashboard',
            default => 'student.dashboard',
        };
    }

    protected static function booted(): void
    {
        static::saved(function (self $user) {
            $role = match ($user->role) {
                self::ROLE_ADMIN => 'Admin',
                self::ROLE_EDITOR => 'Editor',
                default => 'Student',
            };

            $user->syncRoles([Role::firstOrCreate(['name' => $role])]);
        });
    }
}
