<?php

namespace lbs\auth\models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{

  protected $table = 'commande';
  protected $primaryKey = 'id';
  public $timestamps = true;
  public $incrementing = false;
  protected $keyType = 'string';

}