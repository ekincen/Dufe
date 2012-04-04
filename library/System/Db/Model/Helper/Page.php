<?php
/*
 * Created on 2011-6-10
 *
 * @author yijian.cen
 *
 */
class System_Db_Model_Helper_Page {

    public $showLimit = 10;
    public $curPage = 1;
    public $start;
    public $end;

    public function __construct() {
        $this->_getPageRequest();
    }

    public function pageData($data, $total) {
        return array(
            'data'=>$data,
            'pageIndex'=>$this->curPage,
            'pageTotal'=>(int)ceil($total/$this->showLimit)
        );
    }

    protected function _getPageRequest() {
        $this->curPage = isset($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : $this->curPage;
        $this->start = ($this->curPage  - 1) * $this->showLimit;
        $this->end = $this->start + $this->showLimit - 1;
    }
}
?>