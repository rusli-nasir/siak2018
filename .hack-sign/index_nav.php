<?php
  $_page = array(
    array(
      'title'=>'Gaji',
      'url'=>$_PATH.'/?page=gaji',
      'page'=>'gaji'
    ),
    array(
      'title'=>'Tunjangan',
      'url'=>$_PATH.'/#',
      'page'=>array('tunjangan','tunjangantkk'),
      'child'=>array(
                array(
                  'title'=>'Kesejaterahan',
                  'url'=>$_PATH.'/?page=tunjangan',
                  'page'=>'tunjangan'
                ),
                array(
                  'title'=>'Kinerja TKK',
                  'url'=>$_PATH.'/?page=tunjangantkk',
                  'page'=>'tunjangantkk'
                ),

              )
    ),
    array(
      'title'=>'Uang Makan',
      'url'=>$_PATH.'/?page=um',
      'page'=>'um'
    ),
    array(
      'title'=>'Insentif',
      'url'=>$_PATH.'/#',
      'page'=> array('ikw','ipp','tutam','ikwrsnd','tutamrsnd'),
      'child' => array(
        array(
          'title'=>'Insentif Kinerja Wajib',
          'url'=>$_PATH.'/?page=ikw',
          'page'=>'ikw'
        ),
        array(
          'title'=>'Insentif Perbaikan Penghasilan',
          'url'=>$_PATH.'/?page=ipp',
          'page'=>'ipp'
        ),
        array(
          'title'=>'Insentif Tugas Tambahan',
          'url'=>$_PATH.'/?page=tutam',
          'page'=>'tutam'
        ),
		array(
          'title'=>'Insentif Tugas Tambahan RSND',
          'url'=>$_PATH.'/?page=tutamrsnd',
          'page'=>'tutamrsnd'
        ),
		array(
          'title'=>'Insentif Kinerja Wajib RSND',
          'url'=>$_PATH.'/?page=ikwrsnd',
          'page'=>'ikwrsnd'
        ),
      ),
    )
  );
  $_keyPage = array('gaji', 'tunjangan', 'tunjangantkk', 'ikw', 'ikwrsnd', 'ipp', 'um', 'tutam', 'tutamrsnd');
  $_activeHome = " class=\"active\"";
  $pageNow = "";
  if(isset($_GET['page']) && in_array($_GET['page'],$_keyPage)){
    $_activeHome = "";
    $pageNow = $_GET['page'];
  }
  function goMenu($menu, $active){
    foreach ($menu as $k => $v) {
      if(isset($v['child']) && count($v['child'])>0){
        if(strlen(trim($active))>0 && in_array($active,$v['page'])){
          $_active[$k] = " active";
        }else{
          $_active[$k]="";
        }
        echo "<li class=\"dropdown".$_active[$k]."\"><a href=\"".$v['url']."\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" aria-expanded=\"false\">".$v['title']."<span class=\"caret\"></span></a>";
        echo "<ul class=\"dropdown-menu\" role=\"menu\">";
        echo goMenu($v['child'], $active);
        echo "</ul>";
        echo "</li>";
      }else{
        if(strlen(trim($active))>0 && $active==$v['page']){
          $_active[$k] = " class=\"active\"";
        }else{
          $_active[$k]="";
        }
        echo "<li".$_active[$k]."><a href=\"".$v['url']."\">".$v['title']."</a></li>";
      }
    }
  }
?>
<nav class="navbar navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <?php echo $_CONFIG['logo']; ?>
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
        <i class="fa fa-bars"></i>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
      <ul class="nav navbar-nav">
        <li<?php echo $_activeHome; ?>><a href="<?php echo $_PATH; ?>/">Dashboard</a></li>
      <?php
        echo goMenu($_page, $pageNow);
      ?>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
