<?php

namespace App\Http\Imports\Controllers;

use App\Domain\System\User\User;
use App\Http\Imports\ImportAbstract;
use Sentinel;

class ImportUsersController extends ImportAbstract
{
    public function processRecord($record)
    {
        if (User::where('email',$record['email'])->first()) {
           $this->markAsDoned($record['id'],'El email ya existe.');
        } else {
          if (Sentinel::registerAndActivate(
              [
                  'email' => $record['email'],
                  'first_name' => $record['first_name'],
                  'last_name' => $record['last_name'],
                  'password' => explode('@',$record['email'])[0]
              ]
          )) {
              $this->markAsDoned($record['id']);
          } else {
              $this->markAsDoned($record['id'],'No se pudo registrar al usuario.');
          }
        }
    }
}
