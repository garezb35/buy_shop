<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품찜관리
      </h1>
    </section>
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url()?>product_wish"> 
            <input type="hidden" name="p_category" id="p_category" value="<?=empty($_GET['p_category']) == 0 ? $_GET['p_category']:"" ?>">
            <input type="hidden" name="step2" id="step2" value="<?=empty($_GET['step2']) == 0 ? $_GET['step2']:"" ?>">
            <input type="hidden" name="step3" id="step3" value="<?=empty($_GET['step3']) == 0 ? $_GET['step3']:"" ?>">
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right" style="margin-left: 10px">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">3차분류</label>
                  <select name="p_category3" id="p_category3" class="form-control input-sm category_select" data-step="3">
                    <option value="">=== 선택 ===</option>
                    <?php if(!empty($category3)): ?>
                    <?php foreach($category3 as $value): ?>
                    <option value="<?=$value->id?>" <?=$this->input->get("p_category3")==$value->id ? "selected":""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select> 
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">2차분류</label>
                  <select name="p_category2" id="p_category2" class="form-control input-sm category_select" data-step="2">
                    <option value="">=== 선택 ===</option>
                    <?php if(!empty($category2)): ?>
                    <?php foreach($category2 as $value): ?>
                    <option value="<?=$value->id?>" <?=$this->input->get("p_category2")==$value->id ? "selected":""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>               
                </div> 
               <div class="pull-right">
                  <label style="display:block; ">1차분류</label>
                   <select name="p_category1" id="p_category1" class="form-control input-sm category_select" data-step="1">
                    <option value="">=== 선택 ===</option>
                    <?php if(!empty($category)): ?>
                    <?php foreach($category as $value): ?>
                    <option value="<?=$value->id?>" <?=$this->input->get("p_category1")==$value->id ? "selected":""?>><?=$value->name?></option>
                    <?php endforeach;?>
                    <?php endif; ?>
                  </select>
               </div> 
               
               <div class="pull-right">
                 <label style="display:block; ">상품코드</label>
                  <input type="text" name="p_code"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['p_code']) == 0 ? $_GET['p_code']:"" ?>">
               </div>  
               <div class="pull-right">
                 <label style="display:block; ">상품명</label>
                  <input type="text" name="p_name"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['p_name']) == 0 ? $_GET['p_name']:"" ?>">
               </div>
               <div class="pull-right"> 
                  <label style="display:block; ">신상품</label>
                  <select name="p_newview" id="p_newview" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("p_newview") !=null && $this->input->get("p_newview")==1 ? "selected":""?>>노출</option>
                    <option value="0" <?=$this->input->get("p_newview") !=null && $this->input->get("p_newview")==0 ? "selected":""?>>숨김</option>
                  </select>
               </div>
               <div class="pull-right"> 
                  <label style="display:block; ">세일상품</label>
                  <select name="p_saleview" id="p_saleview" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("p_saleview") !=null && $this->input->get("p_saleview")==1 ? "selected":""?>>노출</option>
                    <option value="0" <?=$this->input->get("p_saleview") !=null && $this->input->get("p_saleview")==0 ? "selected":""?>>숨김</option>
                  </select>
               </div>
               <div class="pull-right"> 
                  <label style="display:block; ">베스트상품</label>
                  <select name="p_bestview" id="p_bestview" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("p_bestview") !=null && $this->input->get("p_bestview")==1 ? "selected":""?>>노출</option>
                    <option value="0" <?=$this->input->get("p_bestview") !=null && $this->input->get("p_bestview")==0 ? "selected":""?>>숨김</option>
                  </select>
               </div>
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th class="text-center">상품명</th>
                  <th class="text-center">브랜드/원산지</th>
                  <th class="text-center">수입원가/판매가/할인가</th>
                  <th class="text-center">적립포인트</th>
                  <th class="text-center">판매수</th>
                  <th class="text-center">무게</th>
                  <th class="text-center">노출여부</th>
                  <th class="text-center">등록일</th>
                  <th></th>
                </tr>
                <?php if(!empty($products)): ?>
                  <?php foreach($products as $value): ?>
                    <tr>
                      <td class="text-center"><?=$value->id?></td>
                      <td class="text-center">
                        <img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->i1?>" width="60">
                        <?=$value->name?></td>
                      <td class="text-center"><?=$value->brand?>/<?=$value->wonsanji?></td>
                      <td class="text-center"><?=$value->singo?>/<?=$value->orgprice?><br><?=$value->orgprice+$value->addprice?>원</td>
                      <td class="text-center"><?=$value->point?></td>
                      <td class="text-center"><?=$value->count?></td>
                      <td class="text-center"><?=$value->weight?></td>
                      <td class="text-center"><?=$value->use==0 ? "중지":"사용" ?></td>
                      <td class="text-center"><?=$value->updated_date ?></td>
                      <td>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'editsproduct/'.$value->id; ?>">
                            <i class="fa fa-pencil"></i></a>
                          <a class="btn btn-sm btn-danger deletesproduct" href="#" data-spid="<?php echo $value->id; ?>">
                            <i class="fa fa-trash"></i></a></td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              <?php echo $this->pagination->create_links(); ?>
            </div>
          </div><!-- /.box -->
        </div>
      </div>
    </section>
</div>


<script>
  $(".category_select").change(function() {
      $("#p_category").val($(this).val());
      if($(this).data("step") !=3)
      {
        var temp = $(this).data("step")+1;
        $("#step"+temp).val($(this).val());
        if(temp ==2)
        {
          $("#step3").val("");
          $("#p_category3").html("");
          $("#p_category3").append( new Option("선택",""));
        }
        if($(this).val().trim() ==""){
          $("#p_category"+temp).html("");
          $("#p_category"+temp).append( new Option("선택","") );
          return;
        }
        jQuery.ajax({
          type : "POST",
          dataType : "json",
          url : baseURL+"getshopcategory",
          data : { id : $(this).val(),type:"list"  } 
          }).done(function(data){

            $("#p_category"+temp).html("");
            $("#p_category"+temp).append( new Option("선택","") );
            if(data.result.length > 0)
              $.each(data.result,function(index,value){
                $("#p_category"+temp).append( new Option(value.name,value.id) );
              })
          });
      }
  });         
</script>