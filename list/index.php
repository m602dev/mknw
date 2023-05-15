<!-- 
cookie 
- list_sql
- list_return_url
- list_return_colno
- list_return_paranm
-->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.5">   
    <title>選択画面</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>	
    <?php

        $SV = "*******aws.com";
        $cnAWS = new mysqli($SV, '****', '****', '****');
        if ($cnAWS->connect_error) {
          echo $cnAWS->connect_error;
          exit();
        } else {
          $cnAWS->set_charset("utf8");
        }    
    
        $sql = $_COOKIE['list_sql'];
        $rs = $cnAWS->query($sql);      

        $data = array();
        while ($row = $rs->fetch_assoc()) {
            $data[] = $row;
        }    

        //ヘッダー処理
        $headers  = array_keys($data[0]);
        $return_colno = 0;
        echo "<div class='table-responsive'>
                <table class='table table-striped  table-hover'>
                    <thead class='sticky-top'>
                        <tr>";
        for($i=0; $i<count($headers); ++$i){if($i == $_COOKIE['list_return_colno']) $return_colno = $i; echo "<th>{$headers[$i]}</th>";}
        echo "	            <th></th>
                        </tr>
                    </thead>	
                    <tbody>				
        ";

        //中身作成
        for($r=0; $r<count($data); ++$r){
            echo "<tr onclick='topage(\"{$_COOKIE['list_return_paranm']}\",\"{$data[$r][$headers[$return_colno]]}\",\"{$_COOKIE['list_return_url']}\")'>";
            for($h=0; $h<count($headers); ++$h){
                echo "<td>".$data[$r][$headers[$h]]."</td>";
                if(($h+1) == count($headers)) echo "<td><button type='button' class='btn btn-secondary'>選択</button></td>";
            }
            echo "</tr>";            
        }         

		echo "
				</tbody>
			</table>
		</div>";        
    ?>
  </body>
  <script>
    function topage(key,val,motourl){
        let url = new URL(motourl);
        let params = url.searchParams;
        params.set(key,val);
        location.href = url.href;        
    }
  </script>
</html>
