<?php
/*
 *  Includes a set of CSS sheets
 */
if (!function_exists('includeCss')) {
    function includeCss(...$sheets)
    {
        $sheets = collect(\Illuminate\Support\Arr::flatten($sheets));

        return $html = $sheets->reduce(function($html, $sheet){
                return $html . '<link rel="stylesheet" media="screen, print" type="text/css" href="'.asset($sheet).'">';
        });
    }
}
/*
 *  Includes a set of scripts
 */
if (!function_exists('includeScript')) {
    function includeScript(...$scripts)
    {
        $scripts = collect(\Illuminate\Support\Arr::flatten($scripts));

        return $html = $scripts->reduce(function($html, $script){
            return $html . '<script  src="'.asset($script).'"></script>';
        });
    }
}
/*
 *  check if $route is the current active Route
 */
if (!function_exists('isActiveRoute')) {
    function isActiveRoute($route)
    {
        if (Route::currentRouteName() == $route) {
            return true;
        }

        return false;
    }
}
/*
 * get Numbers in Alpha notation
 */
if (!function_exists('numToAlpha')) {
    function numToAlpha($number)
    {
        if (is_numeric($number)) {
            $number = intval($number);
            $letter = '';
            if ($number > 0) {
                while ($number != 0) {
                    $p = ($number -1 ) % 26;
                    $number = intval(($number - $p) / 26);
                    $letter = chr(65 + $p) . $letter;
                }
            }
            return $letter;
        } else {
            throw new Exception('Variable must be numeric.');
        }
    }
}

if (!function_exists('getFormattedDate')) {
    function getFormattedDate($date)
    {
        if (stristr($date,'/')) {
            $delimiter = '/';
        } elseif (stristr($date,'.')) {
            $delimiter = '.';
        } else {
            $delimiter = '-';
        }
        $auxArray = explode($delimiter,$date);
        if (is_array($auxArray) && count($auxArray) == 3) {
            if (strlen($auxArray[0]) == 4) {
                $auxArray[1] = substr("0{$auxArray[1]}", -2);
                $auxArray[2] = substr("0{$auxArray[2]}", -2);
                return implode('-',$auxArray);
            } else {
                $auxArray[0] = substr("0{$auxArray[0]}", -2);
                $auxArray[1] = substr("0{$auxArray[1]}", -2);
                return implode('-',array_reverse($auxArray));
            }
        } else {
            return null;
        }
    }
}

if (!function_exists('makeValidation')) {
    function makeValidation($form,$url,$onSuccess = '')
    {
        return view('components.forms.ajax-form',compact(['form','url','onSuccess']));
    }
}

if (!function_exists('getMainMenuItems')) {
    function getMainMenuItems()
    {
        return App\Domain\System\Menu\Menu::getNested();
    }
}

if (!function_exists('makeDefaultView')) {
    function makeDefaultView($columns,$entity,$navBar = false)
    {
        return view('components.views.crud', compact('columns','entity','navBar'));
    }
}

if(!function_exists('diffInHoursOrDays')){
    function diffInHoursOrDays($start_date,$end_date)
    {
        $sd = \Carbon\Carbon::parse($start_date);
        $ed = \Carbon\Carbon::parse($end_date);

        if($diff = $sd->diffInHours($ed) > 24) {
            return $sd->diffInDays($ed).' Días';
        }

        return $diff.' Horas';

    }
}

if(!function_exists('shortBigNumbers')) {
    function shortBigNumbers($n, $precision = 1) {
        if ($n < 1000) {
            // Anything less than a million
            $n_format = number_format($n);
        } elseif ($n >= 1000 && $n < 1000000){

            $n_format = number_format(($n / 1000), $precision,',','.') . 'K';
        }
        else  {
            // Anything less than a billion
            $n_format = number_format($n / 1000000, $precision,',','.') . 'M';
        }

        return $n_format;
    }
}

if (!function_exists('addChangeLog')) {
    function addChangeLog($description,$table = null,$old_columns = null,$new_columns = null)
    {
        \App\Domain\System\ChangeLog\ChangeLog::create([
            'user_id' => Sentinel::getUser()->id ,
            'table' => $table,
            'old_columns' => $old_columns,
            'new_columns' => $new_columns,
            'description' => $description,
            'date' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
    }
}

if (!function_exists('convertColumns')) {
    function convertColumns($columns)
    {
        $columns->toArray();
        return json_encode($columns);
    }
}


if (!function_exists('freeMemory')) {
    function freeMemory()
    {
        $ignore 	= array('GLOBALS', '_FILES', '_COOKIE', '_POST', '_GET', '_SERVER', '_ENV', 'argv', 'argc', 'ignore');
        $definedVariablesArr = array_diff_key(get_defined_vars() + array_flip($ignore), array_flip($ignore)); //user defined var(s)
        $definedVariablesArr = array_keys($definedVariablesArr); // take keys of the array ie the variable names
        foreach($definedVariablesArr AS $var) {
            ${$var} = NULL;
        }
        $definedVariablesArr = NULL;
        $var                 = NULL;
    }
}
