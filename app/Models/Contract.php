<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/* this is a contract model 
here we can define the rules for the model
the data will be stored in the product_user table
*/

class Contract extends Model
{
    use HasFactory;

    protected $table = 'product_user';
    protected $fillable = ['product_id', 'user_id', 'reference', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
