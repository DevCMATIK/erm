<?php

if (!function_exists('makeLinkRemote')) {
    function makeLinkRemote()
    {
        return ' data-toggle="modal" data-target="#remoteModal" ';
    }
}

if (!function_exists('makeLink')) {
    function makeLink($url,$caption,$icon = '',$color = 'btn-primary',$size = 'btn-md',$grouped = false)
    {
        return getButton([
            'color' => $color,
            'url' => $url,
            'caption' => $caption,
            'size' => $size,
            'icon' => $icon,
            'grouped' => $grouped
        ]);
    }
}

if (!function_exists('makeRemoteLink')) {
    function makeRemoteLink($url,$caption,$icon = '',$color = 'btn-primary',$size = 'btn-md',$grouped = false)
    {
        return getButton([
            'color' => $color,
            'url' => $url,
            'caption' => $caption,
            'size' => $size,
            'grouped' => $grouped,
            'icon' => $icon,
            'remote' => true
        ]);
    }
}

if (!function_exists('makeAddLink')) {
    function makeAddLink($url = '',$remote = true)
    {
        $variables = '';
        if ($url == '') {
            $url = explode('.',Route::currentRouteName())[0];
            $variables = explode('?',url()->full());
            $variables = (isset($variables[1]))? '?'.$variables[1]:'';
        }
        if(Sentinel::getUser()->hasAccess([$url.".create"])) {
            if($remote) {
                return makeRemoteLink('/'.$url.'/create'.$variables,'Agregar Nuevo','fa-plus','btn-primary','btn-sm');
            } else {
                return makeLink('/'.$url.'/create'.$variables,'Agregar Nuevo','fa-plus','btn-primary','btn-sm');
            }
        } else {
            return '';
        }

    }
}

if (!function_exists('makeEditButton')) {
    function makeEditButton($id,$url = '',$remote = true,$grouped = false)
    {
        if ($url == '') {
            $url = explode('.',Route::currentRouteName());
            if($url[0] == 'datatable') {
                $url = $url[1];
            } else {
                $url = $url[0];
            }
        }
        if(Sentinel::getUser()->hasAccess([$url.".update"])) {
            if($remote) {
                return makeRemoteLink('/'.$url.'/'.$id.'/edit','Modificar','fa-pencil-alt','btn-warning','btn-sm',$grouped);
            } else {
                return makeLink('/'.$url.'/'.$id.'/edit','Modificar','fa-pencil-alt','btn-warning','btn-sm',$grouped);
            }
        } else {
            return '';
        }

    }
}

if (!function_exists('makeLinkOnClick'))
{
    function makeLinkOnClick($url,$caption,$icon = '',$color = 'btn-primary',$size = 'btn-md',$grouped = false,$onClick = '')
    {
        return getButton([
            'color' => $color,
            'url' => $url,
            'caption' => $caption,
            'size' => $size,
            'grouped' => $grouped,
            'icon' => $icon,
            'onClick' => $onClick
        ]);
    }
}

if (!function_exists('makeDeleteButton')) {
    function makeDeleteButton($texto,$id,$aditionals = false,$url = '',$grouped = false)
    {
        if ($url == '') {
            $access = explode('.',Route::currentRouteName());
            if($access[0] == 'datatable') {
                $access = $access[1];
            } else {
                $access = $access[0];
            }
        } else {
            $access = str_replace('/','.',$url);
        }
        if($aditionals == 'grantPermission') {
            $aditionals = '';
            if ($url == '') {
                $finalUrl = $access;
            } else {
                $finalUrl = $url;
            }
            $url = '/' . $finalUrl. '/' . $id;
            $onClick = 'deleteRecord(\'' . $texto . '\',\'' . $url . '\',' . $aditionals . ')';
            return makeLinkOnClick('javascript:void(0);', 'Eliminar', 'fa-trash-alt', 'btn-danger', 'btn-sm', $grouped, $onClick);
        } else {
            if (Sentinel::getUser()->hasAccess([$access.".delete"])) {
                if ($url == '') {
                    $finalUrl = $access;
                } else {
                    $finalUrl = $url;
                }
                $url = '/' . $finalUrl. '/' . $id;
                $onClick = 'deleteRecord(\'' . $texto . '\',\'' . $url . '\',' . $aditionals . ')';
                return makeLinkOnClick('javascript:void(0);', 'Eliminar', 'fa-trash-alt', 'btn-danger', 'btn-sm', $grouped, $onClick);
            } else {
                return '';
            }
        }

    }
}

if (!function_exists('getButton')) {
    function getButton($options)
    {
        if (!is_array($options)) {
            throw new Exception("Button options are not an array.");
        }
        if (!isset($options['url']) || trim($options['url']) == '') {
            throw new Exception('URL property must be added');
        }
        if (!isset($options['caption'])) {
            throw new Exception('Caption property must be added');
        }
        $html = '<a href="'.$options['url'].'"'.
                ' class="';
        if (isset($options['grouped']) && $options['grouped'] == true) {
            $html = $html . 'dropdown-item';
        } else {
            $html = $html . 'btn '.$options['color'].' '.$options['size'];
        }
        $html = $html .'"';
        if (isset($options['remote']) && $options['remote'] == true) {
            $html = $html . makeLinkRemote();
        }
        if (isset($options['onClick']) && $options['onClick'] != '') {
            $html = $html. ' onClick="'.$options['onClick'].'"';
        }
        $html = $html. '>';
        if (isset($options['icon']) && trim($options['icon']) != '') {
            $html = $html.'<i class="fas '.$options['icon'].'"></i>';
        }
        return  $html.' '.$options['caption'].'</a>';
    }
}

if (!function_exists('makeGroupedLinks')) {
    function makeGroupedLinks($buttons)
    {
        if (is_array($buttons)) {
            $html = '<div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-default px-2 dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" data>
                        ···
                    </button>
                    <div class="dropdown-menu">';
            foreach ($buttons as $button) {
                  $html = $html. $button;
            }
            return $html . '</div></div>';
        } else {
            throw new Exception("Buttons must be an array");
        }
    }
}
