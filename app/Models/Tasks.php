<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable=['title','description','status','execution_time','user_id'];
    protected $appends = ['status_text'];

    public static $statuses=[
        'for_implementation'=>'В обработке',
        'in_process'=>'В процесе',
        'testing'=>'Тестування',
        'finished'=>'Завершен'
        ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function getStatusTextAttribute(){
        return self::$statuses[$this->status];
    }
}
