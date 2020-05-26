<?php

namespace App\Http\System\DataTable;

use App\App\Controllers\Controller;
use Sentinel;

abstract class DataTableAbstract extends Controller
{
    public $filter;
    public $entity = false;
	public abstract function getRecords();
	public abstract function getRecord($record);

	public function getData($variables = false)
	{
	    if($variables) {
	        $this->filter = $variables;
        }
		$records = $this->getRecords();
		$data = array();
		$i = 1;

		if($this->getChecked()) {
            foreach ($records as $record) {
                $aux = $this->getRecord($record);
                array_unshift($aux,$record->id);
                array_push($data,$aux);
            }
        } else {
            foreach ($records as $record) {
                $aux = $this->getRecord($record);
                array_unshift($aux,$i);
                array_push($data,$aux);
                $i++;
            }
        }

		$json = array('data' => $data);
		return json_encode($json);
	}

    public function getOptionButtons($id)
    {
        if ($this->entity) {
            return makeGroupedLinks($this->getDefaultOptions($id));
        }
        return  '-';
    }

    public function getDefaultOptions($id)
    {
        $user = Sentinel::getUser();
        if ($user->hasAnyAccess([$this->entity.'.update',$this->entity.'.delete'])) {
            return [
                makeEditButton($id,'',true,true),
                makeDeleteButton("Realmente desea eliminar el Registro?",$id,"'reload'",'',true),
            ];

        } else {
            return [];
        }
    }

	public function getChecked()
    {
        return false;
    }
}
