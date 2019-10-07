<?php
class GetPages
{
    public $filesCount;
    public $pagesCount;
    private $path;

    function __construct($path)
    {
        $this->path = $path;
        $this->GetPagesCount();
    }

    private function GetFilesCount($path)
    {
        $files = scandir($path);
        $filesCount = count($files);
        $this->filesCount = $filesCount - 2; // first two files it's a '.' and '..'
    }

    private function GetPagesCount()
    {
        $this->GetFilesCount($this->path);

        $this->pagesCount = $this->filesCount / 15;
        $this->pagesCount = (int)$this->pagesCount;

        if($this->pagesCount == 0)
            $this->pagesCount = 1;
        else
        {
            $lastPageCount = $this->filesCount % 15;
            if($lastPageCount != 0)
                $this->pagesCount += 1;
        }
    }

    public function GetPagesArray()
    {
        $arr = array();
        $num = 1;
        for($i = 0; $i < $this->pagesCount ;$i++)
        {
            $arr[$i] = "<li onclick=\"CreateDivElem(this)\"><a href=\"#\">$num</a></li>";
            $num++;
        }
        return $arr;
    }
}



