<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        상품관리
      </h1>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-xs-12 text-right">
            <div class="form-group">
                <a class="btn btn-primary" href="<?php echo base_url(); ?>addshop"><i class="fa fa-plus"></i>상품 등록</a>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12">
           <form name="frmList" id="frmList" method="get" action="<?=base_url("shopProducts")?>"> 
            <div class="box-tools">   
              <div class="input-group" style="margin-bottom: 10px">
                <div class="pull-right">
                  <label style="display:block; ">&nbsp;</label>
                  <input class="btn btn-primary btn-sm" value="검색" type="submit">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">브랜드</label>
                  <input type="text" name="brands" class="form-control input-sm" style="width: 150px;" 
                   value="<?=empty($_GET['brands']) == 0 ? $_GET['brands']:"" ?>" >
               </div> 
               <div class="pull-right">
                 <label style="display:block; ">상품명</label>
                  <input type="text" name="search_pname"  class="form-control input-sm" style="width: 150px;" value="<?=empty($_GET['search_pname']) == 0 ? $_GET['search_pname']:"" ?>">
               </div> 
               <div class="pull-right">
                  <label style="display:block; ">진행여부</label>
                  <select name="shUseYn" id="shUseYn" class="form-control input-sm">
                    <option value="">=== 전체 ===</option>
                    <option value="1" <?=$this->input->get("shUseYn") !=null && $this->input->get("shUseYn")==1 ? "selected":""?>>진행중</option>
                    <option value="0" <?=$this->input->get("shUseYn") !=null && $this->input->get("shUseYn")==0 ? "selected":""?>>중지</option>
                  </select>
               </div>
               <div class="pull-right">
                 <label style="display: block;">Page</label>
                 <select name="shPageSize" id="shPageSize" class="form-control input-sm">
                    <?php for($ii = 10 ;$ii<=100;$ii+=5){ ?>
                      <option value="<?=$ii?>" <?=empty($_GET['shPageSize'])==0 && $_GET['shPageSize']==$ii ? "selected":"" ?>><?=$ii?></option>
                    <?php }  ?>
                  </select>
               </div>
              </div>
            </div>
          </form>
          <div class="box">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <colgroup>
                  <col wdith="*"></col>
                  <col wdith="62"></col>
                  <col width="300x"></col>
                </colgroup>
                <tr class="thead-dark">
                  <th class="text-center">No</th>
                  <th></th>
                  <th class="text-left">상품명</th>
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
                      <td>
                        <img src="/upload/shoppingmal/<?=$value->id?>/<?=$value->image?>" width="60" height="60">
                      </td>
                      <td class="text-left">
                        <span><?=$value->name?></span>
                      </td>
                      <td class="text-center"><?=$value->brand?>/<?=$value->wonsanji?></td>
                      <td class="text-center"><?=$value->orgprice?> / <?=$value->singo?>(원)</td>
                      <td class="text-center"><?=$value->point?></td>
                      <td class="text-center"><?=$value->p_salecnt?></td>
                      <td class="text-center"><?=$value->weight?></td>
                      <td class="text-center"><?=$value->use==0 ? "숨김":"노출" ?></td>
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
<script type="text/javascript">
  jQuery(document).on("click", ".deletesproduct", function(){
    var spid = $(this).data("spid"),
      hitURL = baseURL + "deletesproduct",
      currentRow = $(this);
    
    var confirmation = confirm("정말 삭제하시게습니까?");
    
    if(confirmation)
    {
      jQuery.ajax({
      type : "POST",
      dataType : "json",
      url : hitURL,
      data : { spid : spid} 
      }).done(function(data){
        currentRow.parents('tr').remove();
        if(data.status = true) { alert("성곡적으로 삭제되였습니다."); }
        else if(data.status = false) { alert("삭제 오유! 상품이 존재하지 않습니다."); }
        else { alert("접근요청 거절!"); }
      });
    }
  });
  
</script>