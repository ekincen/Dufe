<?php
/*
 * Creted on 2011-3-9
 *
 * @author yijian.cen
 *
 */
class System_View_Helper_Pagination extends System_View_Helper_Abstract {

	public function pagination($pageIndex,$pageTotal,$class='to-page') {
		if($pageIndex<=$pageTotal){
			ob_start();
			?>
            <div class="page-list txt-ct <?php echo $class;?>">
			<?php
			if($pageIndex!==$pageTotal){
				?>
				<a class="next" href="javascript:void(0);">下一页</a>
				<?php
			}
			if($pageTotal>7){ //大于7个时
				if($pageIndex<7){ //前6个
				?>

				<a class="num" href="javascript:void(0);"><?php echo $pageTotal;?></a>
				<span class="rt">...</span>
				<?php for($i=6;$i>0;$i--){ ?>
				<a class="num <?php if($pageIndex==$i){ ?>active<?php } ?>" href="javascript:void(0);"><?php echo $i;?></a>
				<?php }

				}else if($pageIndex>($pageTotal-7)){  //后6个
				for($i=$pageTotal;$i>$pageTotal-7;$i--){ ?>
				<a class="num <?php if($pageIndex==$i){ ?>active<?php } ?>" href="javascript:void(0);"><?php echo $i;?></a>
				<?php } ?>
				<span class="rt">...</span>
				<a class="num" href="javascript:void(0);">1</a>

				<?php
				}else{ //中间5个
				?>
				<a class="num" href="javascript:void(0;"><?php echo $pageTotal;?></a>
				<span class="rt">...</span>
				<?php for($i=$pageIndex+2;$i>$pageIndex;$i--){ ?>
				<a class="num" href="javascript:void(0);"><?php echo $i;?></a>
				<?php } ?>
				<a class="num active" href="javascript:void(0);"><?php echo $pageIndex;?></a>
				<?php for($i=$pageIndex-1;$i>=$pageIndex-2;$i--){ ?>
				<a class="num" href="javascript:void(0);"><?php echo $i;?></a>
				<?php } ?>
				<span class="rt">...</span>
				<a class="num" href="javascript:void(0);">1</a>

				<?php
				}
			}else if($pageTotal>1){  //小于7个时
			    for($i=$pageTotal;$i>0;$i--){
			    ?>
			    <a class="num <?php if($pageIndex==$i){ ?>active<?php } ?>" href="javascript:void(0);"><?php echo $i;?></a>
			    <?php
			    }
			}
			if($pageIndex!==1){
				?>
				<a class="prev" href="javascript:void(0);">上一页</a>
				<?php
			}
			?>
			    <div class="clear"></div>
            </div>
			<?php
			$html=ob_get_contents();
			ob_end_clean();
			return $html;
		}
	}
}
?>