<?php
namespace Tmdan\ApiLogger\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLogger extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_full_url',
        'request_method',
        'request_body',
        'request_header',
        'request_ip',
        'request_agent',
        'response_content',
        'response_status_code',
        'user_id',
        'user_timezone',
    ];

    protected $casts = [
        'request_header' => 'array',
        'request_body' => 'array',
        'response_content' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
