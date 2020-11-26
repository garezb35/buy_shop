<?php 
  $name = "";
  $phone = "";
  $fax = "";
  $site = "";
  if(!empty($company)): 
    foreach($company as $value):
      $name = $value->name;
      $phone = $value->phone;
      $fax = $value->fax;
      $site = $value->site;
    endforeach;
  endif; 
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          업체정보변경  
      </h1>
    </section>
    <section class="content">
        <form action="./saveCompany" method="post">
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>회사명</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="name" class="form-control" value="<?=$name?>">
            </div>
          </div>
          <div class="row my-3">
            <div class="col-md-2 text-center">
              <p>전화</p>
            </div>
            <div class="col-md-4">
              <input type="text" name="phone" class="form-control" value="<?=$phone?>">    
            </div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>팩스</p></div>
              <div class="col-md-4"><input type="text" name="fax" id="fax" maxlength="60" class="form-control" value="<?=$fax?>"></div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center"><p>사이트 제목</p></div>
              <div class="col-md-4"><input type="text" name="site" id="site" maxlength="60" class="form-control" value="<?=$site?>"></div>
          </div>
          <div class="row my-3">
              <div class="col-md-2 text-center">
                  <input type="submit" class="btn btn-primary" value="저장">
                  <input type="reset" class="btn" value="취소">
              </div>
          </div>
        </form>
    </section>
</div>
