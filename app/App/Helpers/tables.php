<?php

if (!function_exists('makeTable')) {
    function makeTable($columns,$records = false,$id = 'table-generated')
    {
        $html = '<table class="datatable-demo table table-striped table-bordered" id="'.$id.'">';
        $html = $html . makeTableHeader($columns);
        if ($records) {
            $html = $html . getTableRows($columns,$records);
        }
        return $html . '</table>';
    }
}

if (!function_exists('makeTableHeader')) {
    function makeTableHeader($cols)
    {
        $html = '<thead>';
        $html = $html . '<tr>';
        $html = $html .'<th>Id</th>';

        for($i = 0;$i<count($cols);$i++){
            $html = $html . '<th>';
            $html = $html . ucwords(str_replace('_',' ',$cols[$i]));
            $html = $html . '</th>';
        }

        $html = $html . '</tr>';
        return $html . '</thead>';
    }
}

if (!function_exists('makeTableRows')) {
    function makeTableRows($columns,$records)
    {
        $x = 1;
        $html = '<tbody>';
        foreach ($records as $r){
            $html = $html . '<tr>';
            $html = $html . '<td>'.$x.'</td>';
            for($i = 0;$i<count($columns);$i++){
                $html = $html . '<td>';
                $html = $html . $r[$i];
                $html = $html . '</td>';
            }
            $html = $html . '</tr>';
            $x++;
        }
        return $html . '</tbody>';
    }
}

if (!function_exists('getTableScript')) {
    function getTableScript($id = 'table-generated')
    {
        return "<script>
                    let table".\Illuminate\Support\Str::slug($id,'_')." = $('#" . $id . "').DataTable({
                        pageLength: 25,
                        responsive : true       
                    });
                </script>";
    }
}

if (!function_exists('getAjaxTable')) {
    function getAjaxTable($url,$id = 'table-generated')
    {
        return "<script>
                    let table = $('#" . $id . "').DataTable({
                        pageLength: 25,
                        responsive : true,
                        ajax: '/datatable/". $url . "/'            
                    });
                    
                    function tableReload() {
                        table.ajax.reload( false, false );
                    } 
                </script>";
    }
}

if (!function_exists('getAjaxTable2')) {
    function getAjaxTable2($url,$id = 'table-generated')
    {
        $unique = rand(0,12000);
        return "<script>
                    let table".$unique." = $('#" . $id . "').DataTable({
                        pageLength: 25,
                        responsive : true,
                        ajax: '/datatable/". $url . "/'            
                    });
                    
                    function tableReload2() {
                        table".$unique.".ajax.reload( false, false );
                    } 
                </script>";
    }
}

