<?php

class MCLinkPager extends CLinkPager
{
	public $containerTag = 'ul';
	public $linkTag = 'li';
	
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		//echo $this->header;
		echo CHtml::tag($this->containerTag,$this->htmlOptions,$this->header.implode("\n",$buttons));
		echo $this->footer;
	}
	
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        return (!empty($this->linkTag)?CHtml::openTag($this->linkTag,array('class'=>$class)):'').
                CHtml::link($label,$this->createPageUrl($page),array('class'=>$class)).
                (!empty($this->linkTag)?CHtml::closeTag($this->linkTag):'');
	}
	
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		if($this->firstPageLabel) $buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		if($this->prevPageLabel && $page!==$currentPage) $buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		if($this->nextPageLabel && $page!==$currentPage) $buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		if($this->lastPageLabel) $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}
}