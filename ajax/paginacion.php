<?php 
    function paginate($reload, $page, $tpages, $adjacents){
        $prevlabel = "&lsaquo; Anterior";
        $nextlabel = "Siguiente &rsaquo;";
        $out = '<ul class="pagination custom-class">';
        //Btn anterior
        if($page==1){
            $out.="<li class='disabled'><span><a>$prevlabel</a></span></li>";
        } elseif($page==2){
            $out.="<li><span><a href='javascript:void(0);' onclick='load(1)'>$prevlabel</a></span></li>";
        }
        else{
            $out.="<li><span><a href='javascript:void(0);' onclick='load(".($page-1).")'>$prevlabel</a></span></li>";
        }

        if($page>($adjacents+1)){
            $out.="<li><a href='javascript:void(0);' onclick='load(1)'>1</a></li>";
        }
        
        if($page>($adjacents+2)){
            $out.="<li><a>...</a></li>";
        }

        //páginas
        $pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
        $pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
        for($i=$pmin; $i<=$pmax; $i++){
        if($i==$page){
            $out.="<li class='active'><a>$i</a></li>";
        }elseif($i==1){
            $out.="<li><a href='javascript:void(0);' onclick='load(1)'>$i</a></li>";
        }else {
            $out.="<li><a href='javascript:void(0);' onclick='load(".$i.")'>$i</a></li>";
        }
    }

        //intervalos
        if($page<($tpages-$adjacents-1)){
            $out.="<li><a>...</a></li>";
        }
        //anterior
        if($page<($tpages-$adjacents)){
            $out.="<li><a href='javascript:void(0);' onclick='load($tpages)'>$tpages</a></li>";
        }
        //Siguientes
        if($page<$tpages){
            $out.="<li><span><a href='javascript:void(0);' onclick='load(".($page+1).")'>$nextlabel</a></span></li>";
        }else{
            $out.="<li class='disabled'><span><a>$nextlabel</a></span></li>";
        }

        $out.="</ul>";
        return $out;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <style>
        .pagination.custom-class {
            display: inline-block;
            padding-left: 0;
            margin: 20px 0;
            border-radius: 4px;
        }

        .pagination.custom-class > li {
            display: inline;
        }

        .pagination.custom-class > li > a,
        .pagination.custom-class > li > span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #428bca;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

    </style>
</head>
<body>
</body>
</html>