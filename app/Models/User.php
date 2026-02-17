<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var list<string>
     */
    protected $primaryKey = 'user_id';

    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'nama',
        'email',
        'email_smtp',
        'app_password',
        'password',
        'provider',
        'provider_id',
        'avatar',
        'role',
        'is_active',
        'verification_code',
        'reset_token',
        'reset_token_expired_at',
        'email_verified_at',
        'last_login_at',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    public function getDescriptionAttribute()
    {
        return ucfirst($this->role);
    }

      public function adminlte_profile_url()
    {
        return route('dashboard'); 
        // atau route('profile') kalau nanti ada halaman profile
    }

    public function adminlte_image()
    {
        // 1. Avatar dari Google
        if ($this->provider === 'google' && $this->avatar) {
            return $this->avatar;
        }

        // 2. Avatar custom lokal
        if ($this->avatar && file_exists(public_path($this->avatar))) {
            return asset($this->avatar);
        }

        // 3. Fallback auto avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama);
    }


    public function adminlte_desc()
    {
        return ucfirst($this->role ?? 'User');
    }

    public function articles()
    {
        return $this->hasMany(Article::class, 'author_id', 'user_id');
    }

    public function likedArticles()
    {
        return $this->belongsToMany(
            Article::class,
            'article_likes',
            'user_id',    
            'article_id'  
        )->withTimestamps();
    }

    public function bookmarkedArticles()
    {
        return $this->belongsToMany(
            Article::class,
            'article_bookmarks',
            'user_id',
            'article_id'
        )->withTimestamps();
    }
    
    public function detail()
    {
        return $this->hasOne(PelamarDetail::class, 'user_id');
    }


}