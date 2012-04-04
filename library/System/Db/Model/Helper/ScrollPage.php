<?php
/*
 * Created on 2011-6-10
 *
 * @author yijian.cen
 *
 */
class System_Db_Model_Helper_ScrollPage {

    public $showLimit = 10;
    public $secLimit = 3;
    public $curSection = 1;
    public $curPage = 1;
    public $start;
    public $end;

    public function __construct() {
        $this->_getPageRequest();
    }

    public function getPage($data, $total) {
        $pageType = $pageHtml = null;
        $secTotal = $total>0?(int) ceil($total / $this->showLimit):1;
        $pageTotal = (int) ceil($secTotal / $this->secLimit);

        if ($this->curSection == $secTotal || ($this->curSection % $this->secLimit == 0)) {
            if ($pageTotal !== 1) {
                //显示页码
                $modelPageList = new System_View_Helper_Pagination();
                $pageHtml = $modelPageList->pagination($this->curPage, $pageTotal);
                $pageType = 'list';
            }
        } else {
            //显示更多
            $pageHtml = '<form class="form-pagination"><div class="scroll-loading-more txt-ct">' .
                    '<img src="/assets/img/gif/loading_c.gif" style="margin-right:10px;" />正在加载....</div>' .
                    '<input type="hidden" name="section" value="' . ($this->curSection + 1) . '" />' .
                    '<input type="hidden" name="page" value="' . $this->curPage . '" /></form>';
            $pageType = 'more';
        }
        return array(
            'pageHtml' => $pageHtml,
            'pageType' => $pageType
        );
    }

    protected function _getPageRequest() {
        $this->curPage = isset($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : $this->curPage;
        $this->curSection = isset($_GET['section']) ? (int) $_GET['section'] : (($this->curPage - 1) * $this->secLimit + $this->curSection);
        $this->start = ($this->curSection - 1) * $this->showLimit;
        $this->end = $this->start + $this->showLimit - 1;
    }

}

?>